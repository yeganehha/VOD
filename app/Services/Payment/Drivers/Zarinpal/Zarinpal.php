<?php

namespace App\Services\Payment\Drivers\Zarinpal;

use App\Services\Helper;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\DTOs\PaymentResult;
use App\Services\Payment\GatewayDriver;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

class Zarinpal extends GatewayDriver
{
    public CurrencyType $currency;
    public string $merchant_id;
    private ?string $authority = null;
    private ?string $feeType = null;
    private int|string|null $fee = null;
    private int|null $code = null;


    /**
     * @throws ConnectionException
     * @throws Exception
     */
    function requestPurchase(): void
    {
        $url = 'https://payment.zarinpal.com/pg/v4/payment/request.json';

        $metadata = [];

        if ($this->mobile) {
            $metadata['mobile'] = $this->mobile;
        }
        if ($this->order_id) {
            $metadata['order_id'] = $this->order_id;
        }

        $data = [
            'merchant_id' => Helper::setting('ZARINPAL_MERCHANT_ID' , $this->merchant_id),
            'currency' => $this->currency,
            'amount' => $this->amount,
            'description' => 'سفارش شماره '.$this->order_id,
            'callback_url' => $this->callbackUrl,
            'metadata' => $metadata,
        ];

        $response = Http::asJson()->acceptJson()->post($url, $data);

        $result = $response->json();
        $this->code = $result['data']['code'] ?? $result['errors']['code'];
        if ( $this->code === 100 ) {
            $this->reference_id2 = $this->authority = $result['data']['authority'];
            $this->feeType = $result['data']['fee_type'];
            $this->fee = $result['data']['fee'];
        } else {
            throw new Exception($this->message());
        }
    }

    function pay(): PaymentGatewayInterface
    {
        return $this;
    }

    function render(): HtmlString|string
    {
        return 'https://payment.zarinpal.com/pg/StartPay/'.$this->authority;
    }

    function completionPurchase(): void
    {
        $response = Http::asJson()->acceptJson()->post('https://api.zarinpal.com/pg/v4/payment/inquiry.json', [
            'merchant_id' => Helper::setting('ZARINPAL_MERCHANT_ID' , $this->merchant_id),
            'authority' => $this->authority,
        ]);
        $result = $response->json();
        $this->code = $result['data']['code'] ?? $result['errors']['code'];
        if ( isset($result['data']['status']) ) {
            if ( PayStatus::from($result['data']['status']) != PayStatus::VERIFIED ) {
                throw new Exception($this->message());
            }
        } else {
            throw new Exception($this->message());
        }
    }

    function refund(Request $request): bool
    {
        $response = Http::asJson()->acceptJson()->post('https://api.zarinpal.com/pg/v4/payment/reverse.json', [
            'merchant_id' => Helper::setting('ZARINPAL_MERCHANT_ID' , $this->merchant_id),
            'authority' => $this->authority,
        ]);
        $result = $response->json();
        return optional(optional($result['data'])['code']) === 100;
    }

    /**
     * @throws Exception
     * @throws ConnectionException
     */
    function verify(Request $request): PaymentResult
    {
        if ( $request->get('Status' , 'NOK') === 'OK') {
            $this->authority = $request->get('authority');
            $response = Http::asJson()->acceptJson()->post('https://payment.zarinpal.com/pg/v4/payment/verify.json', [
                'merchant_id' => Helper::setting('ZARINPAL_MERCHANT_ID' , $this->merchant_id),
                'amount' => $this->amount,
                'authority' => $this->authority,
            ]);
            $result = $response->json();
            $this->code = $result['data']['code'] ?? $result['errors']['code'];
            if ($this->code === 100 or $this->code === 101) {
                $result = $result['data'];
                return new PaymentResult(status: PayStatus::PAID, transactionCode: $result['ref_id'], cardMask: $result['card_pan'], cardHash: $result['card_hash']);
            } else {
                throw new Exception($this->message());
            }
        } else
            throw new Exception('پرداخت ناموفق');
    }


    public function message(): string
    {
        switch ($this->code) {
            case -9 :
                return 'خطای اعتبار سنجی';
            case -10 :
                return 'آی‌پی و یا مرچنت كد پذیرنده صحیح نیست.';
            case -11 :
                return 'مرچنت کد فعال نیست؛ لطفا با تیم پشتیبانی ما تماس بگیرید.';
            case -12 :
                return 'تلاش بیش از حد در یک بازه زمانی کوتاه';
            case -15 :
                return 'ترمینال شما به حالت تعلیق در آمده است؛ با تیم پشتیبانی تماس بگیرید.';
            case -16 :
                return 'سطح تایید پذیرنده پایین‌تر از سطح نقره‌ای است.';
            case -30 :
                return 'اجازه دسترسی به تسویه اشتراکی شناور ندارید.';
            case -31 :
                return 'حساب بانکی تسویه را به پنل اضافه کنید؛ مقادیر وارد شده برای تسهیم درست نیست.';
            case -32 :
                return 'مقادیر وارد شده برای تسهیم درست نیست و از مقدار حداکثر بیشتر است.';
            case -33 :
                return 'درصدهای وارد شده درست نیست.';
            case -34 :
                return 'مبلغ از کل تراکنش بیشتر است.';
            case -35 :
                return 'تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است.';
            case -40 :
                return 'مقادیر extra درست نیست؛ expire_in معتبر نیست.';
            case -50 :
                return 'مبلغ پرداخت شده با مقدار مبلغ در وریفای متفاوت است.';
            case -51 :
                return 'پرداخت ناموفق';
            case -52 :
                return 'خطای غیر منتظره؛ با پشتیبانی تماس بگیرید.';
            case -53 :
                return 'اتوریتی برای این مرچنت کد نیست.';
            case -54 :
                return 'اتوریتی نامعتبر است.';
            case -101 :
                return 'تراکنش قبلا وریفای شده است.';
            default:
                return 'خطای پیش بینی نشده‌ای رخ داده است.';
        }
    }

    static public function getName(): string
    {
        return 'زرین پال';
    }
}

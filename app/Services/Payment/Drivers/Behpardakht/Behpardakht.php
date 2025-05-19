<?php

namespace App\Services\Payment\Drivers\Behpardakht;

use App\Services\Helper;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Drivers\Zarinpal\PayStatus;
use App\Services\Payment\DTOs\PaymentResult;
use App\Services\Payment\GatewayDriver;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use SoapClient;

class Behpardakht extends GatewayDriver
{

    public CurrencyType $currency;
    public string $RefId;

    static public function getName(): string
    {
        return 'به‌پرداخت ملت';
    }

    /**
     * @throws Exception
     */
    function requestPurchase(): void
    {
        $metadata = [];

        if ($this->mobile) {
            $metadata['mobile'] = $this->mobile;
        }
        if ($this->order_id) {
            $metadata['order_id'] = $this->order_id;
        }

        $result = $this->request('bpPayRequest', [
            'orderId' => $this->order_id,
            'amount' => (int) ( $this->currency == CurrencyType::TOMAN ? $this->amount * 10 : $this->amount),
            'localDate' => Carbon::now()->format('Ymd'),
            'localTime' => Carbon::now()->format('Gis'),
            'additionalData' => json_encode($metadata),
            'callBackUrl' => $this->callbackUrl,
            'payerId' => $this->order_id
        ]);
        $response = explode(',', $result);
        $ResponseCode = optional($response)[0] ?? -99;
        if ($ResponseCode == "0") {
            $this->reference_id2 = $this->RefId = $response[1];
        } else {
            Log::error('Behpardakht Error: '.$this->errorCode($result).' ('.$result.')' );
            throw new Exception($this->errorCode($result));
        }
    }

    function pay(): PaymentGatewayInterface
    {
        return $this;
    }

    function render(): HtmlString|string
    {
        return new HtmlString(<<<HTML
<form id='behpardakht_go' action='https://bpm.shaparak.ir/pgwchannel/startpay.mellat' method='post'>
<input type='hidden' name='RefId' value='{$this->RefId}'>
<input type='hidden' name='MobileNo' value='{$this->mobile}'>
</form><script>document.getElementById('behpardakht_go').submit();</script>
HTML);
    }

    function completionPurchase(): void
    {
        $parameters = [
            'orderId' => $this->order_id,
            'saleOrderId' => $this->order_id,
            'saleReferenceId' => $this->reference_id1
        ];
        $this->request('bpSettleRequest', $parameters);
    }

    function refund(Request $request): bool
    {
        // TODO: Implement refund() method.
    }

    /**
     * @throws Exception
     */
    function verify(Request $request): PaymentResult
    {

        $resCode = $request->get('ResCode');
        if ($resCode != '0') {
            throw new Exception($resCode);
        }
        $verifySaleReferenceId = $request->get('SaleReferenceId');

        $answer = $this->request('bpVerifyRequest', [
            'orderId' => $this->order_id,
            'saleOrderId' => $this->order_id,
            'saleReferenceId' => $verifySaleReferenceId
        ]);
        if ($answer == 0 or $answer == 43) {
            throw new Exception($answer);
        }
        $this->reference_id1 = $verifySaleReferenceId;
        return new PaymentResult(
            status: PayStatus::PAID,
            transactionCode: $verifySaleReferenceId,
            cardMask: $request->get('CardHolderPan')
        );
    }



    public function request($method, $parameters) {
        $client = new SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $result = $client->{$method}(array_merge([
            'terminalId' => Helper::setting('BEHPARDAKHT_TERMINAL_ID' , $this->config['terminal_id']),
            'userName' => Helper::setting('BEHPARDAKHT_USERNAME' , $this->config['username']),
            'userPassword' => Helper::setting('BEHPARDAKHT_PASSWORD' , $this->config['password'])
        ],$parameters));
        return is_array($result) || is_object($result) ? $result->return : "-1";
    }

    private function errorCode($code)
    {

        switch ($code) {
            case -1 :
                return "تراکنش با موفقيت انجام نشد.";
            case 0 :
                return "تراکنش با موفقيت انجام شد.";
            case 11 :
                return "شماره کارت نامعتبر است.";
            case 12 :
                return "موجودی کافي نيست.";
            case 13 :
                return "رمز نادرست است.";
            case 14 :
                return "تعداد دفعات وارد کردن رمز بيش از حد مجاز است.";
            case 15 :
                return "کارت نامعتبر است.";
            case 16 :
                return "دفعات برداشت وجه بيش از حد مجاز است.";
            case 17 :
                return "کاربر از انجام تراکنش منصرف شده است.";
            case 18 :
                return "تاريخ انقضای کارت گذشته است.";
            case 19 :
                return "مبلغ برداشت وجه بيش از حد مجاز است.";
            case 111 :
                return "صادر کننده کارت نامعتبر است.";
            case 112 :
                return "خطای سوييچ صادر کننده کارت.";
            case 113 :
                return "پاسخي از صادر کننده کارت دريافت نشد.";
            case 114 :
                return "دارنده کارت مجاز به انجام اين تراکنش نيست.";
            case 21 :
                return "پذيرنده نامعتبر است.";
            case 23 :
                return "خطای امنيتي رخ داده است.";
            case 24 :
                return "اطلاعات کاربری پذيرنده نامعتبر است.";
            case 25 :
                return "مبلغ نامعتبر است.";
            case 31 :
                return "پاسخ نامعتبر است.";
            case 32 :
                return "فرمت اطلاعات وارد شده صحيح نمي باشد.";
            case 33 :
                return "حساب نامعتبر است.";
            case 34 :
                return "خطای سيستمي.";
            case 35 :
                return "تاريخ نامعتبر است.";
            case 41 :
                return "شماره درخواست تکراری است.";
            case 42 :
                return "تراکنش Sale يافت نشد.";
            case 43 :
                return "قبلا درخواست Verify داده شده است.";
            case 44 :
                return "درخواست Verify يافت نشد.";
            case 45 :
                return "تراکنش Settle شده است.";
            case 46 :
                return "تراکنش Settle نشده است.";
            case 47 :
                return "تراکنش Settle يافت نشد.";
            case 48 :
                return "تراکنش Reverse شده است.";
            case 412 :
                return "شناسه قبض نادرست است.";
            case 413 :
                return "شناسه پرداخت نادرست است.";
            case 414 :
                return "سازمان صادر کننده قبض نامعتبر است.";
            case 415 :
                return "زمان جلسه کاری به پايان رسيده است.";
            case 416 :
                return "خطا در ثبت اطلاعات.";
            case 417 :
                return "شناسه پرداخت کننده نامعتبر است.";
            case 418 :
                return "اشکال در تعريف اطلاعات مشتری.";
            case 419 :
                return "تعداد دفعات ورود اطلاعات از حد مجاز گذشته است.";
            case 421 :
                return "IP نامعتبر است.";
            case 51 :
                return "تراکنش تکراری است.";
            case 54 :
                return "تراکنش مرجع موجود نيست.";
            case 55 :
                return "تراکنش نامعتبر است.";
            case 61 :
                return "خطا در واريز.";
            case 62 :
                return "مسير بازگشت به سايت در دامنه ثبت شده برای پذيرنده قرار ندارد.";
            case 98 :
                return "سقف استفاده از رمز ايستا به پايان رسيده است.";
            default:
                return 'خطای پیش بینی نشده‌ای رخ داده است.';
        }
    }
}

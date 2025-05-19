<?php

namespace App\Services\Payment\Drivers\DigiPay;

use App\Services\Helper;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Drivers\Zarinpal\PayStatus;
use App\Services\Payment\DTOs\PaymentResult;
use App\Services\Payment\GatewayDriver;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\HtmlString;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class DigiPay extends GatewayDriver
{

    private mixed $oauthToken;
    private Mode $mode;
    private CurrencyType $currency;

    private $redirectUrl;
    private $payType;

    static public function getName(): string
    {
        return 'دیجی پی';
    }

    function requestPurchase(): void
    {
        $body = $this->sendRequest('/digipay/api/tickets/business?type=11' , [
            'amount' => $this->amount * ($this->currency == CurrencyType::TOMAN ? 10 : 1),
            'cellNumber' => $this->mobile,
            'providerId' => $this->order_id,
            'callbackUrl' => $this->callbackUrl,
        ] , 'POST' , [
            'Agent' => 'WEB',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->oauthToken,
            'Digipay-Version' => '2022-02-02',
        ]);

        $this->setReferenceId2($body['ticket']);
        $this->redirectUrl = $body['redirectUrl'];

    }

    function pay(): PaymentGatewayInterface
    {
        return $this;
    }

    function render(): HtmlString|string
    {
        return $this->redirectUrl;
    }

    function completionPurchase(): void
    {

    }

    function refund(Request $request): bool
    {
        // TODO: Implement refund() method.
    }

    function verify(Request $request): PaymentResult
    {

        $digipayTicketType = $request->get('type');
        $tracingId = $request->get('trackingCode');
        $result = $request->get('result') == 'SUCCESS' ? PayStatus::PAID : PayStatus::FAILED;
        if ( $result == PayStatus::PAID ) {
            $result = $this->sendRequest('/digipay/api/purchases/verify/'.$tracingId.'?type='.$digipayTicketType , [] , 'POST' , [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->oauthToken,
            ]);
            return new PaymentResult(status: PayStatus::PAID, transactionCode: $tracingId, cardMask: $result['maskedPan'], paidAt: now(), rawResponse: $result);
        }
        return new PaymentResult(status:$result, transactionCode:$tracingId);
    }


    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    protected function oauth()
    {
        $body = $this->sendRequest('/digipay/api/oauth/token' , [
            [
                'name' => 'username',
                'contents' => Helper::setting('DIGIPAY_USERNAME' , $this->config['username']),
            ],
            [
                'name' => 'password',
                'contents' => Helper::setting('DIGIPAY_PASSWORD' , $this->config['password']),
            ],
            [
                'name' => 'grant_type',
                'contents' => 'password',
            ],
        ], 'POST' , [
            'Authorization' => 'Basic '.base64_encode(Helper::setting('DIGIPAY_CLIENT_ID' , $this->config['client_id']).":".Helper::setting('DIGIPAY_SECRET' , $this->config['client_secret'])),
        ]);
        $this->oauthToken = $body['access_token'];
        return $body['access_token'];
    }


    /**
     * @throws GuzzleException
     */
    protected function sendRequest($url , array $body , string $method = 'POST' , array $header = [])
    {
        if ( ! $this->oauthToken ){
            $this->oauth();
        }

        $client = new Client();
        $response = $client
            ->request($method, trim($this->mode->getUrl(), '/') . trim($url,'/'),
                [
                    RequestOptions::HEADERS => $header,
                    RequestOptions::MULTIPART => $body,
                    RequestOptions::HTTP_ERRORS => false,
                ]
            );

        $result =json_decode($response->getBody()->getContents(), true);
        $code = optional(optional(optional($result)['result'])['code']);
        if ($response->getStatusCode() != 200 and $code > 0) {
            throw new \Exception( $this->errorCode( $code ?? $response->getStatusCode() )  , $code ?? $response->getStatusCode() );
        }
        return $result;
    }


    public function errorCode($code): string
    {
        return match ($code){
            0 => 'عملیات با موفقیت انجام شد',
            1054 => 'اطلاعات ورودی اشتباه می باشد',
            9000 => 'اطلاعات خرید یافت نشد',
            9001 => 'توکن پرداخت معتبر نمی باشد',
            9003 => 'خرید مورد نظر منقضی شده است',
            9004 => 'خرید مورد نظر درحال انجام است',
            9005 => 'خرید قابل پرداخت نمی باشد',
            9006 => 'خطا در برقراری ارتباط با درگاه پرداخت',
            9007 => 'خرید با موفقیت انجام نشده است',
            9008 => 'این خرید با داده های متفاوتی قبلا ثبت شده است',
            9009 => 'محدوده زمانی تایید تراکنش گذشته است',
            9010 => 'تایید خرید ناموفق بود',
            9011 => 'نتیجه تایید خرید نامشخص است',
            9012 => 'وضعیت خرید برای این درخواست صحیح نمی باشد',
            9030 => 'ورود شماره همراه برای کاربران ثبت نام شده الزامی است',
            9031 => 'اعطای تیکت برای کاربر مورد نظر امکان پذیر نمی‌باشد',
            200 => 'موفق',
            400 => 'پارامترهای ورودی نامعتبر است.',
            401, 403 => 'خطا در احراز هویت و دسترسی',
            422 => 'خطای بیزینسی',
            500 => 'خطای داخلی',
            default => 'خطای ناشناخته ('. $code .')'
        };
    }
}

<?php

namespace App\Services\Payment\Drivers;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\DTOs\PaymentResult;
use App\Services\Payment\Enums\PayStatus;
use App\Services\Payment\GatewayDriver;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class SampleGateway extends GatewayDriver
{
    protected $transaction_id2 ;

    public function verify($request): PaymentResult
    {
        return new PaymentResult(
            status: $request->get('status') ? PayStatus::Paid : PayStatus::Reject,
            transactionCode: $this->config['transaction_id1'],
            referenceCode: $this->transaction_id2,
            cardMask: $this->config['card_number'],
            cardHash: $this->config['card_hash'],
            paidAt: now(),
            rawResponse: json_encode($request->all())
        );
    }

    function requestPurchase(): void
    {
        $this->reference_id2 = $this->transaction_id2 ?? $this->config['transaction_id1'];
    }

    function pay(): PaymentGatewayInterface
    {
        return $this;
    }

    function render(): HtmlString|string
    {
        return new HtmlString('<form action="'.$this->callbackUrl. '" method="POST"><h3  style="margin-top: 20px;margin-left: 10px;">Payment Status</h3><select name="status" style="margin: 20px 20px 20px 10px;"><option value="1" selected>Successed</option><option value="0">Reject</option></select><button   style="margin-top: 20px;" type="submit">Send</button></form>');
    }

    function completionPurchase(): void
    {
        // TODO: Implement completionPurchase() method.
    }

    function refund(Request $request): bool
    {
        // TODO: Implement refund() method.
        return true;
    }

    public static function getName(): string
    {
        return 'درگاه پرداخت تستی';
    }
}

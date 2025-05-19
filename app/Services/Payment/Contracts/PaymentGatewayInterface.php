<?php

namespace App\Services\Payment\Contracts;

use App\Services\Payment\DTOs\PaymentResult;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

interface PaymentGatewayInterface
{
    public static function getName():string;
    public function setAmount(int $amount):PaymentGatewayInterface;

    public function setMobile(?string $mobile): PaymentGatewayInterface;
    public function setReferenceId2(?string $reference_id2): PaymentGatewayInterface;
    public function setReferenceId1(?string $reference_id1): PaymentGatewayInterface;

    public function setCallbackUrl(string $callbackUrl): PaymentGatewayInterface;

    function purchase($finalizeCallback = null): PaymentGatewayInterface;
    function verify(Request $request): PaymentResult;
    function refund(Request $request): bool;

    public function setOrderID(int|string|null $order_id): PaymentGatewayInterface;

    function requestPurchase(): void;
    function pay(): PaymentGatewayInterface;
    function render(): HtmlString|String;
    function setConfig(array $config):void;
    function completionPurchase():void;
}

<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

abstract class GatewayDriver implements PaymentGatewayInterface
{
    protected int $amount;
    protected ?string $mobile;
    protected string $callbackUrl;
    protected int|string|null $order_id;
    protected ?array $config;
    public ?string $reference_id1 = null;
    public ?string $reference_id2 = null;


    abstract static public function getName():string;
    public function setAmount(int $amount):PaymentGatewayInterface
    {
        $this->amount = $amount;
        return $this;
    }

    public function setMobile(?string $mobile): PaymentGatewayInterface
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function setReferenceId1(?string $reference_id1): GatewayDriver
    {
        $this->reference_id1 = $reference_id1;
        return $this;
    }

    public function setReferenceId2(?string $reference_id2): GatewayDriver
    {
        $this->reference_id2 = $reference_id2;
        return $this;
    }

    public function setOrderID(int|string|null $order_id): PaymentGatewayInterface
    {
        $this->order_id = $order_id;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): PaymentGatewayInterface
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    abstract function requestPurchase(): void;
    function purchase($finalizeCallback = null): PaymentGatewayInterface
    {
        $this->requestPurchase();
        if ($finalizeCallback) {
            call_user_func_array($finalizeCallback, [$this]);
        }
        return $this;
    }
    abstract function pay(): PaymentGatewayInterface;
    abstract function render(): HtmlString|String;
    abstract function completionPurchase():void;
    abstract function refund(Request $request): bool;
    public function setConfig(?array $config): void
    {
        foreach ($config as $key => $value){
            if ( property_exists($this,$key) )
                $this->{$key} = $value;
        }
        $this->config = $config;
    }
}

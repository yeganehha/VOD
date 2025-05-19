<?php

namespace App\Services\Payment\Traits;

use App\Services\Payment\Enums\PayStatus;
use App\Services\Payment\Model\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;


/**
 * @property string $pay_link
 * @property Collection<Transaction> $transactions
 * @method string getPayableUUIDVariable()
 * @method string getPayablePriceVariable()
 * @method int getPayableUserIdVariable()
 * @method PayStatus getPayableStatus()
 */
trait Payable
{

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'payable');
    }

    public function getPrimaryKeyValue(): int
    {
        return $this->{$this->getKeyName()};
    }
    public function getUUIDValue(): ?string
    {
        $uuid = $this->getAttribute($this->getUUIDVariable());
        return $uuid ?? (string) $this->getPrimaryKeyValue();
    }
    public function getUUIDVariable(): string
    {
        if ( method_exists($this, 'getPayableUUIDVariable')){
            return $this->getPayableUUIDVariable();
        }
        return 'uuid';
    }

    public function getPriceValue(): int
    {
        $priceVariable = 'price';
        if ( method_exists($this, 'getPayablePriceVariable')){
            $priceVariable = $this->getPayablePriceVariable();
        }
        return $this->getAttribute($priceVariable) ?? 0;
    }

    public function getUserIdValue(): int
    {
        if ( method_exists($this, 'getPayableUserIdVariable'))
            return $this->getPayableUserIdVariable();
        abort_if(optional($this->user)->id , 403);
        return optional($this->user)->id;
    }

    public function getStatusValue(): PayStatus
    {
        if ( method_exists($this, 'getPayableStatus'))
            return $this->getPayableStatus();
        return $this->getAttribute('status');
    }

    public function render_callback(Transaction $transaction) : HtmlString|String|array|self|Transaction|Redirector|RedirectResponse
    {
        if ( method_exists($this, 'payableCallbackResponse'))
            return $this->payableCallbackResponse($transaction);
        return $transaction;
    }
    /**
     * @throws \Throwable
     */
    public function getPayLinkAttribute() :string
    {
        throw_if( in_array($this->getStatusValue() , [PayStatus::Reject , PayStatus::Paid ])  ,  'فاکتور مد نظر قبلا پرداخت شده است!');
        $class = null;
        foreach (config('payment.models') as $itemClass => $model) {
            if ( $model == self::class){
                $class = $itemClass;
            }
        }
        throw_if( ! $class ,  'امکان پرداخت میسر نمی باشد.');
        return route('payment.pay' , ['payable_type' => $class , 'payable_id' => $this->getUUIDValue()]);
    }
}

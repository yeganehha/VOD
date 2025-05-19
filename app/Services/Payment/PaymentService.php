<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\Payable;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Enums\PayStatus;
use App\Services\Payment\Model\Transaction;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class PaymentService
{

    public function createPayment(Payable $payable, ?string $gatewayDriver = null): RedirectResponse|HtmlString
    {
        try{
            $gateway = PaymentGatewayManager::getDriver($gatewayDriver);
        } catch (Exception $exception) {
            Log::error('Error! get error when Driver execute.' , ['file' => $exception->getFile() , 'line' => $exception->getLine() , 'message' => $exception->getMessage()]);
            abort(402);
        }
        $transaction = new Transaction();
        $transaction->payable_type = get_class($payable);
        $transaction->payable_id = $payable->getPrimaryKeyValue();
        $transaction->ip_address = request()->ip();
        $transaction->user_id = $payable->getUserIdValue();
        $transaction->price = $payable->getPriceValue();
        $transaction->gateway = get_class($gateway);
        $transaction->status = PayStatus::INIT;
        $transaction->save();
        try{
            $renderValue = $gateway->setAmount($transaction->price)
                ->setMobile(optional(optional($transaction->payable)->user)->phone)
                ->setCallbackUrl(route('payment.callback', ['uuid' => $transaction->call_back_uuid]))
                ->setOrderID($transaction->uuid)
                ->purchase(function (GatewayDriver $driver) use ($transaction) {
                    $transaction->reference_id = $driver->reference_id1;
                    $transaction->reference_id2 = $driver->reference_id2;
                    $transaction->save();
                })->pay()->render();
            if ( $renderValue instanceof HtmlString)
                return $renderValue;
            if ( filter_var($renderValue, FILTER_VALIDATE_URL))
                return redirect()->to($renderValue);
        } catch (Exception $exception){
            $transaction->description = $exception->getMessage();
            $transaction->save();
            Log::error('Error! get error when Driver want to pay.' , ['file' => $exception->getFile() , 'line' => $exception->getLine() , 'message' => $exception->getMessage()]);
            abort(402);
        }
        abort(402);
    }

    public function payableModel(string $payable_type , mixed $payable_id) :Payable
    {
        /** @var Model $payableStaticObject */
        $payableStaticObject = null;
        /** @var Payable $payableObject */
        $payableObject = null;
        foreach (config('payment.models') as $itemClass => $model) {
            /** @var Payable $model */
            if ( $itemClass == $payable_type){
                $payableStaticObject = $model::query();
                $payableObject = new $model();
            }
        }
        abort_if( ! $payableObject ,  404,'امکان پرداخت میسر نمی باشد.');
        $payableObject = $payableStaticObject
            ->where($payableObject->getUUIDVariable() , $payable_id)
            ->firstOrFail();
        abort_if( in_array($payableObject->getStatusValue() , [PayStatus::Reject , PayStatus::Paid ])  ,  404,'فاکتور مد نظر قبلا پرداخت شده است!');
        return $payableObject;
    }

    public function fetchTransactionWithUUID(string $uuid) : Transaction
    {
        return Transaction::query()->where('call_back_uuid', $uuid)->firstOrFail();
    }

    private function refundTransaction(Transaction $transaction , PaymentGatewayInterface $gateway):bool
    {
        return $gateway->refund(request());
    }

    public function verifyTransaction(Transaction $transaction) : HtmlString|String|array|Payable|Transaction|Redirector|RedirectResponse
    {
        abort_if( in_array($transaction->status , [PayStatus::Reject , PayStatus::Paid , PayStatus::Refund]) , 403);
        try{
            $gateway = PaymentGatewayManager::getDriver($transaction->gateway);
        } catch (Exception $exception) {
            Log::error('Error! get error when Driver execute.' , ['file' => $exception->getFile() , 'line' => $exception->getLine() , 'message' => $exception->getMessage()]);
            abort(402);
        }
        try {
            $result = $gateway->setAmount($transaction->price)
                ->setMobile(optional(optional($transaction->payable)->user)->phone)
                ->setCallbackUrl(route('payment.callback', ['uuid' => $transaction->call_back_uuid]))
                ->setReferenceId1($transaction->reference_id)
                ->setReferenceId2($transaction->reference_id2)
                ->setOrderID($transaction->uuid)
                ->verify(request());
        } catch (Exception $exception){
            $transaction->description = $exception->getMessage();
            $transaction->status = PayStatus::Reject;
            $transaction->save();
            return $transaction;
        }

        try {
            DB::beginTransaction();

            $transaction->reference_id = $result->referenceCode;
            $transaction->reference_id2 = $result->transactionCode;
            $transaction->card_mask = $result->cardMask;
            $transaction->card_hash = $result->cardHash;
            $transaction->paid_at = $result->paidAt;

            if ($result->status === PayStatus::Paid) {
                $transaction->status = PayStatus::Paid;
                $isPayablePurchased = $transaction->payable->purchase($transaction);
                if ( ! $isPayablePurchased ){
                    $transaction->description = 'عملیات خرید با مشکل مواجه شده است!';
                    $this->refundTransaction($transaction , $gateway);
                    $transaction->status = PayStatus::Refund;
                } else {
                    $gateway->completionPurchase();
                }
            } else {
                $transaction->status = PayStatus::Reject;
                $transaction->save();
            }
            $transaction->save();
            DB::commit();
            return $transaction->payable->render_callback($transaction);
        } catch (Exception $exception){
            DB::rollBack();
            $transaction->description = $exception->getMessage();
            $transaction->status = PayStatus::Reject;
            $transaction->save();
        }

        return $transaction;
    }
}

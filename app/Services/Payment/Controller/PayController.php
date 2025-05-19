<?php

namespace App\Services\Payment\Controller;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\HtmlString;

class PayController  extends Controller
{
    public function pay(PaymentService $paymentService , $payable_type , $payable_id): HtmlString|RedirectResponse
    {
        $payable = $paymentService->payableModel($payable_type,$payable_id);
        return $paymentService->createPayment($payable);
    }
    public function call_back(PaymentService $paymentService , $uuid)
    {
        $transaction = $paymentService->fetchTransactionWithUUID($uuid);
        return $paymentService->verifyTransaction($transaction);
    }
}

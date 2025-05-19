<?php

use App\Services\Payment\Controller\PayController;
use Illuminate\Support\Facades\Route;

Route::any('api/transaction/{uuid}/call_back' , [PayController::class , 'call_back'])->name('payment.callback');
Route::get('api/transaction/{payable_type}/{payable_id}' , [PayController::class , 'pay'])->name('payment.pay');

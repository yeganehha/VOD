<?php

namespace App\Services\Payment\DTOs;

use App\Services\Payment\Enums\PayStatus;
use Illuminate\Support\Carbon;

class PaymentResult
{
    public PayStatus $status;
    public ?string $transactionCode;
    public ?string $referenceCode;
    public ?string $cardMask;
    public ?string $cardHash;
    public ?string $errorMessage;
    public Carbon $paidAt;
    public string $rawResponse;

    public function __construct($status, $transactionCode = null, $referenceCode = null, $cardMask = null, $cardHash = null, $errorMessage = null, $paidAt = null, $rawResponse = null)
    {
        $this->status = $status;
        $this->transactionCode = $transactionCode;
        $this->referenceCode = $referenceCode;
        $this->cardMask = $cardMask;
        $this->cardHash = $cardHash;
        $this->errorMessage = $errorMessage;
        $this->paidAt = $paidAt ?? Carbon::now();
        $this->rawResponse = $rawResponse;
    }
}

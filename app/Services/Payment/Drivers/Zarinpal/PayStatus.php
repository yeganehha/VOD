<?php

namespace App\Services\Payment\Drivers\Zarinpal;

use App\Traits\Enums\ArrayAble;

enum PayStatus : string
{
    use ArrayAble ;
    case VERIFIED = 'verify';

    case PAID = 'paid';
    case IN_BANK = 'in_bank';
    case FAILED = 'failed';
    case REVERSED = 'reversed';
}

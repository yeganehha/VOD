<?php

namespace App\Services\Payment\Drivers\Behpardakht;

enum CurrencyType : string
{
    case RIYAL = 'IRR';

    case TOMAN = 'IRT';
}

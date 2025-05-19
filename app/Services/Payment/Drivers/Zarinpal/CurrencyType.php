<?php

namespace App\Services\Payment\Drivers\Zarinpal;

enum CurrencyType : string
{
    case RIYAL = 'IRR';

    case TOMAN = 'IRT';
}

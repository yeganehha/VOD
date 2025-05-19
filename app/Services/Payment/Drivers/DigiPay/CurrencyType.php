<?php

namespace App\Services\Payment\Drivers\DigiPay;

enum CurrencyType : string
{
    case RIYAL = 'IRR';

    case TOMAN = 'IRT';
}

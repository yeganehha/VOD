<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;

enum TwoFATokenType: string
{
    use ArrayAble;
    case PHONE = 'phone';
}

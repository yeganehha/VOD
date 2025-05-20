<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CoverType: string
{
    use ArrayAble;
    case Video   = 'Video';
    case Image    = 'Image';
}

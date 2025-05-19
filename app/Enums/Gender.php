<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel,HasIcon
{
    use ArrayAble;
    case Male = 'Male';
    case Female = 'Female';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Male => 'مرد',
            self::Female => 'زن',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Male => 'bi-gender-male',
            self::Female => 'bi-gender-female',
        };
    }
}

<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasLabel,HasColor // ,HasIcon
{
    use ArrayAble ;
    case INIT = 'INIT';
    case Pending = 'Pending';
    case Confirmed = 'Confirmed';
    case Reject = 'Reject';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INIT => 'ایجاد شده',
            self::Pending => 'در حال بررسی',
            self::Confirmed => 'تایید شده',
            self::Reject => 'رد شده',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::INIT => 'pepicon-circle-big-circle',
            self::Pending => 'vaadin-hourglass',
            self::Confirmed => 'iconic-check',
            self::Reject => 'maki-cross',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INIT => 'info',
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Reject => 'danger',
        };
    }
}

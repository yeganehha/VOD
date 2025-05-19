<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PublishStatus: string implements HasLabel,HasColor //,HasIcon
{
    use ArrayAble ;
    case Draft = 'Draft';
    case Pending = 'Pending';
    case Publish = 'Publish';
    case Reject = 'Reject';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'پیش نویس',
            self::Pending => 'در حال بررسی',
            self::Publish => 'منتشر شده',
            self::Reject => 'رد شده',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'pepicon-circle-big-circle',
            self::Pending => 'vaadin-hourglass',
            self::Publish => 'iconic-check',
            self::Reject => 'maki-cross',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'info',
            self::Pending => 'warning',
            self::Publish => 'success',
            self::Reject => 'danger',
        };
    }
}

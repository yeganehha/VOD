<?php

namespace App\Services\Payment\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PayStatus: string implements HasLabel,HasIcon,HasColor
{
    use ArrayAble ;
    case INIT = 'INIT';
    case Pending = 'Pending';
    case Paid = 'Paid';
    case Reject = 'Reject';
    case Refund = 'Refund';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INIT => 'ایجاد شده',
            self::Pending => 'در حال پرداخت',
            self::Paid => 'پرداخت شده',
            self::Reject => 'رد شده',
            self::Refund => 'برگشت خورده',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::INIT => 'pepicon-circle-big-circle',
            self::Pending => 'vaadin-hourglass',
            self::Paid => 'iconic-check',
            self::Reject => 'maki-cross',
            self::Refund => 'ri-refund-2-fill',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INIT => 'info',
            self::Pending => 'warning',
            self::Paid => 'success',
            self::Reject, self::Refund => 'danger',
        };
    }
}

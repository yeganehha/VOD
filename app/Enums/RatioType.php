<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RatioType: string implements HasLabel
{
    use ArrayAble;
    case R_16_9   = '16:9';
    case R_4_3    = '4:3';
    case R_21_9   = '21:9';
    case R_18_9   = '18:9';
    case R_19_9   = '19:9';
    case R_19_5_9 = '19.5:9';
    case R_20_9   = '20:9';
    case R_5_3    = '5:3';
    case R_3_2    = '3:2';
    case R_1_1    = '1:1';
    case R_2_1    = '2:1';
    case R_32_9   = '32:9';
    case R_17_9   = '17:9';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::R_16_9   => '۱۶ به ۹ (رایج در تلویزیون HD و یوتیوب)',
            self::R_4_3    => '۴ به ۳ (کلاسیک - مانیتورهای قدیمی و ویدیوهای SD)',
            self::R_21_9   => '۲۱ به ۹ (سینمایی و مانیتور فوق‌عریض)',
            self::R_18_9   => '۱۸ به ۹ (گوشی‌های مدرن نسل جدید)',
            self::R_19_9   => '۱۹ به ۹ (نمایشگرهای تمام‌صفحه موبایل)',
            self::R_19_5_9 => '۱۹٫۵ به ۹ (آیفون‌های جدید و برخی پرچمداران اندرویدی)',
            self::R_20_9   => '۲۰ به ۹ (گوشی‌های سامسونگ و مدرن)',
            self::R_5_3    => '۵ به ۳ (برخی تبلت‌ها و نمایشگرهای سفارشی)',
            self::R_3_2    => '۳ به ۲ (مایکروسافت سرفیس، کروم‌بوک‌ها)',
            self::R_1_1    => '۱ به ۱ (فرمت مربعی - اینستاگرام و شبکه‌های اجتماعی)',
            self::R_2_1    => '۲ به ۱ (Univisium - استاندارد سینمایی مدرن)',
            self::R_32_9   => '۳۲ به ۹ (فوق‌عریض‌ترین مانیتورها)',
            self::R_17_9   => '۱۷ به ۹ (استفاده سینمایی حرفه‌ای)',
        };
    }

    public function isHorizontal(): string
    {
        [$w, $h] = explode(':', str_replace(',', '.', $this->value));
        return ((float)$w / (float)$h) >= 1 ? true : 'vertical';
    }

    public function isVertical(): string
    {
        return  ! $this->isHorizontal();
    }

}

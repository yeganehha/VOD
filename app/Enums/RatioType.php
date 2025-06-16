<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RatioType: string implements HasLabel
{
    use ArrayAble;
    // نسبت‌های افقی
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

    // نسبت‌های عمودی
    case R_9_16   = '9:16';
    case R_3_4    = '3:4';
    case R_9_21   = '9:21';
    case R_9_18   = '9:18';
    case R_9_19   = '9:19';
    case R_9_19_5 = '9:19.5';
    case R_9_20   = '9:20';
    case R_3_5    = '3:5';
    case R_2_3    = '2:3';
    case R_1_2    = '1:2';

    public function getLabel(): ?string
    {
        return match ($this) {
            // افقی
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

            // عمودی
            self::R_9_16   => '۹ به ۱۶ (عمودی - استوری‌ها و ویدیوهای موبایل)',
            self::R_3_4    => '۳ به ۴ (عمودی - عکس‌های پرتره و موبایل)',
            self::R_9_21   => '۹ به ۲۱ (عمودی - نمایشگرهای موبایل بلند)',
            self::R_9_18   => '۹ به ۱۸ (عمودی - گوشی‌های مدرن)',
            self::R_9_19   => '۹ به ۱۹ (عمودی - نمایشگرهای تمام‌صفحه موبایل)',
            self::R_9_19_5 => '۹ به ۱۹٫۵ (عمودی - آیفون‌های جدید و برخی پرچمداران اندرویدی)',
            self::R_9_20   => '۹ به ۲۰ (عمودی - گوشی‌های سامسونگ و مدرن)',
            self::R_3_5    => '۳ به ۵ (عمودی - برخی تبلت‌ها و نمایشگرهای سفارشی)',
            self::R_2_3    => '۲ به ۳ (عمودی - عکس‌های پرتره)',
            self::R_1_2    => '۱ به ۲ (عمودی - فرمت بلند)',

        };
    }

    public function isHorizontal(): bool
    {
        [$w, $h] = explode(':', str_replace(',', '.', $this->value));
        return ((float)$w / (float)$h) >= 1;
    }

    public function division(): float
    {
        [$w, $h] = explode(':', str_replace(',', '.', $this->value));
        return (float)$w / (float)$h;
    }

    public function isVertical(): bool
    {
        return ! $this->isHorizontal();
    }
}

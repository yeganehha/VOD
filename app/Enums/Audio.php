<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Audio: string implements HasLabel
{
    use ArrayAble;

    case Persian = 'Fa';
    case English = 'En';
    case Arabic = 'Ar';
    case French = 'Fr';
    case German = 'De';
    case Spanish = 'Es';
    case Russian = 'Ru';
    case Chinese = 'Zh';
    case Japanese = 'Ja';
    case Urdu = 'Ur';
    case Turkish = 'Tr';
    case Kurdish = 'Ku';
    case Hindi = 'Hi';
    case Italian = 'It';
    case Portuguese = 'Pt';
    case Dutch = 'Nl';
    case Hebrew = 'He';
    case Korean = 'Ko';
    case Pashto = 'Ps';
    case Swedish = 'Sv';
    case Danish = 'Da';
    case Norwegian = 'No';
    case Finnish = 'Fi';
    case Greek = 'El';
    case Thai = 'Th';
    case Vietnamese = 'Vi';
    case Polish = 'Pl';
    case Romanian = 'Ro';
    case Czech = 'Cs';
    case Slovak = 'Sk';
    case Hungarian = 'Hu';
    case Bulgarian = 'Bg';
    case Serbian = 'Sr';
    case Croatian = 'Hr';
    case Albanian = 'Sq';
    case Bosnian = 'Bs';
    case Georgian = 'Ka';
    case Armenian = 'Hy';
    case Malay = 'Ms';
    case Indonesian = 'Id';
    case Filipino = 'Tl';
    case Swahili = 'Sw';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Persian     => 'فارسی',
            self::English     => 'انگلیسی',
            self::Arabic      => 'عربی',
            self::French      => 'فرانسوی',
            self::German      => 'آلمانی',
            self::Spanish     => 'اسپانیایی',
            self::Russian     => 'روسی',
            self::Chinese     => 'چینی',
            self::Japanese    => 'ژاپنی',
            self::Urdu        => 'اردو',
            self::Turkish     => 'ترکی استانبولی',
            self::Kurdish     => 'کردی',
            self::Hindi       => 'هندی',
            self::Italian     => 'ایتالیایی',
            self::Portuguese  => 'پرتغالی',
            self::Dutch       => 'هلندی',
            self::Hebrew      => 'عبری',
            self::Korean      => 'کره‌ای',
            self::Pashto      => 'پشتو',
            self::Swedish     => 'سوئدی',
            self::Danish      => 'دانمارکی',
            self::Norwegian   => 'نروژی',
            self::Finnish     => 'فنلاندی',
            self::Greek       => 'یونانی',
            self::Thai        => 'تایلندی',
            self::Vietnamese  => 'ویتنامی',
            self::Polish      => 'لهستانی',
            self::Romanian    => 'رومانیایی',
            self::Czech       => 'چکی',
            self::Slovak      => 'اسلواکی',
            self::Hungarian   => 'مجاری',
            self::Bulgarian   => 'بلغاری',
            self::Serbian     => 'صربی',
            self::Croatian    => 'کرواتی',
            self::Albanian    => 'آلبانیایی',
            self::Bosnian     => 'بوسنیایی',
            self::Georgian    => 'گرجی',
            self::Armenian    => 'ارمنی',
            self::Malay       => 'مالایی',
            self::Indonesian  => 'اندونزیایی',
            self::Filipino    => 'فیلیپینی',
            self::Swahili     => 'سواحیلی',
        };
    }

}

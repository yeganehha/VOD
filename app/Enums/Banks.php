<?php

namespace App\Enums;

use App\Traits\Enums\ArrayAble;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Facades\Log;

enum Banks : string implements HasLabel
{

    use ArrayAble ;
    case MARKAZI = 'MARKAZI';
    case SANAT_VA_MADAN = 'SANAT_VA_MADAN';
    case MELLAT = 'MELLAT';
    case REFAH = 'REFAH';
    case MASKAN = 'MASKAN';
    case SEPAH = 'SEPAH';
    case KESHAVARZI = 'KESHAVARZI';
    case MELLI = 'MELLI';
    case TEJARAT = 'TEJARAT';
    case SADERAT = 'SADERAT';
    case TOSEAH_SADERAT = 'TOSEAH_SADERAT';
    case POST = 'POST';
    case TOSEAH_TAAVON = 'TOSEAH_TAAVON';
    case TOSEAH = 'TOSEAH';
    case KARAFARIN = 'KARAFARIN';
    case PARSIAN = 'PARSIAN';
    case EGHTESAD_NOVIN = 'EGHTESAD_NOVIN';
    case SAMAN = 'SAMAN';
    case PASARGAD = 'PASARGAD';
    case SARMAYEH = 'SARMAYEH';
    case SINA = 'SINA';
    case MEHR_IRAN = 'MEHR_IRAN';
    case SHAHR = 'SHAHR';
    case AYANDEH = 'AYANDEH';
    case GARDESHGARI = 'GARDESHGARI';
    case DAY = 'DAY';
    case IRANZAMIN = 'IRANZAMIN';
    case RESALAT = 'RESALAT';
    case MELAL = 'MELAL';
    case KHAVARMIANEH = 'KHAVARMIANEH';
    case NOOR = 'NOOR';
    case IRAN_VENEZUELA = 'IRAN_VENEZUELA';
    case GHAVAMIN = 'GHAVAMIN';
    case ANSAR = 'ANSAR';
    case HEKMAT = 'HEKMAT';
    case KOSAR = 'KOSAR';
    case UNKNOWN = 'UNKNOWN';

    public function getLabel(): string {
        switch ($this) {
            case self::MARKAZI:
                return 'مرکزی';
            case self::SANAT_VA_MADAN:
                return 'صنعت و معدن';
            case self::MELLAT:
                return 'ملت';
            case self::REFAH:
                return 'رفاه';
            case self::MASKAN:
                return 'مسکن';
            case self::SEPAH:
                return 'سپه';
            case self::KESHAVARZI:
                return 'کشاورزی';
            case self::MELLI:
                return 'ملی';
            case self::TEJARAT:
                return 'تجارت';
            case self::SADERAT:
                return 'صادرات';
            case self::TOSEAH_SADERAT:
                return 'توسعه صادرات';
            case self::POST:
                return 'پست';
            case self::TOSEAH_TAAVON:
                return 'توسعه تعاون';
            case self::TOSEAH:
                return 'توسعه';
            case self::KARAFARIN:
                return 'کارآفرین';
            case self::PARSIAN:
                return 'پارسیان';
            case self::EGHTESAD_NOVIN:
                return 'اقتصاد نوین';
            case self::SAMAN:
                return 'سامان';
            case self::PASARGAD:
                return 'پاسارگاد';
            case self::SARMAYEH:
                return 'سرمایه';
            case self::SINA:
                return 'سینا';
            case self::MEHR_IRAN:
                return 'مهر ایران';
            case self::SHAHR:
                return 'شهر';
            case self::AYANDEH:
                return 'آینده';
            case self::GARDESHGARI:
                return 'گردشگری';
            case self::DAY:
                return 'دی';
            case self::IRANZAMIN:
                return 'ایران زمین';
            case self::RESALAT:
                return 'رسالت';
            case self::MELAL:
                return 'ملل';
            case self::KHAVARMIANEH:
                return 'خاورمیانه';
            case self::NOOR:
                return 'نور';
            case self::IRAN_VENEZUELA:
                return 'ایران ونزولا';
            case self::GHAVAMIN:
                return 'قوامین';
            case self::ANSAR:
                return 'انصار';
            case self::HEKMAT:
                return 'حکمت ایرانیان';
            case self::KOSAR:
                return 'موسسه اعتباری کوثر';
            default:
                Log::info('Unknown bank type: ' . $this->name);
                return 'نامشخص';
        }
    }

}

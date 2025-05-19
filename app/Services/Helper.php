<?php

namespace App\Services;

use App\Models\Asset\Setting;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;

class Helper
{
    public static function convertToEnglishNumbers($string) : string
    {
        $persianNum = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabicNum = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishNum = range(0, 9);
        $string = str_replace($persianNum, $englishNum, $string);
        return str_replace($arabicNum, $englishNum, $string);
    }

    public static function convertToPersianNumbers($string) : string
    {
        $persianNum = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNum = range(0, 9);
        return str_replace($englishNum , $persianNum, $string);
    }

    public static function numberToLetters($input): string
    {
        $words = [
            [
                "",
                "یک",
                "دو",
                "سه",
                "چهار",
                "پنج",
                "شش",
                "هفت",
                "هشت",
                "نه"
            ],
            [
                "ده",
                "یازده",
                "دوازده",
                "سیزده",
                "چهارده",
                "پانزده",
                "شانزده",
                "هفده",
                "هجده",
                "نوزده",
                "بیست"
            ],
            [
                "",
                "",
                "بیست",
                "سی",
                "چهل",
                "پنجاه",
                "شصت",
                "هفتاد",
                "هشتاد",
                "نود"
            ],
            [
                "",
                "یکصد",
                "دویست",
                "سیصد",
                "چهارصد",
                "پانصد",
                "ششصد",
                "هفتصد",
                "هشتصد",
                "نهصد"
            ],
            [
                '',
                " هزار ",
                " میلیون ",
                " میلیارد ",
                " بیلیون ",
                " بیلیارد ",
                " تریلیون ",
                " تریلیارد ",
                " کوآدریلیون ",
                " کادریلیارد ",
                " کوینتیلیون ",
                " کوانتینیارد ",
                " سکستیلیون ",
                " سکستیلیارد ",
                " سپتیلیون ",
                " سپتیلیارد ",
                " اکتیلیون ",
                " اکتیلیارد ",
                " نانیلیون ",
                " نانیلیارد ",
                " دسیلیون "
            ]
        ];
        $splitter = " و ";
        $zero = "صفر";
        if ($input == 0) {
            return $zero;
        }
        if (strlen($input) > 66) {
            return "خارج از محدوده";
        }
        //Split to sections
        if (gettype($input) == "integer" || gettype($input) == "double") {
            $input = (string)$input;
        }
        $length = strlen($input) % 3;
        if ($length == 1) {
            $input = "00" . $input;
        } else if ($length == 2) {
            $input = "0" . $input;
        }
        $splittedNumber = str_split($input, 3);
        $result = [];
        $splitLength = count($splittedNumber);
        for ($i = 0; $i < $splitLength; $i++) {
            $sectionTitle = $words[4][$splitLength - ($i + 1)];
            if ((int)preg_replace('/\D/', '', $splittedNumber[$i]) == 0) {
                continue;
            }
            $parsedInt = (int)preg_replace('/\D/', '', $splittedNumber[$i]);
            if ($parsedInt < 10) {
                $converted = $words[0][$parsedInt];
            } elseif ($parsedInt <= 20) {
                $converted = $words[1][$parsedInt - 10];
            } elseif ($parsedInt < 100) {
                $one = $parsedInt % 10;
                $ten = ($parsedInt - $one) / 10;
                if ($one > 0) {
                    $converted = $words[2][$ten] . $splitter . $words[0][$one];
                } else
                    $converted = $words[2][$ten];
            } else {
                $one = $parsedInt % 10;
                $hundreds = ($parsedInt - $parsedInt % 100) / 100;
                $ten = ($parsedInt - (($hundreds * 100) + $one)) / 10;
                $out = [$words[3][$hundreds]];
                $secondPart = (($ten * 10) + $one);
                if ($secondPart > 0) {
                    if ($secondPart < 10) {
                        array_push($out, $words[0][$secondPart]);
                    } else if ($secondPart <= 20) {
                        array_push($out, $words[1][$secondPart - 10]);
                    } else {
                        array_push($out, $words[2][$ten]);
                        if ($one > 0) {
                            array_push($out, $words[0][$one]);
                        }
                    }
                }
                $converted = join($splitter, $out);
            }
            if ($converted !== "") {
                array_push($result, $converted . $sectionTitle);
            }
        }
        return join($splitter, $result);

    }

    public static function float_format(float $num, ?string $decimal_separator = '.', ?string $thousands_separator = ','): string
    {
        $floorNum = floor($num);
        $digits = $num - $floorNum > 0 ? floatval( '0.'.\Illuminate\Support\Str::replaceFirst($floorNum.'.' , '' , $num) ) : 0;
        return number_format($floorNum , 0 , $decimal_separator ,$thousands_separator) . ( $digits > 0  ? $decimal_separator. \Illuminate\Support\Str::replaceFirst('0.' , '' , $digits) : '') ;
    }

    public static function resourceSvg($icon): ?string
    {
        if ( is_null($icon) )
            return null;
        return route('cacheSVG' , $icon);
    }

    public static function setting(string|array $key, mixed $default = null): mixed
    {
        if ( is_array($key) and array_is_list($key) ){
            $values = [];
            foreach ($key as $k){
                try{
                    $values[$k] = cache()->rememberForever('setting_'.md5($k) , function () use ($k){
                        $value = Setting::query()->where('key' , $k)->first();
                        return $value ? $value->value : null;
                    });
                    $values[$k] = $values[$k] ?? $default;
                } catch (Exception $exception){
                    Log::error('Setting Error: Can not find value of '.$k , ['message' => $exception->getMessage()]);
                    $values[$k] = $default;
                }
            }
            return $values;
        } elseif ( is_array($key) ){
            foreach ($key as $item => $value){
                Setting::query()->updateOrCreate([
                    'key' => $item,
                ] , [
                    'value' => $value,
                ]);
            }
        } else {
            try{
                return cache()->rememberForever('setting_'.md5($key) , function () use ($key){
                    $value = Setting::query()->where('key' , $key)->first();
                    return $value ? $value->value : null;
                }) ?? $default;
            } catch (Exception $exception){
                Log::error('Setting Error: Can not find value of '.$key , ['message' => $exception->getMessage()]);
                return $default;
            }
        }
        return $default;
    }

    public static function formatNumber(int $number): string {
        if ($number < 1000) {
            return (string) Number::format($number, 0);
        }

        if ($number < 1000000) {
            return Number::format($number / 1000, 2) . ' هزار ';
        }

        return Number::format($number / 1000000, 2) . ' مِیلیون ';
    }
}

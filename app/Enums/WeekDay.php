<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WeekDay:string implements HasLabel
{
    case Sunday = 'Sunday';
    case Monday = 'Monday';
    case Tuesday = 'Tuesday';
    case Wednesday = 'Wednesday';
    case Thursday = 'Thursday';
    case Friday = 'Friday';
    case Saturday = 'Saturday';

    public function getLabel(): string
    {
        return match ($this) {
            self::Saturday => 'شنبه',
            self::Sunday => 'یک شنبه',
            self::Monday => 'دو شنبه',
            self::Tuesday => 'سه شنبه',
            self::Wednesday => 'چهار شنبه',
            self::Thursday => 'پنج شنبه',
            self::Friday => 'جمعه',
        };
    }

    public function getPersianNumber(): int
    {
        return match ($this) {
            self::Saturday => 1,
            self::Sunday => 2,
            self::Monday => 3,
            self::Tuesday => 4,
            self::Wednesday => 5,
            self::Thursday => 6,
            self::Friday => 7,
        };
    }
    public function getEnglishNumber(): int
    {
        return match ($this) {
            self::Saturday => 7,
            self::Sunday => 1,
            self::Monday => 2,
            self::Tuesday => 3,
            self::Wednesday => 4,
            self::Thursday => 5,
            self::Friday => 6,
        };
    }
    public function isWeekEnd(): bool
    {
        return match ($this) {
            self::Saturday,
            self::Sunday,
            self::Monday,
            self::Tuesday,
            self::Wednesday,
            self::Thursday => false,
            self::Friday => true,
        };
    }
    public static function getFromEnglishNumber($number): self
    {
        return match ($number) {
            7 => self::Saturday ,
            1 => self::Sunday,
            2 => self::Monday,
            3 => self::Tuesday,
            4 => self::Wednesday,
            5 => self::Thursday,
            6 => self::Friday,
        };
    }
    public static function getFromPersianNumber($number): self
    {
        return match ($number) {
            1 => self::Saturday ,
            2 => self::Sunday,
            3 => self::Monday,
            4 => self::Tuesday,
            5 => self::Wednesday,
            6 => self::Thursday,
            7 => self::Friday,
        };
    }
    public static function getFromVertaNumber($number): self
    {
        return match ($number) {
            0 => self::Saturday ,
            1 => self::Sunday,
            2 => self::Monday,
            3 => self::Tuesday,
            4 => self::Wednesday,
            5 => self::Thursday,
            6 => self::Friday,
        };
    }
}

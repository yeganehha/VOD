<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use function Symfony\Component\Translation\t;

enum EntityType:string implements HasLabel
{
    case Movie = 'Movie';
    case Series = 'Series';
    case MultiSeasonSeries = 'MultiSeasonSeries';
    public function getLabel(): string
    {
        return match ($this) {
            self::Movie => 'سینمایی',
            self::Series => 'سریال',
            self::MultiSeasonSeries => 'سریال چند فصلی',
        };
    }

    public function isMultiEpisode(): bool
    {
        return match ($this) {
            self::Movie => false,
            self::Series, self::MultiSeasonSeries => true
        };
    }

    public function isMultiSeason(): bool
    {
        return match ($this) {
            self::Movie, self::Series => false,
            self::MultiSeasonSeries => true
        };
    }

}

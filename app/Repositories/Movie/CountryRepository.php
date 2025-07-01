<?php

namespace App\Repositories\Movie;

use App\Models\Asset\Country;
use App\Models\Movie\Genre;
use App\Traits\DynamicRepository;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository
{
    private static  ?Collection $allOfThem = null;

    /**
     * @return Collection<Genre>
     */
    public static function getAll($item = 0) : Collection
    {
        return cache()->remember('getAllCountry_'.$item, 60 * 60, function () use ($item) {
            return Country::query()->withCount('entities')
                ->orderBy('entities_count', 'desc')
                ->when($item > 0 , fn ($query) => $query->take($item))
                ->get() ;
        });
    }

}

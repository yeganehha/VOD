<?php

namespace App\Repositories\Movie;

use App\Models\Movie\Genre;
use App\Traits\DynamicRepository;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository
{
    use DynamicRepository;
    protected string|null $modelClass = Genre::class;

    /**
     * @return Collection<Genre>
     */
    public function getAll() : Collection
    {
        return cache()->remember('getAllGenres', 60 * 60, function () {
            return $this->query->clone()->orderBy('title')->get() ;
        });
    }
    /**
     * @return Collection<Genre>
     */
    public function mostMovies($item = 0) : Collection
    {
        return cache()->remember('getMostMoviesGenreWith_'.$item.'_items', 5 * 60, function () use ($item) {
            return $this->query->clone()
                ->withCount('entities')
                ->orderBy('entities_count', 'desc')
                ->when($item > 0 , fn ($query) => $query->take($item))
                ->get() ;
        });
    }
}

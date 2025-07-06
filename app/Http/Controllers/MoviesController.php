<?php

namespace App\Http\Controllers;

use App\Enums\EntityType;
use App\Models\Asset\Country;
use App\Models\Movie\Movie;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class MoviesController extends Controller
{
    public function singleShow($entitySlug  , $season = 1, $episode = 1): View
    {
        $movie = MovieRepository::singleShow($entitySlug , $episode, $season)->query()->firstOrFail();
        return view('pages.singleMovie', compact(['movie']));
    }
    public function singleShowEpisode($entitySlug  ,$episode): View
    {
        return $this->singleShow($entitySlug , episode: $episode);
    }
    public function getImage($type,$width,$height,$entity_id)
    {
        $path = cache()->remember($type.'_cover_path_'.$width.'_'.$height.'_'.$entity_id, app()->isProduction() ? 60*60*24*30 : 0 , function () use ($type,$entity_id,$width,$height){
            return $type == 'entity' ?
                \App\Models\Movie\Entity::query()->findOrFail($entity_id)?->getImage($width,$height,true):
                \App\Models\Movie\Movie::query()->findOrFail($entity_id)?->getImage($width,$height,true);
        });
        if ( $path and file_exists(storage_path('app/public/' . $path))) {
            return response()->file(storage_path('app/public/' . $path));
        }
        abort(404);
    }
    public function searchByTag(Request $request, string $tags): View
    {
        $tags = explode('-',$tags);
        $movies = MovieRepository::searchByTag($tags)->query()->paginate();
        return view('pages.searchPage', compact(['movies','tags']));
    }
    public function searchByGenre(Request $request, string $genre): View
    {
        $tags = [$genre];
        $slides = MovieRepository::searchByTag($tags)->query()->take(5)->get();
        $movies = MovieRepository::searchByTag($tags)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
    public function searchByCountry(Request $request, string $code, string $title): View
    {
        $tags = [$code.'_'.$title];
        $slides = MovieRepository::searchByTag($tags)->query()->take(5)->get();
        $movies = MovieRepository::searchByTag($tags)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
    public function searchByYear(Request $request, int $year): View
    {
        $slides = MovieRepository::productOfYear($year)->query()->take(5)->get();
        $movies = MovieRepository::productOfYear($year)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
    public function justMovies(Request $request): View
    {
        $tags = [EntityType::Movie->value];
        $slides = MovieRepository::searchByTag($tags)->query()->take(5)->get();
        $movies = MovieRepository::searchByTag($tags)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
    public function justSeries(Request $request): View
    {
        $tags = [EntityType::Series->value];
        $slides = MovieRepository::searchByTag($tags)->query()->take(5)->get();
        $movies = MovieRepository::searchByTag($tags)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
    public function justIranian(Request $request): View
    {
        $tags = ['IR_iran'];
        $slides = MovieRepository::searchByTag($tags)->query()->take(5)->get();
        $movies = MovieRepository::searchByTag($tags)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
    public function justForeign(Request $request): View
    {
        $tags = Country::query()->whereNot('code', 'IR')->get()->map(fn($item) => $item->code.'_'.str($item->title_en)->slug())->values()->toArray();
        $slides = MovieRepository::searchByTag($tags)->query()->take(5)->get();
        $movies = MovieRepository::searchByTag($tags)
            ->query()->whereNotIn('entity_id' , $slides->pluck('entity_id')
                ->toArray())
            ->paginate();
        return view('pages.categoryListMovies', compact(['movies', 'slides']));
    }
}

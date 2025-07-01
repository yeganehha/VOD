<?php

namespace App\Http\Controllers;

use App\Repositories\Movie\MovieRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
                \App\Models\Movie\Entity::query()->findOrFail($entity_id)?->getImage($width,$height):
                \App\Models\Movie\Movie::query()->findOrFail($entity_id)?->getImage($width,$height);
        });
        if ( $path and file_exists(storage_path('app/public/' . $path))) {
            return response()->file(storage_path('app/public/' . $path));
        }
        abort(404);
    }
}

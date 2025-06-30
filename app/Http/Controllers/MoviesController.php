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
}

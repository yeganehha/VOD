<?php

namespace App\Http\Controllers;

use App\Repositories\Movie\MovieRepository;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function singleShow($entitySlug , $episode = 1 , $season = 1)
    {
        $movie = MovieRepository::singleShow($entitySlug , $episode, $season)->query()->firstOrFail();
        return view('pages.singleMovie', compact(['movie']));
    }
}

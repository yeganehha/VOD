<?php

namespace App\Http\Controllers;

use App\Enums\EntityType;
use App\Models\Asset\Country;
use App\Models\Movie\Movie;
use App\Models\Movie\MovieFiles;
use App\Models\User\User;
use App\Models\User\ViewHistory;
use App\Repositories\Movie\MovieRepository;
use App\Services\Helper;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    public function view(Request $request , $uuid): View
    {
        $movie = MovieRepository::singleMovieShow($uuid)->query()->firstOrFail();
        $history = ViewHistory::where('movie_id', $movie->id)
            ->where('profile_id', auth()->user()->currentProfile()->id)
            ->first();
        $lastSeenTime = $history?->last_seconds ?? 0;
        return view('layouts.viewMedia' , compact('movie' , 'lastSeenTime'));
    }


    public function stream(Request $request, $movieID): StreamedResponse
    {
        /** @var Movie $movie */
        $movie = MovieRepository::singleMovieShow($movieID)->query()->without(['entity'  ,'covers' , 'entity.covers', 'entity.genres', 'entity.countries'])->firstOrFail();
        /** @var MovieFiles $media */
        $media = MovieFiles::query()->where('movie_id' , $movie->id)->firstOrFail();



        $filePath = storage_path("app/".$media->path);
        if (!file_exists($filePath)) {
            abort(404);
        }

        $fileSize = filesize($filePath);
        $range = $request->header('Range');

        $bitrate = 125000;
        $chunkLengthInSeconds = 10;
        $maxChunkSize = $bitrate * $chunkLengthInSeconds;

        $start = 0;
        if ($range) {
            preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
            $start = intval($matches[1]);
            if (!empty($matches[2])) {
                $end = intval($matches[2]);
            } else {
                $end = min($start + $maxChunkSize - 1, $fileSize - 1);
            }
        } else {
            /** @var ViewHistory $history */
            $history = ViewHistory::query()
                ->where('movie_id' , $movie->id)
                ->where('profile_id' , auth('web')->user()->currentProfile()->id)
                ->first();
            if(  $history->last_range ){
                preg_match('/bytes=(\d+)-(\d*)/', $history->last_range, $matches);
                $start = intval($matches[1]);
                if (!empty($matches[2])) {
                    $end = intval($matches[2]);
                } else {
                    $end = min($start + $maxChunkSize - 1, $fileSize - 1);
                }
            } else {
                $end = min($maxChunkSize - 1, $fileSize - 1);
            }
        }
        $secondsWatched = intval($start / $bitrate);
        ViewHistory::query()
            ->updateOrCreate([
                'movie_id' => $movie->id,
                'profile_id' => auth('web')->user()->currentProfile()->id,
            ] , [
                'last_range' => $range
            ]);

        $length = $end - $start + 1;

        $response = new StreamedResponse(function () use ($filePath, $start, $length) {
            $handle = fopen($filePath, 'rb');
            fseek($handle, $start);
            echo fread($handle, $length);
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'video/mp4');
        $response->headers->set('Content-Length', $length);
        $response->headers->set('Accept-Ranges', 'bytes');
        $response->headers->set('Content-Range', "bytes $start-$end/" . $fileSize);
        $response->setStatusCode(206); // Partial Content

        return $response;
    }


    public function updateWatchPosition(Request $request , $uuid)
    {
        $request->validate([
            'seconds'  => ['required', 'integer', 'min:0']
        ]);
        $profile = Auth('web')->user()->currentProfile();
        $viewHistory = ViewHistory::updateOrCreate(
            [
                'movie_id' => $uuid,
                'profile_id' => $profile->id,
            ],
            [
                'last_seconds' => $request->seconds,
            ]
        );
        return response()->json(['status' => 'ok', 'position_saved' => $viewHistory->last_seconds]);
    }

}

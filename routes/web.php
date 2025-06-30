<?php

use App\Http\Controllers\MoviesController;
use App\Models\Movie\Movie;
use Filament\Actions\Exports\Http\Controllers\DownloadExport;
use Filament\Actions\Imports\Http\Controllers\DownloadImportFailureCsv;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/filament/exports/{export}/download', DownloadExport::class)
    ->name('filament.exports.download')
    ->middleware(['web', 'auth:admin']);
Route::get('/filament/imports/{import}/failed-rows/download', DownloadImportFailureCsv::class)
    ->name('filament.imports.failed-rows.download')
    ->middleware(['web', 'auth:admin']);

Route::get('/private-storage/temp/', function (){
    return Storage::disk('private')->download(request()->get('path'));
})->middleware('signed')->name('linkPrivateStorageSigned');


//Route::get('/storage/entity-covers/{year}/{month}/{day}/{h}:{w}-{name}', function ($year , $month , $day , $h , $w , $name ){
//    Storage::makeDirectory('public/entity-covers/');
//    Storage::makeDirectory('public/entity-covers/'.$year.'/');
//    Storage::makeDirectory('public/entity-covers/'.$year.'/'.$month.'/');
//    Storage::makeDirectory('public/entity-covers/'.$year.'/'.$month.'/'.$day.'/');
//    File::put(
//        storage_path('app/public/entity-covers/'.$year.'/'.$month.'/'.$day.'/'. $h .':', $w .'-'. $name),
//        file_get_contents()
//    );
//    return Storage::response('public/svg/cache/'.$icon.'.svg');
//})->middleware('signed')->name('linkPrivateStorageSigned');






Route::view('/' , 'layouts.homepage')->name('home');
Route::get('/{type}-cover/{width}/{height}/{entity_id}' , function ($type,$width,$height,$entity_id) {
    $path = cache()->remember($type.'_cover_path_'.$width.'_'.$height.'_'.$entity_id, app()->isProduction() ? 60*60*24*30 : 0 , function () use ($type,$entity_id,$width,$height){
        return $type == 'entity' ?
            optional(optional(\App\Models\Movie\EntityCover::query()->where('entity_id' , $entity_id)->get())
                ->sortBy(fn($img) => abs($img->ratio_type->division() - ((float)$width / (float) $height)))
                ->filter(fn($img) => $img->path and file_exists(storage_path('app/public/' . $img->path)))
        )->first()?->path : ( optional(optional(\App\Models\Movie\MovieCover::query()->where('movie_id' , $entity_id)->get())
                    ->sortBy(fn($img) => abs($img->ratio_type->division() - ((float)$width / (float) $height)))
                    ->filter(fn($img) => $img->path and file_exists(storage_path('app/public/' . $img->path)))
            )->first()?->path ?? optional(optional(\App\Models\Movie\EntityCover::query()->where('entity_id' , \App\Models\Movie\Movie::query()->find($entity_id)?->entity_id)->get())
                ->sortBy(fn($img) => abs($img->ratio_type->division() - ((float)$width / (float) $height)))
                ->filter(fn($img) => $img->path and file_exists(storage_path('app/public/' . $img->path)))
            )->first()?->path );
    });
    if ( $path and file_exists(storage_path('app/public/' . $path))) {
        return response()->file(storage_path('app/public/' . $path));
    }
    abort(404);
})->name('get-cover');
Route::view('/genre/{genre}' , 'layouts.homepage')->name('genre');
Route::view('/country/{code}/{title?}' , 'layouts.homepage')->name('country');
Route::view('/year/{year}' , 'layouts.homepage')->name('year');
Route::view('/list/type/movies' , 'layouts.homepage')->name('type.movies');
Route::view('/list/type/series' , 'layouts.homepage')->name('type.series');
Route::view('/list/type/iranian' , 'layouts.homepage')->name('type.iranian');
Route::view('/list/type/foreign' , 'layouts.homepage')->name('type.foreign');
Route::get('/m/{uuid}' , function ($uuid) {
    $movie = Movie::query()->where('id' , $uuid)->firstOrFail();
    if ( $movie->entity->type == \App\Enums\EntityType::Movie )
        return response()->redirectTo(route("movie.show" , $movie->entity->slug));
    if ( $movie->entity->type == \App\Enums\EntityType::MultiSeasonSeries )
        return response()->redirectTo(route("movie.series" , [$movie->entity->slug, $movie->season, $movie->episode]));
    return response()->redirectTo(route("movie.episode" , [$movie->entity->slug,$movie->episode]));
})->name('movie.short');
Route::get('/movie/{slug}' , [MoviesController::class , 'singleShow'])->name('movie.show');
Route::get('/movie/{slug}/episode/{episode}' , [MoviesController::class , 'singleShowEpisode'])->name('movie.episode');
Route::get('/movie/{slug}/season/{season}/episode/{episode}' , [MoviesController::class , 'singleShow'])->name('movie.series');
Route::view('/login' , 'layouts.homepage')->name('login');
Route::view('/profile' , 'layouts.homepage')->name('profile');

<?php

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
Route::view('/genre/{genre}' , 'layouts.homepage')->name('genre');
Route::view('/login' , 'layouts.homepage')->name('login');
Route::view('/profile' , 'layouts.homepage')->name('profile');

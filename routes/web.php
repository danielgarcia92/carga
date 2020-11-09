<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')
    ->name('home');

Route::get('/uploads', 'UploadController@indexAction')
    ->name('uploads.index');

Route::get('/champ', 'ChampController@indexAction')
    ->name('champ.index');

Route::get('/main', 'MainController@indexAction')
    ->name('main.index');

Route::post('uploads', 'UploadController@storeAction')
    ->name('uploads.store');

Route::get('success', function () {
    return view('uploads.success');
});

Route::put('/main/{row}', 'MainController@updateAction')
    ->where('row', '[0-9]+')
    ->name('main.update');

Route::delete('main/{row}', 'MainController@destroyAction')
    ->name('main.destroy');

Auth::routes();

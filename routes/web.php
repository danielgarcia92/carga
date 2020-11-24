<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')
    ->name('home');


Route::get('/champ', 'ChampController@indexAction')
    ->name('champ.index');
Route::post('champ', 'ChampController@storeAction')
    ->name('champ.store');
Route::post('champ_form', 'ChampController@formAction')
    ->name('champ.form');
Route::get('/champ/success', function () {
    return view('champ.success');
});


Route::get('/main', 'MainController@indexAction')
    ->name('main.index');
Route::post('/main/{row}', 'MainController@formAction')
    ->where('row', '[0-9]+')
    ->name('main.form');
Route::put('/main/details/{row}', 'MainController@updateAction')
    ->where('row', '[0-9]+')
    ->name('main.update');
Route::delete('main/{row}', 'MainController@destroyAction')
    ->name('main.destroy');

Route::get('/uploads', 'UploadController@indexAction')
    ->name('uploads.index');
Route::post('uploads', 'UploadController@storeAction')
    ->name('uploads.store');
Route::get('success', function () {
    return view('uploads.success');
});


Auth::routes();

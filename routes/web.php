<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')
    ->name('home');


Route::get('/aerocharter', 'AerocharterController@indexAction')
    ->name('aerocharter.index');
Route::get('/aerocharter_requests', 'AerocharterController@requestsAction')
    ->name('aerocharter.requests');
Route::put('aerocharter', 'AerocharterController@storeAction')
    ->name('aerocharter.store');
Route::post('/aerocharter_requests/{row}', 'AerocharterController@detailsAction')
    ->where('row', '[0-9]+')
    ->name('aerocharter.details');
Route::post('aerocharter_form', 'AerocharterController@formAction')
    ->name('aerocharter.form');
Route::get('/aerocharter/success', function () {
    return view('aerocharter.success');
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
Route::get('/viva_requests', 'UploadController@requestsAction')
    ->name('uploads.requests');
Route::post('/viva_requests/{row}', 'UploadController@detailsAction')
    ->where('row', '[0-9]+')
    ->name('uploads.details');
Route::post('uploads', 'UploadController@storeAction')
    ->name('uploads.store');
Route::get('success', function () {
    return view('uploads.success');
});


Auth::routes();

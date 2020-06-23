<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/uploads', 'UploadController@indexAction')
    ->name('uploads.index');

Route::post('uploads', 'UploadController@storeAction')
    ->name('uploads.store');

Route::get('success', function () {
    return view('uploads.success');
});

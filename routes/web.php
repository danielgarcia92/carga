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
Route::get('/aerocharter/success', 'AerocharterController@successAction')
    ->name('aerocharter.success');

Route::get('/main', 'MainController@indexAction')
    ->name('main.index');
Route::get('/main/pending', 'MainController@indexAction')
    ->name('main.index');
Route::get('/main/approved', 'MainController@approvedAction')
    ->name('main.approved');
Route::get('/main/rejected', 'MainController@rejectedAction')
    ->name('main.rejected');
Route::post('/main/search', 'MainController@searchAction')
    ->name('main.search');
Route::get('/main/notification', 'MainController@notificationAction')
    ->name('main.notification');
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
Route::get('/uploads/success', 'UploadController@successAction')
    ->name('uploads.success');

Route::get('/admin/users', 'AdminController@usersAction')
    ->name('admin.users');
Route::post('/admin/users/{row}', 'AdminController@updateUserAction')
    ->where('row', '[0-9]+')
    ->name('admin.users.update');
Route::get('/admin/emails', 'AdminController@emailsAction')
    ->name('admin.emails');
Route::post('/admin/emails/{row}', 'AdminController@updateEmailAction')
    ->where('row', '[0-9]+')
    ->name('admin.emails.update');

Auth::routes();

<?php
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','role:super_admin|admin'])->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

    // offices routes
    Route::resource('offices', 'OfficeController')->except(['show']);

    // schools routes
    Route::resource('schools', 'SchoolController')->except(['show']);

});//end of dashboard routes
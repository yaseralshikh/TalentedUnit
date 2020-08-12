<?php
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','role:super_admin|admin'])->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

});//end of dashboard routes
<?php
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

});//end of dashboard routes
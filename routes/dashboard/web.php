<?php
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','role:super_admin|admin'])->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

    // offices routes
    Route::resource('offices', 'OfficeController')->except(['show']);
    Route::get('/offices/export', 'OfficeController@export')->name('office_excel_export');
    Route::post('/offices/import', 'OfficeController@import')->name('office_excel_import');

    // schools routes
    Route::resource('schools', 'SchoolController')->except(['show']);
    Route::get('/get_schools', 'SchoolController@get_schools')->name('get_schools');
    Route::get('/schools/export', 'SchoolController@export')->name('school_excel_export');
    Route::post('/schools/import', 'SchoolController@import')->name('school_excel_import');

    // teachers routes
    Route::resource('teachers', 'TeacherController')->except(['show']);
    Route::get('/get_teachers', 'TeacherController@get_teachers')->name('get_teachers');
    Route::get('/teachers/export', 'TeacherController@export')->name('teacher_excel_export');
    Route::post('/teachers/import', 'TeacherController@import')->name('teacher_excel_import');

    // students routes
    Route::resource('students', 'StudentController')->except(['show']);
    Route::get('/students/export', 'StudentController@export')->name('student_excel_export');
    Route::post('/students/import', 'StudentController@import')->name('student_excel_import');

    // supervisors routes
    Route::resource('supervisors', 'SupervisorController')->except(['show']);

});//end of dashboard routes
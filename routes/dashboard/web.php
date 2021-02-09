<?php
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','role:super_admin|admin'])->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

    // offices routes
    Route::resource('offices', 'OfficeController')->except(['show']);
    Route::post('/offices/export', 'OfficeController@export')->name('office_excel_export');
    Route::post('/offices/import', 'OfficeController@import')->name('office_excel_import');

    // schools routes
    Route::resource('schools', 'SchoolController')->except(['show']);
    Route::get('/get_schools', 'SchoolController@get_schools')->name('get_schools');
    Route::post('/schools/export', 'SchoolController@export')->name('school_excel_export');
    Route::post('/schools/import', 'SchoolController@import')->name('school_excel_import');

    // teachers routes
    Route::resource('teachers', 'TeacherController')->except(['show']);
    Route::get('/get_teachers', 'TeacherController@get_teachers')->name('get_teachers');
    Route::post('/teachers/export', 'TeacherController@export')->name('teacher_excel_export');
    Route::post('/teachers/import', 'TeacherController@import')->name('teacher_excel_import');

    // students routes
    Route::resource('students', 'StudentController')->except(['show']);
    Route::resource('students.programs', 'Student\ProgramController');
    Route::resource('students.courses', 'Student\CourseController');
    Route::post('/students/export', 'StudentController@export')->name('student_excel_export');
    Route::post('/students/import', 'StudentController@import')->name('student_excel_import');

    // supervisors routes
    Route::resource('supervisors', 'SupervisorController')->except(['show']);

    // programs routes
    Route::resource('programs', 'ProgramController')->except(['show']);
    Route::post('/programs/export', 'ProgramController@export')->name('program_excel_export');
    Route::post('/programs/import', 'ProgramController@import')->name('program_excel_import');

    // programs routes
    Route::resource('courses', 'CourseController')->except(['show']);
    Route::post('/courses/export', 'CourseController@export')->name('course_excel_export');
    Route::post('/courses/import', 'CourseController@import')->name('course_excel_import');

});//end of dashboard routes
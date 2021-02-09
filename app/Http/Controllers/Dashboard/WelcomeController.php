<?php

namespace App\Http\Controllers\Dashboard;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Office;
use App\Program;
use App\School;
use App\Teacher;
use App\Student;
use App\User;

class WelcomeController extends Controller
{
    public function index()
    {
        $offices_count = Office::all()->count();
        $schools_count = School::all()->count();
        $teachers_count = Teacher::all()->count();
        $students_count = Student::all()->count();
        $programs_count = Program::all()->count();
        $courses_count = Course::all()->count();
        $users_count = User::whereRoleIs('admin')->count();
        
        return view('dashboard.welcome', compact('offices_count', 'schools_count', 'users_count', 'teachers_count', 'students_count' , 'programs_count' , 'courses_count'));
    }
}

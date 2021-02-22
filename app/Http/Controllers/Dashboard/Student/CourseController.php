<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Student;
use App\Course;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:courses_read'])->only('index');
        $this->middleware(['permission:courses_create'])->only('create');
        $this->middleware(['permission:courses_update'])->only('edit');
        $this->middleware(['permission:courses_delete'])->only('destroy');
        $this->middleware(['permission:courses_export'])->only('export');
        $this->middleware(['permission:courses_import'])->only('import');

    }//end of constructor
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'course_date' => 'required',
        ]);

        $data = [
            
            'course_id'=>$request->course_id,
            'course_date'=>$request->course_date,
            'course_note'=>$request->course_note,
            'course_status'=>$request->course_status ? 1 : 0,
        ];

        $student->courses()->attach($student, $data );

        session()->flash('success', __('site.added_successfully'));
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    public function update_course(Request $request)
    {
        $request->validate([
            'course_date' => 'required',
        ]);

        $data = [
            'course_id'=>$request->course_id,
            'course_date'=>$request->course_date,
            'course_note'=>$request->course_note,
            'course_status'=>$request->course_status ? 1 : 0,
        ];

        //dd($request->all());

        DB::table('course_student')->where('id', $request->id)
        ->update($data);

        session()->flash('success', __('site.added_successfully'));
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, $course)
    {
        $student->courses()->wherePivot('id', '=', $course)->detach();
        return back()->withInput();
    }

    public function student_course_pdf($student_id, $course_id, $pivot_id)
    {
        $student = Student::with('courses')->whereId($student_id)->first();
        $course = Course::whereId($course_id)->first();
        $student_course = DB::table('course_student')->where('id', $pivot_id)->first();

        // if ($student_course->course_status) {
        $data=[
            'student' => $student,
            'course' => $course,
            'student_course' => $student_course,
        ];
        

        $pdf = PDF::loadView('dashboard.students.courses.course_l_pdf', $data , 
        [], 
        [ 
            'title' => 'Certificate',
            'author' => 'Yaser Alshikh', 
            'format' => 'A4-L',
            'display_mode' => 'fullpage',
            'orientation' => 'L'
        ]);
        
        $pdf->autoScriptToLang = true;
        $pdf->autoArabic = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('certificate.pdf');
        // } else {
        //     session()->flash('error', __('site.course_status_not_allowed'));
        //     return back();
        // }
        
    }
}

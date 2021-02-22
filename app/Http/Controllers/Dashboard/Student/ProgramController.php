<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Program;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ProgramController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:programs_read'])->only('index');
        $this->middleware(['permission:programs_create'])->only('create');
        $this->middleware(['permission:programs_update'])->only('edit');
        $this->middleware(['permission:programs_delete'])->only('destroy');
        $this->middleware(['permission:programs_export'])->only('export');
        $this->middleware(['permission:programs_import'])->only('import');

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
            'program_date' => 'required',
        ]);

        $data = [
            
            'program_id'=>$request->program_id,
            'program_date'=>$request->program_date,
            'program_note'=>$request->program_note,
            'program_status'=>$request->program_status ? 1 : 0,
        ];

        $student->programs()->attach($student, $data );

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
    public function edit(Student $student, $program)
    {
        // dd($student, $program);
        // $programs = Program::select('id', 'name')->get();
        // $student->programs()->wherePivot('id', '=', $program)->first();
        // return view('dashboard.students.programs.edit', compact('student', 'program', 'programs'));  
    }

    public function update_program(Request $request)
    {
        $request->validate([
            'program_date' => 'required',
        ]);

        $data = [
            'program_id'=>$request->program_id,
            'program_date'=>$request->program_date,
            'program_note'=>$request->program_note,
            'program_status'=>$request->program_status ? 1 : 0,
        ];

        //dd($request->all());

        DB::table('program_student')->where('id', $request->id)
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
    public function update(Request $request, Student $student , $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, $program)
    {
        $student->programs()->wherePivot('id', '=', $program)->detach();
        return back()->withInput();
    }

    public function student_program_pdf($student_id, $program_id, $pivot_id)
    {
        $student = Student::with('programs')->whereId($student_id)->first();
        $program = Program::whereId($program_id)->first();
        $student_program = DB::table('program_student')->where('id', $pivot_id)->first();

        // if ($student_program->program_status) {
        $data=[
            'student' => $student,
            'program' => $program,
            'student_program' => $student_program,
        ];

        if ($student_program->program_status) {
            $format = 'A4-L';
            $view = 'program_l_pdf';
            $orientation = 'L';
        } else {
            $format = 'A4-P';
            $view = 'program_p_pdf';
            $orientation = 'P';
        }
        //dd($format , $view , $orientation);
        $pdf = PDF::loadView('dashboard.students.programs.' . $view , $data , 
        [], 
        [ 
            'title' => 'Certificate',
            'author' => 'Yaser Alshikh', 
            'format' => $format ,
            'display_mode' => 'fullpage',
            'orientation' => $orientation 
        ]);
        
        $pdf->autoScriptToLang = true;
        $pdf->autoArabic = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('certificate.pdf');
        // } else {
        //     session()->flash('error', __('site.program_status_not_allowed'));
        //     return back();
        // }
        
    }


}

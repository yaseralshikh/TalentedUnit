<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Program;
use App\Student;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
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
        dd($student, $program);
        $programs = Program::select('id', 'name')->get();
        $student->programs()->wherePivot('id', '=', $program)->first();
        return view('dashboard.students.programs.edit', compact('student', 'program', 'programs'));
        
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
    public function destroy(Student $student, $program)
    {
        //dd($student, $program);
        
        $student->programs()->wherePivot('id', '=', $program)->detach();
        return back()->withInput();
    }

}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Office;
use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Imports\StudentImport;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::all();

        $students = Student::when($request->office_id, function ($q) use ($request) {

            return $q->where('office_id', $request->office_id);

        })->when($request->stage, function ($q) use ($request) {

            return $q->where('stage', $request->stage);

        })->when($request->school_id, function ($q) use ($request) {

            return $q->where('school_id', $request->school_id);

        })->when($request->class, function ($q) use ($request) {

            return $q->where('class', $request->class);

        })->when($request->teacher_id, function ($q) use ($request) {

            return $q->where('teacher_id', $request->teacher_id);

        })->when($request->search, function ($q) use ($request) {

            return $q->where('name', 'like' , '%' . $request->search . '%')
                     ->orWhere('idcard', $request->search)
                     ->orWhere('mobile', $request->search)
                     ->orWhere('email', 'like', '%' . $request->search . '%');

        })->orderBy('name')->paginate(50);

        return view('dashboard.students.index', compact('offices', 'students'));
    }

    public function export()
    {
        return Excel::download(new StudentExport(), 'Student.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ]);  

        $RadioOptions = $request->inlineRadioOptions;
 
        if ($RadioOptions == 'add') {

            // this for import with Append Data .
            Excel::import(new StudentImport(), $request->file('import_file'));

        } else {

            // this for remove data and Add now Data .
            $students = Excel::toCollection(new StudentImport(), $request->file('import_file'));

            foreach ($students[0] as $student) {
                Student::where('id', $student[0])->update([
                    'name' => $student[1],
                    'idcard' => $student[2],
                    'mobile' => $student[3],
                    'email' => $student[4],
                    'stage' => $student[5],
                    'class' => $student[6],
                    'degree' => $student[7],
                    'image' => $student[8],
                    'office_id' => $student[9],
                    'school_id' => $student[10],
                    'teacher_id' => $student[11],
                ]);
            }                    
        }

        return redirect()->route('dashboard.students.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function create()
    {
        $offices = Office::all();
        return view('dashboard.students.create', compact('offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:students,name',
            'idcard' => 'required|digits:10|unique:students,idcard',
            'mobile' => 'required|digits_between:10,14',
            'email' => 'required|email',
            'stage' => 'required',
            'class' => 'required',
            'office_id' => 'required',
            'school_id' => 'required',
            'teacher_id' => 'required',
            'degree' => 'required|numeric'
        ]);

        $request_data = $request->all();

        Student::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.students.index');
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
        $offices = Office::all();
        return view('dashboard.students.edit', compact('student','offices'));
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
        $request->validate([
            'name' => 'required|unique:students,name',
            'idcard' => 'required|digits:10|unique:students,idcard',
            'mobile' => 'required|digits_between:10,14',
            'email' => 'required|email',
            'stage' => 'required',
            'class' => 'required',
            'office_id' => 'required',
            'school_id' => 'required',
            'teacher_id' => 'required',
            'degree' => 'required|numeric'
        ]);

        $request_data = $request->all();

        $student->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.students.index');
    }
}

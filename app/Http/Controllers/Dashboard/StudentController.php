<?php

namespace App\Http\Controllers\Dashboard;

use App\Course;
use App\Http\Controllers\Controller;
use App\Office;
use App\Student;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Program;

class StudentController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:students_read'])->only('index');
        $this->middleware(['permission:students_create'])->only('create');
        $this->middleware(['permission:students_update'])->only('edit');
        $this->middleware(['permission:students_delete'])->only('destroy');
        $this->middleware(['permission:students_export'])->only('export');
        $this->middleware(['permission:students_import'])->only('import');

    }//end of constructor

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::all();

        $students = Student::with('programs')->when($request->office_id, function ($q) use ($request) {

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

            return $q->where('name', 'like' , $request->search . '%')
                     ->orWhere('idcard', $request->search)
                     ->orWhere('mobile', $request->search)
                     ->orWhere('email', 'like', '%' . $request->search . '%');

        })->orderBy('name')->paginate(150);

        return view('dashboard.students.index', compact('offices', 'students'));
    }

    public function export(Request $request)
    {
        return Excel::download(new StudentExport($request), 'Student.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ]);  

        $RadioOptions = $request->inlineRadioOptions;
 
        if ($RadioOptions == 'add') {

            try {

                // this for import with Append Data .
                Excel::import(new StudentImport(), $request->file('import_file'));

            } catch (\Exception $e) {
            
                session()->flash('error',  'ملق اكسل غير مطابق !!');
                             
            }

        } else {

            try {
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
                        'office_id' => $student[8],
                        'school_id' => $student[9],
                        'teacher_id' => $student[10],
                    ]);
                }                

            } catch (\Exception $e) {
            
                session()->flash('error',  'ملق اكسل غير مطابق !!');
                             
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
        //$programs = Program::select('id', 'name')->get();
        //$courses = Course::select('id', 'name')->get();
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
        //dd($request->all());
        $request->validate([
            'name' => 'required|unique:students,name',
            'idcard' => 'required|digits:10|unique:students,idcard',
            'mobile' => 'nullable|digits_between:10,14',
            'email' => 'nullable|email',
            'stage' => 'required',
            'class' => 'required',
            'office_id' => 'required',
            'school_id' => 'required',
            'teacher_id' => 'required',
            'degree' => 'nullable|numeric',
        ]);

        $request_data = $request->all();

        $student = Student::create($request_data);

        //$student->programs()->attach($request->program_id);
        //$student->courses()->attach($request->course_id);
        

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
        $offices = Office::select('id', 'name')->get();
        $programs = Program::select('id', 'name')->get();
        $courses = Course::select('id', 'name')->get();
        //dd($student->programs()->pluck('program_id'));
        return view('dashboard.students.edit', compact('student','offices', 'programs', 'courses'));
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
            'name'          => ['required' , Rule::unique('students')->ignore($student->id),],
            'idcard'        => ['required' , 'digits:10' , Rule::unique('students')->ignore($student->id),],
            'mobile'        => 'nullable|digits_between:10,14',
            'email'         => 'nullable|email',
            'stage'         => 'required',
            'class'         => 'required',
            'office_id'     => 'required',
            'school_id'     => 'required',
            'teacher_id'    => 'required',
            'degree'        => 'nullable|numeric',
        ]);

        $request_data = $request->all();

        $student->update($request_data);

        //$student->programs()->sync($request->program_id);
        //$student->courses()->sync($request->course_id);

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

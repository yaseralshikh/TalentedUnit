<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Office;
use App\Teacher;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeacherExport;
use App\Imports\TeacherImport;

class TeacherController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:teachers_read'])->only('index');
        $this->middleware(['permission:teachers_create'])->only('create');
        $this->middleware(['permission:teachers_update'])->only('edit');
        $this->middleware(['permission:teachers_delete'])->only('destroy');
        $this->middleware(['permission:teachers_export'])->only('export');
        $this->middleware(['permission:teachers_import'])->only('import');

    }//end of constructor

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::all();

        $teachers = Teacher::when($request->office_id, function ($q) use ($request) {

                return $q->where('office_id', $request->office_id);

            })->when($request->school_id, function ($q) use ($request) {

                return $q->where('school_id', $request->school_id);

            })->when($request->teacher_id, function ($q) use ($request) {

                return $q->where('id', $request->teacher_id);

            })->when($request->idcard, function ($q) use ($request) {

                return $q->where('idcard', $request->idcard);

            })->when($request->search, function ($q) use ($request) {

                return $q->where('name', 'like' , $request->search . '%')
                        ->orWhere('idcard', 'like', '%' . $request->search . '%')
                        ->orWhere('specialization', 'like', '%' . $request->search . '%')
                        ->orWhere('mobile', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');

            })->orderBy('name')->paginate(50);

        return view('dashboard.teachers.index', compact('offices', 'teachers'));
    }
    

    public function get_teachers(Request $request)
    {
        $teachers = Teacher::when($request->school_id, function ($q) use ($request) {

            return $q->whereSchoolId($request->school_id);

        })->pluck('name', 'idcard');

        return response()->json($teachers);

    } // End of get_teachers

    public function export(Request $request)
    {
        return Excel::download(new TeacherExport($request), 'Teacher.xlsx');
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
                Excel::import(new TeacherImport(), $request->file('import_file'));

            } catch (\Exception $e) {
            
                session()->flash('error',  'ملق اكسل غير مطابق !!');
                             
            }

        } else {

            try {
                // this for remove data and Add now Data .
                $teachers = Excel::toCollection(new TeacherImport(), $request->file('import_file'));

                foreach ($teachers[0] as $teacher) {
                    Teacher::where('id', $teacher[0])->update([
                        'name' => $teacher[1],
                        'idcard' => $teacher[2],
                        'mobile' => $teacher[3],
                        'email' => $teacher[4],
                        'specialization' => $teacher[5],
                        'image' => $teacher[6],
                        'office_id' => $teacher[7],
                        'school_id' => $teacher[8],
                    ]);
                } 

            } catch (\Exception $e) {
            
                session()->flash('error',  'ملق اكسل غير مطابق !!');
                             
            }
                   
        }

        return redirect()->route('dashboard.teachers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = Office::all();
        return view('dashboard.teachers.create', compact('offices'));
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
            'name' => ['required'],
            'idcard' => 'required',     //|unique:teachers,idcard',
            'mobile' => 'nullable|digits_between:10,14',
            'email' => 'nullable|email'
        ]);

        $request_data = $request->all();

        if ($request->image) {

            Image::make($request->image)
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('uploads/teacher_images/' . $request->image->hashName());

            $request_data['image'] = $request->image->hashName();

        }//end of if

        Teacher::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.teachers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $offices = Office::all();
        return view('dashboard.teachers.edit', compact('teacher','offices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => ['required' , Rule::unique('teachers')->ignore($teacher->id),],
            'idcard' => ['required' , 'digits:10'],         // , Rule::unique('teachers')->ignore($teacher->id),],
            'mobile' => 'nullable|digits_between:10,14',
            'email' => 'nullable|email'
        ]);

        $request_data = $request->all();

        if ($request->image) {

            if ($teacher->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/teacher_images/' . $teacher->image);
                    
            }//end of if

            Image::make($request->image)
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('uploads/teacher_images/' . $request->image->hashName());

            $request_data['image'] = $request->image->hashName();

        }//end of if

        $teacher->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.teachers.index');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\CourseExport;
use Maatwebsite\Excel\Facades\Excel;

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
    public function index(Request $request)
    {
        $courses = Course::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(10);

        return view('dashboard.courses.index', compact('courses'));
    }

    public function export(Request $request)
    {
        return Excel::download(new CourseExport($request), 'Courses.xlsx');
    }     

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.courses.create');
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
            'name' => 'required|unique:courses,name',
            'description' => 'required',
        ]);
        Course::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('dashboard.courses.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => ['required' , Rule::unique('courses')->ignore($course->id),],
            'description' => 'required',
        ]);

        $course->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.courses.index');
    }
}

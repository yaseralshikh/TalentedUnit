<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\ProgramExport;
use Maatwebsite\Excel\Facades\Excel;

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
    public function index(Request $request)
    {
        $programs = Program::with('students')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(10);

        return view('dashboard.programs.index', compact('programs'));
    }

    public function export(Request $request)
    {
        return Excel::download(new ProgramExport($request), 'Programs.xlsx');
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.programs.create');
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
            'name' => 'required|unique:programs,name',
            'description' => 'required',
        ]);
        Program::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.programs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        return view('dashboard.programs.edit',compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => ['required' , Rule::unique('programs')->ignore($program->id),],
            'description' => 'required',
        ]);

        $program->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.programs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.programs.index');
    }
}

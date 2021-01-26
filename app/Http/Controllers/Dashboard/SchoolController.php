<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\SchoolExport;
use App\Http\Controllers\Controller;
use App\Imports\SchoolImport;
use App\Office;
use App\School;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SchoolController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:schools_read'])->only('index');
        $this->middleware(['permission:schools_create'])->only('create');
        $this->middleware(['permission:schools_update'])->only('edit');
        $this->middleware(['permission:schools_delete'])->only('destroy');
        $this->middleware(['permission:schools_export'])->only('export');
        $this->middleware(['permission:schools_import'])->only('import');

    }//end of constructor
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::all();

        $schools = School::when($request->office_id, function ($q) use ($request) {

                return $q->where('office_id', $request->office_id);

            })->when($request->stage, function ($q) use ($request) {

                return $q->where('stage', $request->stage);

            })->when($request->search, function ($q) use ($request) {

                return $q->where('name', 'like' , '%' . $request->search . '%')
                         ->orWhere('moe_id', 'like', '%' . $request->search . '%')
                         ->orWhere('manager', 'like', '%' . $request->search . '%')
                         ->orWhere('mobile', 'like', '%' . $request->search . '%')
                         ->orWhere('email', 'like', '%' . $request->search . '%');
    
            })->orderBy('name')->paginate(100);

        return view('dashboard.schools.index', compact('offices', 'schools'));
    }

    public function get_schools(Request $request)
    {
        
        $schools = School::when($request->office_id, function ($q) use ($request) {

            return $q->whereOfficeId($request->office_id);

        })->when($request->stage, function ($q) use ($request) {

            return $q->where('stage', $request->stage);

        })->orderBy('name','asc')->pluck('moe_id', 'name');
        
        return response()->json($schools);

    } // End of get_schools

    public function export(Request $reques)
    {
        return Excel::download(new SchoolExport($reques), 'school.xlsx');
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
            Excel::import(new SchoolImport(), $request->file('import_file'));
                
            } catch (\Exception $e) {
                 session()->flash('error',  'ملق اكسل غير مطابق !!');
            }

        } else {

            try {

                // this for remove data and Add now Data .
                $schools = Excel::toCollection(new SchoolImport(), $request->file('import_file'));

                foreach ($schools[0] as $school) {
                    School::where('id', $school[0])->update([
                        'name' => $school[1],
                        'office_id' => $school[2],
                        'moe_id' => $school[3],
                        'stage' => $school[4],
                        'manager' => $school[5],
                        'mobile' => $school[6],
                        'email' => $school[7],
                    ]);
                }

            } catch (\Exception $e) {

                session()->flash('error',  'ملق اكسل غير مطابق !!');

            }
        }

        return redirect()->route('dashboard.schools.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = Office::all();
        return view('dashboard.schools.create', compact('offices'));
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
            'name' => 'required',
            'moe_id' => 'required|unique:schools,moe_id',
            //'manager' => 'required',
            'mobile' => 'nullable|digits_between:10,14',
            'email' => 'nullable|email',
        ]);
        School::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.schools.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        $offices = Office::all();
        return view('dashboard.schools.edit', compact('school','offices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required',
            'moe_id' => ['required' , Rule::unique('schools')->ignore($school->id),],
            //'manager' => 'required',
            'mobile' => 'nullable|digits_between:10,14',
            'email' => 'nullable|email',
        ]);

        $school->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.schools.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.schools.index');
    }
}

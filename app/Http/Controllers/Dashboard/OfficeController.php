<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\OfficeExport;
use App\Http\Controllers\Controller;
use App\Imports\OfficeImport;
use Illuminate\Http\Request;
use App\Office;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class OfficeController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:offices_read'])->only('index');
        $this->middleware(['permission:offices_create'])->only('create');
        $this->middleware(['permission:offices_update'])->only('edit');
        $this->middleware(['permission:offices_delete'])->only('destroy');
        $this->middleware(['permission:offices_export'])->only('export');
        $this->middleware(['permission:offices_import'])->only('import');

    }//end of constructor
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(10);

        return view('dashboard.offices.index', compact('offices'));
    }

    public function export()
    {
        return Excel::download(new OfficeExport(), 'office.xlsx');
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
                Excel::import(new OfficeImport(), $request->file('import_file'));
                
            } catch (\Exception $e) {
                 session()->flash('error',  'ملق اكسل غير مطابق !!');
            }

        } else {

            try {

                // this for remove data and Add now Data .
                $offices = Excel::toCollection(new OfficeImport(), $request->file('import_file'));

                foreach ($offices[0] as $office) {
                    Office::where('id', $office[0])->update([
                        'name' => $office[1],
                    ]);
                } 

            } catch (\Exception $e) {

                 session()->flash('error',  'ملق اكسل غير مطابق !!');
                 
            }      
        }

        return redirect()->route('dashboard.offices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.offices.create');
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
            'name' => 'required|unique:offices,name',
        ]);
        Office::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.offices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        return view('dashboard.offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        $request->validate([
            'name' => ['required' , Rule::unique('offices')->ignore($office->id),],
        ]);

        $office->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.offices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.offices.index');
    }
}

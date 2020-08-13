<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Office;
use Illuminate\Validation\Rule;

class OfficeController extends Controller
{
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

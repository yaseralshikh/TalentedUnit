<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Office;
use App\School;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offices = Office::all();

        $schools = School::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'like' , '%' . $request->search . '%')
                     ->orWhere('moe_id', 'like', '%' . $request->search . '%')
                     ->orWhere('manager', 'like', '%' . $request->search . '%')
                     ->orWhere('mobile', 'like', '%' . $request->search . '%')
                     ->orWhere('email', 'like', '%' . $request->search . '%');

        })->when($request->stage, function ($q) use ($request) {

            return $q->where('stage', $request->stage);

        })->when($request->office_id, function ($q) use ($request) {

            return $q->where('office_id', $request->office_id);

        })->orderBy('name')->paginate(50);

        return view('dashboard.schools.index', compact('offices', 'schools'));
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
            'manager' => 'required',
            'mobile' => 'digits_between:10,14',
            'email' => 'email',
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
            'manager' => 'required',
            'mobile' => 'digits_between:10,14',
            'email' => 'email',
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

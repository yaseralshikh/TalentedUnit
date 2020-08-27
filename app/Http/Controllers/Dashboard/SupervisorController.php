<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use App\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class SupervisorController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:supervisors_read'])->only('index');
        $this->middleware(['permission:supervisors_create'])->only('create');
        $this->middleware(['permission:supervisors_update'])->only('edit');
        $this->middleware(['permission:supervisors_delete'])->only('destroy');

    }//end of constructor

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $supervisors = User::whereRoleIs('admin')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                     ->orWhere('mobile', 'like', '%' . $request->search . '%')
                     ->orWhere('email', 'like', '%' . $request->search . '%')
                     ->orWhere('idcard', 'like', '%' . $request->search . '%');

        })->paginate(10);

        return view('dashboard.supervisors.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = Office::all();
        return view('dashboard.supervisors.create' , compact('offices'));
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
            'idcard' => 'required|digits:10|unique:users,idcard',
            'mobile' => 'required|digits_between:10,14',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);


        if ($request->image) {

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if
        
        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);
        

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.supervisors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offices = Office::all();
        $user = User::findOrFail($id);
        return view('dashboard.supervisors.edit', compact('user','offices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'idcard' => ['required','digits:10', Rule::unique('users')->ignore($id),],
            'mobile' => 'required|digits_between:10,14',
            'email' => ['required', Rule::unique('users')->ignore($id),],
            'image' => 'image',
            'password' => 'confirmed',
            'permissions' => 'required|min:1'
        ]);

        $user = User::findOrFail($id);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);

        if ($request->password <> NULL) {
            $request_data['password'] = bcrypt($request->password);
        }

        if ($request->image) {

            if ($user->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);

            }//end of inner if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if
        
        $user->update($request_data);
        $user->syncPermissions($request->permissions);
        

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.supervisors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.supervisors.index');
    }
}

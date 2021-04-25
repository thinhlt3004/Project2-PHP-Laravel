<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Models\Province;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Admin_StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff_users = User::where('is_staff' , 1)->get();
        return view('admin.staff.list' , [
            'staff_users' => $staff_users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff_users = User::where('is_staff' , 1)->get();
        $staff_roles = Staff::get();
        $provinces = Province::get();
        return view('admin.staff.add' , [
            'staff_users' => $staff_users,
            'staff_roles' => $staff_roles,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'is_staff' => 'required',
            'role' => 'required|in:Staff,Inspector',
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('role'));

        return redirect()->route('admin.staff.index')
                        ->with('success',"Staff : {$user->name} - {$user->email} created successfully");
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
    public function edit($id)
    {
        $staff_user = User::where('id' , $id)->first();
        $staff_roles = Staff::get();
        $provinces = Province::get();
        return view('admin.staff.edit' , [
            'staff_user' => $staff_user,
            'staff_roles' => $staff_roles,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'is_staff' => 'required',
            'email' => 'prohibited', 
            'role' => 'required|in:Staff,Inspector',
        ]);

        $user = User::where('id' , $id)->first();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->ward_id = $request->ward_id;
        $user->housenumber_street = $request->housenumber_street;
        $user->save();

        $staff = Staff::where('user_id' , $id)->first();
        $staff->role = $request->role;
        $staff->save();

        return redirect()->route('admin.staff.index')
                        ->with('success',"Staff : {$user->name} - {$user->email} Edit successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

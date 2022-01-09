<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "All Customer";
        $listusers  = User::get();
        return view('admin/user/index',compact('title','listusers'));
    }

    /*public function getdata(){
        $listusers             = User::get();
        return $listusers;
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Customer";
        return view('admin/user/create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $customer = User::create($inputs);
        if($customer){
         //return redirect('/admin/user')->with('message', 'User Added Successfully')->with('type', 'success');
         return redirect()->route('user.index')
         ->with('message','User added successfully')
         ->with('type', 'success');
        }
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
    public function edit(User $user)
    {
        
        $title = "Edit Customer";
        return view('admin/user/edit',compact('title','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $userdata = $user->update($request->all());

        if($userdata){
         //return redirect('/admin/user')->with('message', 'User Updated Successfully')->with('type', 'success');
         return redirect()->route('user.index')
         ->with('message','User updated successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')
                        ->with('message','User deleted successfully')
                        ->with('type', 'success');
    }
}

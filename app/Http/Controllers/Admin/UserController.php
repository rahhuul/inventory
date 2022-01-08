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
        $userresult = new User();
        $userresult->name = $request->post('name');
        $userresult->email = $request->post('email');
        $userresult->address = $request->post('address');
        $userresult->type = $request->post('user_type');
        $userresult->mobile = $request->post('mobile');
        $userresult->created = Carbon::now();
        $userresult->save();
        if($userresult)
        {
         return redirect('/admin/user')->with('message', 'User Added Successfully')->with('type', 'success');
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
    public function edit($id)
    {
        
        $title = "Edit Customer";
        $result =  User::where('id',$id)->first();
        return view('admin/user/edit',compact('title','result'));
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
        $userdata =User::where('id',$id)->first();
        $userdata->name = $request->post('name');
        $userdata->email = $request->post('email');
        $userdata->address = $request->post('address');
        $userdata->type = $request->post('user_type');
        $userdata->mobile = $request->post('mobile');
        $userdata->created = Carbon::now();
        $userdata->save();
        if($userdata)
        {
         return redirect('/admin/user')->with('message', 'User Updated Successfully')->with('type', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/admin/user')->with('message', 'User Deleted Successfully')->with('type', 'success');
    }
}

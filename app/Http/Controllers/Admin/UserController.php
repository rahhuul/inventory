<?php

namespace App\Http\Controllers\Admin;

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
        $title = "Customers";
        return view('admin/user/index',compact('title')); 
    }

    public function allCustomers(Request $request){
        $columns = array( 
            0 =>'user_id', 
            1 =>'name',
            2=> 'mobile',
            3=> 'amount',
            4=> 'type'
        );

        $totalData = User::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
        $posts = User::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  User::where('user_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('mobile', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = User::where('user_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('mobile', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $c = 1;
            foreach ($posts as $post){
            //$show =  route('user.show',$post->id);
                $edit =  route('user.edit',$post->user_id);
                $view =  route('user.show',$post->user_id);
                //$view =  route('deposit.create',$post->user_id);
                $add =  URL('user/adddeposit').'/'.$post->user_id;
            
                $nestedData['id'] = $c;
                $nestedData['name'] = $post->name;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['amount'] = $post->amount?$post->amount:0;
                $nestedData['type'] = ($post->type == 0) ? "Rental" : "Provider";
                $nestedData['options'] = "<a href='{$edit}' class='btn btn-info btn-sm'>
                <i class='fas fa-edit'>
                </i>
                </a>
                <a data-id='{$post->user_id}' data-name='{$post->name}' href='javascript:void(0)' class='btn btn-danger btn-sm'>
                <i class='fas fa-trash'>
                </i>
                </a>
                <button onClick='showAjaxModal(\"$view\", \"$post->name\")' class='btn btn-success btn-sm'>
                <i class='fas fa-play'>
                </i>
                </button>
                <button onClick='showAjaxModal(\"$add\", \"$post->name\")' class='btn btn-primary btn-sm'>
                <i class='fas fa-rupee-sign'></i>
                </i>
                </button>

                ";
                
                $data[] = $nestedData;
                $c++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        echo json_encode($json_data);
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

    public function adddeposit($id)
    { 
        $title = "Add Deposit";
        //$id = User::find($id);
        $customers = User::all()->pluck('name', 'user_id');
       /* echo "<pre>";
        print_r($);
        exit;*/
        return view('admin/user/depositcreate',compact('title','customers','id'));
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
    public function show(User $user)
    {
        return view('admin/user/show',compact('user'));
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
        $data = $request->all();
        $userdata = $user->update(['amount'=>($user['amount']=='')?$data['amount']:($user['amount']+$data['amount'])]);

        if($userdata){
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

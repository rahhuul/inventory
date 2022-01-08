<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Usermaster;
use Cookie,Hash,Validator;

class Login_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $title  = "Login";
        $userdata = Usermaster::where('id',1)->first();
        if(Cookie::get('admin_loginid') == ''){
              return view('admin/layouts/login',compact('title')); 
        }
        else{
              return Redirect('/admin/dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

    /*loginaction start*/
    public function loginaction(Request $request){
       
        $validator = Validator::make($request->all(), [
            'txtusername' => 'required',
            'txtpassword'  => 'required',
        ],
        [ 
            'txtusername.required' => 'Please Enter UserName or Email ID.',
            'txtpassword.required' => 'Please Enter Password.',
        ]);

        if ($validator->fails()){
            $errors = $validator->errors();
            echo $errors;
            exit;
        }
        else{
            $res   = [];
            $email = $request->input('txtusername');
            $check_users = Usermaster::where('email',$email)
                                    ->orWhere('username',$email)
                                    ->get()
                                    ->toArray();

            if(count($check_users) > 0){
                if(Hash::check($request->post('txtpassword'),$check_users[0]['password'])) {
                    $res = ['type' => 'success' ,
                            'msg' => 'You are login successfully.', 
                            'url' => '/admin/dashboard',
                            'result' => true
                        ];
                
                    $response = new \Illuminate\Http\Response(json_encode($res));
                    $response->withCookie(cookie('admin_loginid', Crypt::encrypt($check_users[0]['id']),7200));
                    return $response;
                }       
                else{
                    $res = ['type' => 'error' ,
                            'msg' => 'Password is worng.', 
                            'url' => '/admin/login', 
                            'result' => true
                        ];
                }
            }
            else{
                $res = ['type' => 'error' , 
                        'msg' => 'UserName or Email ID is worng.', 
                        'url' => '/admin/login', 
                        'result' => true
                    ];
            }
            echo json_encode($res);
            exit;
        }
    }
    /*loginaction end*/

    /*logut function start*/
    public function logout(){
        $c = \Cookie::forget('admin_loginid');
        return redirect('/admin/login')->withCookie($c);
    }
    /*logut function end*/
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Received;
use App\Models\User;
use App\Models\Rent;
use App\Models\Category;
use App\Models\Material;
use Carbon\Carbon;


class PendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "hello";exit;
        $title = "All Pending Material";
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/pendingmaterial/index',compact('title','customers'));
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
       // echo $id;exit;
       //$customers =  Rent::with('customer','category','material')->get();
        $alldetail = Received::with('rent','rent.customer','rent.category','rent.material')->whereHas('rent', function ($query) use($id) {
               $query->where('rent_id', $id );
            })->first();
        /*$customers = Received::with('rent')->get();*/
       /* echo "<pre>";
        print_r($alldetail);*/

        return view('admin/pendingmaterial/show',compact('alldetail'));
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
    public function allpenmaterials(Request $request)
    {
         $columns = array( 
            0 =>'rent_id', 
            1 =>'customer_id',
            2 => 'material_id',
            3 => 'quantiry',
            4 => 'ordered_at',
        );
         $pendingmaterial =array();
         $pending =array();
        $customer_id = $request->input('filter_option');
        if(!empty($customer_id)){ 

               
                 $rentdata = Rent::with('customer')->where('customer_id', $customer_id )->get();
                foreach($rentdata as $k=>$val)
                {
                    if($val->quantity != $val->return_quantity){
                        $pendingmaterial[] = $val;
                    }
                }
               // $totalData = Rent::with('customer')->where('customer_id', $customer_id )->count();

                $totalData = count($pendingmaterial);

                $totalFiltered = $totalData; 
        }
        else
        {
             $rentdata = Rent::get();
             foreach($rentdata as $k=>$val)
                {
                    if($val->quantity != $val->return_quantity){
                        $pendingmaterial[] = $val;
                    }
                }
             $totalData = count($pendingmaterial);
             $totalFiltered = $totalData; 
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')) && !empty($customer_id))
        {            
        $rents = Rent::whereHas('customer',function ($query) use($customer_id) {
                 $query->where('customer_id', $customer_id );
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                //->groupBy('customer_id')
                ->get();


       // Rent::with('customer', 'category', 'material')
                
        }
        else {
        $search = $request->input('search.value'); 
        $dt = date('Y-m-d', strtotime($search));

        $rents =  Rent::with('customer', 'category', 'material')
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('ordered_at',$dt)

                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Rent::with('customer', 'category', 'material')
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('ordered_at',$dt)
                    ->count();
        }
        foreach($rents as $k=>$val)
        {
            if($val->quantity != $val->return_quantity){
                $pending[] = $val;
            }
        }

        $data = array();
        if(!empty($pending))
        {
            $c = 1;
            foreach ($pending as $post){

                $remainQty = ($post->remain_quantity != null || $post->remain_quantity != 0) ? $post->remain_quantity : $post->quantity;

                $date = Carbon::parse($post->ordered_at);
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                $diff = $diff+1;
                
                $days = ($diff < 15) ? 15 : $diff;
                $diff = ($diff < 15) ? 15 : $diff;

            //$show =  route('user.show',$post->id);
                $edit =  route('rent.edit',$post->rent_id);
                $view =  route('pending.show',$post->rent_id);
                //$receive = route('receive.create');
                $received = URL('rent/addreceive').'/'.$post->rent_id;
                $nestedData['id'] = $c;
                $nestedData['customer'] = $post->customer->name;
                $nestedData['material'] = $post->material->name;
                $nestedData['ordered_at'] = date('d-m-Y',strtotime($post->ordered_at));
                $nestedData['days'] = $diff;
                $nestedData['quantity'] = $remainQty;
                $nestedData['price'] = round(($post->material->rentperPrice*$remainQty)*$diff,2);
                $nestedData['options'] = "<button onClick='showAjaxModal(\"$view\", \"Pending Material\")' class='btn btn-success btn-sm'>
                <i class='fas fa-play'>
                </i>
                </button>";
                
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
}

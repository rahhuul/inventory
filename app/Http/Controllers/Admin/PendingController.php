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
    	$groupPending = [];
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

                 $rentdata = Rent::with('customer')
                            ->where('customer_id', $customer_id )
                            ->where('status', 0)
                            ->get();
                foreach($rentdata as $k=>$val)
                {
                    if($val->quantity != $val->return_quantity){
                        $pendingmaterial[] = $val;
                    }
                }
               // $totalData = Rent::with('customer')->where('customer_id', $customer_id )->count();

                $totalData = count($pendingmaterial);

                $totalFiltered = $totalData; 
        } else {
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
        //$order = $columns[$request->input('order.0.column')];
        //$dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')) && !empty($customer_id)) {            
            $rents = Rent::whereHas('customer',function ($query) use($customer_id) {
                 $query->where('customer_id', $customer_id );
                })
                ->where('status', 0)
                ->offset($start)
                ->limit($limit)
                //->orderBy($order,$dir)
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
                    ->where('status', 0)
                    ->offset($start)
                    ->limit($limit)
                    //->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Rent::with('customer', 'category', 'material')
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('ordered_at',$dt)
                    ->where('status', 0)
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
                $mainQty = ($post->quantity != null || $post->quantity != 0) ? $post->quantity : $post->quantity;
                $receivedQty = ($post->return_quantity != null || $post->return_quantity != 0) ? $post->return_quantity : 0;

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

                if($post->customer && $post->material){
                    
                    $material_name = ($post->material) ? $post->material->name : null;
                    $customer_name = ($post->customer) ? $post->customer->name : null;
                    
                    if($material_name && $customer_name){
                        $mat_id = $post->material->material_id;
                        $groupPending[$mat_id]['material']  = $material_name;
                        $groupPending[$mat_id]['quantity']  = isset($groupPending[$mat_id]['quantity']) ? $groupPending[$mat_id]['quantity'] + $mainQty : $mainQty;
                        $groupPending[$mat_id]['pending']  = isset($groupPending[$mat_id]['pending']) ? $groupPending[$mat_id]['pending'] + $remainQty : $remainQty;
                        $groupPending[$mat_id]['received']  = isset($groupPending[$mat_id]['received']) ? $groupPending[$mat_id]['received'] + $receivedQty : $receivedQty;

                        $nestedData['id'] = $c;
                        $nestedData['customer'] = $customer_name;
                        $nestedData['material'] = $material_name;
                        $nestedData['ordered_at'] = date('d-m-Y',strtotime($post->ordered_at));
                        $nestedData['days'] = $diff;
                        $nestedData['quantity'] = $remainQty;
                        $nestedData['perdayprice'] = ($post->material) ? round($post->material->rentperPrice, 2) : 0;
                        $nestedData['quantityprice'] = ($post->material) ? round(($post->material->rentperPrice*$remainQty),2) : 0;
                        $nestedData['price'] = ($post->material) ? round(($post->material->rentperPrice*$remainQty)*$diff,2) : 0;
                        $nestedData['options'] = "";

                        
                    }
                }
                
                $data[] = $nestedData;
                $c++;
            }
        }

        $sortKeys = ['id', 'customer', 'material', 'ordered_at', 'days', 'quantity','perdayprice','quantityprice','price' ];

        $orderDir = ($request->input('order.0.dir') == 'asc') ? SORT_ASC : SORT_DESC;
        array_multisort(array_column($data, $sortKeys[$request->input('order.0.column')]), $orderDir, SORT_NATURAL|SORT_FLAG_CASE, $data);

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            'groupPending'    => $groupPending,
            "data"            => $data
            );

        echo json_encode($json_data);
    }
}

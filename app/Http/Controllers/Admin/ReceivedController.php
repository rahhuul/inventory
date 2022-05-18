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

class ReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Receive";
        $listReceive  = Received::get();
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/receive/index',compact('title','listReceive','customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Receive";
        $rentdata = Rent::with('customer', 'category', 'material')->get();
        $customers = User::all()->pluck('name', 'user_id');
        $categories = Category::all()->pluck('name', 'category_id');
        $materials = Material::with('category')->get();
        //$receivedata = Received::where('rent_id',$id)->get();
      /* echo "<pre>";
        print_r($rentdata);exit;*/
        return view('admin/receive/create',compact('title','rentdata','customers','materials' ));
    }

    public function getMaterials(Request $request){
         $customer_id = $request->post('customer_id');
         $result=[];
         $rentdetail = Rent::with('material')
         ->where('customer_id',$customer_id)
         ->where('status', 0)
         ->selectRaw('*, sum(quantity) as total, sum(return_quantity) as returntotal')
         ->groupBy('material_id')
         ->get();
         /* $rentdetail = Rent::with('material')
            ->where('customer_id',$customer_id)
            ->sum('quantity')
            ->groupBy('material_id')->map(function ($row) {
                return $row->sum('quantity');
            })
            ->get(); */
          $m=1;

         foreach($rentdetail as $data){
            $result[$m]['name'] = $data->material->name;
            $result[$m]['orderdate'] = date("d-m-Y", strtotime($data->ordered_at));
            $result[$m]['rentid'] = $data->rent_id;
            $result[$m]['status'] = ($data->returntotal != '') ? $data->returntotal : 0;
            $result[$m]['rentquantity'] = $data->total;
            $result[$m]['materialquantity'] = $data->material->quantity;
            $result[$m]['id'] =  $data->material->material_id;
             $m++;   
         }

        $json_data = array(
            "data" => $result   
        );


        echo json_encode($json_data);


         //Material::where()

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receiveinfo ='';
        $inputs = $request->input();
        $customer_id = $inputs['customer_id'];
        $materials = $inputs['material'];

        $rents = Rent::where("customer_id", $customer_id)
            ->where("status", 0)
            ->orderBy('ordered_at', 'asc')
            ->get()
            ->toArray();

        //echo "<pre>";
        //print_r($rents);
        //print_r($materials);
        //echo "</pre>";
        $orders = [];
        foreach($rents as $k => $v){
            $mKey = $v['material_id'];
            if(isset($materials[$mKey])){
                $current_material = $materials[$mKey];
                $quantity = $v['remain_quantity'];
                $main_quantity = $v['quantity'];
                //print_r($current_material);
                if($current_material['received_quantity'] > $quantity){
                    $materials[$mKey]['received_quantity'] =  $current_material['received_quantity'] - $quantity;
                    $orders[$mKey][$k]['status'] = 2;
                    $orders[$mKey][$k]['remain'] = abs($current_material['received_quantity'] - $quantity);
                    $orders[$mKey][$k]['pending'] = 0;
                    $orders[$mKey][$k]['received_quantity'] = $quantity;
                }
                
                if($current_material['received_quantity'] < $quantity){
                    $materials[$mKey]['received_quantity'] =  0;
                    $orders[$mKey][$k]['status'] = 1;
                    $orders[$mKey][$k]['remain'] = abs($current_material['received_quantity'] - $quantity);
                    $orders[$mKey][$k]['pending'] = abs($current_material['received_quantity'] - $quantity);
                    $orders[$mKey][$k]['received_quantity'] = $current_material['received_quantity'];
                }
    
                if($current_material['received_quantity'] == $quantity){
                    $materials[$mKey]['received_quantity'] =  0;
                    $orders[$mKey][$k]['status'] = 2;
                    $orders[$mKey][$k]['remain'] = 0;
                    $orders[$mKey][$k]['pending'] = 0;
                    $orders[$mKey][$k]['received_quantity'] = $current_material['received_quantity'];
                }
                
                $orders[$mKey][$k]['quantity'] = $main_quantity;
                $orders[$mKey][$k]['order_date'] = $v['ordered_at'];
                $orders[$mKey][$k]['receive_date'] = date("Y-m-d", strtotime($inputs['receive_date']));
                $orders[$mKey][$k]['rent_id'] = $v['rent_id'];
            } 
        }
        

        foreach($orders as $orderKey => $orderVal){
            $totalrcvQty = 0;
            foreach($orderVal as $order){
                $receive['rent_id'] = $order['rent_id'];
                $receive['material_id'] = $orderKey;
                $receive['customer_id'] = $customer_id;
                $receive['receive_status'] = (string) $order['status'];
                $receive['receive_date'] = $order['receive_date'];
                $receive['received_quantity'] = $order['received_quantity'];
                $receive['pending_material'] = $order['pending'];

                if($receive['received_quantity'] > 0){
                    $rentItem = Rent::find($order['rent_id']);
                    $rentItem->return_quantity = $rentItem->return_quantity + $order['received_quantity'];
                    $rentItem->remain_quantity =  $rentItem->remain_quantity - $order['received_quantity'];
                    //$rentItem->status =  ($order['status'] == 1) ? 0 : ($order['status'] == 2 ? 1 : 0);
                    if($rentItem->quantity == $rentItem->return_quantity && $rentItem->remain_quantity == 0) {
                        $rentItem->status = 1;
                        $receive['receive_status'] = '2';
                    }else{
                        $rentItem->status = 0;
                        $receive['receive_status'] = '1';
                    }
                    $rentItem->save();
                    
                    /* echo "<pre>";
                    print_r($receive);
                    echo "</pre>"; */
                    $receiveinfo = Received::create($receive);
                    $totalrcvQty += $order['received_quantity'];
                }
            }
            $material = Material::find($orderKey);
            $material->quantity = $material->quantity + $totalrcvQty;
            $material->save();

        }

        return redirect()->route('received.index')
             ->with('message','Receive added successfully')
             ->with('type', 'success');
    }

      public function allReceive(Request $request){
        $searchFilter = array(); 
         $columns = array( 
            0 =>'received_id', 
            1 =>'rent_id',
            2 => 'receive_status',
            3 => 'receive_date',
            4 => 'received_quantity',
        );

      $customer_id = $request->input('filter_option');
         if(!empty($customer_id)){ 
             $received = Received::whereHas('rent', function ($query) use($customer_id) {
               $query->where('customer_id', $customer_id );
            })->get();
              $totalData =count($received);
             $totalFiltered = $totalData; 
        } 
        else
        {
            $received = Received::with('rent','rent.customer','rent.category','rent.material')->orderBy('receive_date','DESC')->get();
              $totalData =count($received);
            $totalFiltered = $totalData;
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        //$dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')) && !empty($customer_id) )
        {            
        $received =  Received::whereHas('rent', function ($query) use($customer_id) {
               $query->where('customer_id', $customer_id );
            })
                ->offset($start)
                ->limit($limit)
                //->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value'); 
        $dt = date('Y-m-d', strtotime($search));
       
        $received =  Received::with('rent','rent.customer','rent.category','rent.material', 'material')
                    ->orWhere('received_quantity', 'LIKE',"%{$search}%")
                    ->orWhere('receive_date',$dt)
                    ->offset($start)
                    ->limit($limit)
                    //->orderBy($order,$dir)
                    ->get();
                    

        $totalFiltered = Received::with('rent','rent.customer','rent.category','rent.material', 'material')
                    ->orWhere('received_quantity', 'LIKE',"%{$search}%")
                    ->orWhere('receive_date',$dt)
                    ->count();
        }

        $data = array();
        if(!empty($received))
        {
            $c = 1;
            foreach ($received as $post){
                $edit =  route('received.edit',$post->received_id);
                $view =  route('received.show',$post->received_id);

                $rendDate = Carbon::parse($post->receive_date);
                $rent_data = ($post->rent) ? Carbon::parse($post->rent->ordered_at) : null;
                $diff = $rendDate->diffInDays($rent_data) + 1;
                $diff = ($diff < 15) ? 15 : $diff;
                $totalRentprice = ($post->rent && $post->rent->material) ? ($post->received_quantity * $post->rent->material->rentperPrice) * $diff : 0;

                if($post->rent && $post->rent->customer && $post->rent->material){
                    $nestedData['id'] = $c;
                    $nestedData['customer'] = ($post->rent->customer) ? $post->rent->customer->name : null;
                    $nestedData['material'] = ($post->rent->material) ? $post->rent->material->name : null;
                    $nestedData['price'] = ($post->rent->material) ? $post->rent->material->rentPrice : 0;
                    $nestedData['from_date'] = date('d-m-Y',strtotime($post->rent->ordered_at));
                    $nestedData['receive_date'] = date('d-m-Y',strtotime($post->receive_date));
                    $nestedData['days'] = $diff;
                    $nestedData['received_quantity'] = $post->received_quantity;
                    $nestedData['received_price'] = round($totalRentprice, 2);
                
                    $nestedData['options'] = "<a href='".$edit."' class='btn btn-info btn-sm'>
                    <i class='fas fa-edit'>
                    </i>
                    </a>";
                    $data[] = $nestedData;
                }
                
                $c++;
            }
        }

        $sortKeys = ['id', 'customer', 'material', 'price', 'from_date', 'receive_date', 'days', 'received_quantity', 'received_price' ];

        $orderDir = ($request->input('order.0.dir') == 'asc') ? SORT_ASC : SORT_DESC;
        array_multisort(array_column($data, $sortKeys[$request->input('order.0.column')]), $orderDir, SORT_NATURAL|SORT_FLAG_CASE, $data);
      
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        echo json_encode($json_data);

      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Received $received)
    {

        return view('admin/receive/show',compact('received'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Received $received)
    {

        $rev = Received::with('material','rent')->where('material_id',$received->material_id)->first();
        $rent =  Rent::with('material')->where('rent_id',$received->rent_id)->get();
        $title = "Edit Received";
        $customers = User::all()->pluck('name', 'user_id');
        $materials = Material::all()->pluck('name', 'material_id');
    
        return view('admin/receive/edit',compact('title','received','customers','materials','rev'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Received $received)
    {
        $inputs = $request->input();
        /* echo "<pre>";
        print_r($inputs);
        exit; */

        $inputs['receive_date'] = date("Y-m-d", strtotime($inputs['receive_date']));
        $material = Material::find($inputs['exist_material_id']);
        $rent = Rent::find($inputs['exist_rent_id']);

        /*if($inputs['exist_rent_quantity'] >= $rent->return_quantity)
        {*/
            if($inputs['exist_received_quantity'] >= $inputs['received_quantity']){

                $rent->return_quantity  = $rent->return_quantity + ($inputs['received_quantity'] - $inputs['exist_received_quantity']);
                $rent->remain_quantity =$rent->quantity - $rent->return_quantity;
                $rent->save();

                $received->received_quantity = $inputs['received_quantity'];
                $received->pending_material = $rent->remain_quantity;
                $received->receive_date = $inputs['receive_date'];
                $received->save();

                $material->quantity = $material->quantity - ($inputs['exist_received_quantity'] - $inputs['received_quantity']);
                $material->save();
            }
            if($inputs['exist_received_quantity'] < $inputs['received_quantity']){
                $rent->return_quantity  = $rent->return_quantity + ($inputs['received_quantity'] - $inputs['exist_received_quantity']);
                $rent->remain_quantity =$rent->quantity - $rent->return_quantity;
                $rent->save();

                $received->received_quantity = $inputs['received_quantity'];
                $received->pending_material = $rent->remain_quantity;
                $received->receive_date = $inputs['receive_date'];
                $received->save();

                $material->quantity = $material->quantity + ($inputs['received_quantity'] - $inputs['exist_received_quantity']);
                $material->save();

                /* echo "<pre>";
                print_r($rent);
                print_r($received);
                print_r($material);
                exit; */
            }
       /* }
        else
        {
           

        }*/
                
        
        //$receivedata = $received->update($inputs);

        //if($receivedata){
        return redirect()->route('received.index')
         ->with('message','Received updated successfully')
         ->with('type', 'success');
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Received $received)
    {
       $received->delete();
       return redirect()->route('received.index')
                        ->with('message','Received deleted successfully')
                        ->with('type', 'success');
    }
}

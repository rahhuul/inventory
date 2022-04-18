<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Received;
use App\Models\Material;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use PDF;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Generate Bill";
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/bill/index',compact('title','customers'));
    }

    public function allcustmaterials(Request $request){
         $columns = array( 
            0 =>'rent_id', 
            1 =>'material_id',
            2 => 'received_quantity',
            3 => 'ordered_at',
            4 => 'receive_date',
            5 => 'price',
            6 => 'rent_total', 
        );
        $customermaterial = array();
        $customer_id = $request->input('filter_option');
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $data = array();
        $pending = '';
        $renttotal =0;
        $receivedtotal =0;
        if(!empty($customer_id)){ 

        $rents = Rent::with('customer','material')->where('customer_id',$customer_id)->orderBy('ordered_at','ASC')->get();
        $received = Received::with('customer','material')->where('customer_id',$customer_id)->orderBy('receive_date','ASC')->get();
        $mixedcustomerdata = array_merge((array)json_decode($rents),(array)json_decode($received));
    
        $totalData = count((array)$mixedcustomerdata);
        $totalFiltered = $totalData; 


         if(empty($request->input('search.value')) && !empty($customer_id))
        {            
         $rents = Rent::with('customer', 'material', 'received')->whereHas('customer',function ($query) use($customer_id) {
                 $query->where('customer_id', $customer_id );
                })
                ->orderBy('ordered_at','ASC')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(); 


         $received = Received::with('customer', 'material', 'rent')->whereHas('customer',function ($query) use($customer_id) {
                         $query->where('customer_id', $customer_id );
                        })
                        ->orderBy('receive_date','ASC')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(); 
        $mixedcustomerdata = array_merge((array)json_decode($rents),(array)json_decode($received));
        }
        // else {
        // $search = $request->input('search.value'); 
        // $dt = date('Y-m-d', strtotime($search));

        // $rents =  Rent::with('customer', 'category', 'material')->whereHas('customer',function ($query) use($customer_id) {
        //          $query->where('customer_id', $customer_id );
        //         })
        //             ->offset($start)
        //             ->limit($limit)
        //             ->orderBy($order,$dir)
        //             ->get();

        // $totalFiltered = Rent::with('customer', 'category', 'material')->whereHas('customer',function ($query) use($customer_id) {
        //          $query->where('customer_id', $customer_id );
        //         })
        //             ->orWhere('material_id', 'LIKE',"%{$search}%")
        //             ->orWhere('quantity', 'LIKE',"%{$search}%")
        //             ->orWhere('ordered_at',$dt)
        //             ->count();
        // }
             $c = 1;
             $rendDate = '';
            $totalRentprice = 0;
            foreach ($mixedcustomerdata as $post){

            if(isset($post->status))
            {
                
                if(count($post->received) > 0 ){
                    foreach ($post->received as $key => $value) {
                        $rendDate = Carbon::parse($post->ordered_at);
                        $now = Carbon::parse($value->receive_date);
                        $diff = $rendDate->diffInDays($now);
                        $diff = $diff + 1;
                        $diff = ($diff < 15) ? 15 : $diff;

                        if($post->status == 0){
                            $calcQty = $post->remain_quantity;
                            $totalRentprice = $calcQty * $post->material->rentperPrice * $diff;
                            $renttotal += $totalRentprice;
                        }/* else{
                            $calcQty = $post->quantity;
                        } */
                    }
                }else{

                    $rendDate = Carbon::parse($post->ordered_at);
                    $now = Carbon::now();
                    $diff = $rendDate->diffInDays($now);
                    $diff = $diff + 1;
                    $diff = ($diff < 15) ? 15 : $diff;
                    
                    $calcQty = ($post->remain_quantity == null || $post->remain_quantity == 0) ? $post->quantity : $post->remain_quantity;
                    $totalRentprice = $calcQty * $post->material->rentperPrice * $diff;
                    $renttotal += $totalRentprice;
                }
            }
            else
            {
                $receiveDate = Carbon::parse($post->receive_date);
                $rent_data = Carbon::parse($post->rent->ordered_at);
                $diff = $rent_data->diffInDays($receiveDate) + 1;
                $totalRentprice = ($post->received_quantity * $post->material->rentperPrice) * $diff;
                $receivedtotal +=$totalRentprice;
            }

               

                $edit =  route('rent.edit',$post->rent_id);
                $view =  route('pending.show',$post->rent_id);
                $received = URL('rent/addreceive').'/'.$post->rent_id;
                $nestedData['id'] = $c;
                $nestedData['material'] = (isset($post->status))?$post->material->name:$post->material->name;
                $nestedData['quantity'] = (isset($post->status))?($post->quantity):((isset($post->received_id))?$post->received_quantity:0);
                $nestedData['ordered_date'] = (isset($post->status))?date('d-m-Y',strtotime($post->ordered_at)):'-';
                $nestedData['received_date'] = (isset($post->receive_status))?date('d-m-Y',strtotime($post->receive_date)):'-';
                $nestedData['price'] = $post->material->rentPrice;
                $nestedData['total'] = round($totalRentprice,2);
                //$nestedData['pending'] = round(($renttotal - $receivedtotal),2);
                $data[] = $nestedData;
                $c++;

            }
            
          $pending = round(($renttotal - $receivedtotal),2);
        }

        
        

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => (isset($totalData))?intval($totalData):0,  
            "recordsFiltered" => (isset($totalFiltered))?intval($totalFiltered):0, 
            "data"            => $data,
            "pending"         =>$pending,
            "renttotal"       =>round($renttotal,2),
            "receivedtotal"   =>round($receivedtotal,2),
            );
        echo json_encode($json_data);
        
    
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title= "All detail";
        $customers = User::all()->pluck('name', 'user_id');
        $customer_id = $id;
        $userdata = User::where('user_id',$customer_id)->first();
        $rents = Rent::with('customer','material')->where('customer_id',$customer_id)->orderBy('ordered_at','ASC')->get();
        $received = Received::with('customer','material')->where('customer_id',$customer_id)->orderBy('receive_date','ASC')->get();
        $mixedcustomerdata = array_merge((array)json_decode($rents),(array)json_decode($received));
        if(count($mixedcustomerdata) > 0)
        {
           view()->share('admin/bill/show',$mixedcustomerdata,$rents);
        $pdf = PDF::loadView('admin/bill/show', ['mixedcustomerdata' => $mixedcustomerdata,
            'userdata'=>$userdata,
            'customer_id'=>$customer_id,
            'rents'=>$rents
        ]);
        return $pdf->download('invoice.pdf');
        }
        else
        {
          return view('admin/bill/index',compact('title','customers'));
        }

       

      //  return view('admin/bill/show',compact('title','mixedcustomerdata','userdata','customer_id'));




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

    public function generatePDF($id)
    {
        $title= "All detail";
        $receiveddata =  Rent::with('customer', 'category', 'material','received')
                        ->where('rent_id', $id)
                        ->first()->toarray();

                         view()->share('admin/bill/mypdf',$receiveddata);
        $pdf = PDF::loadView('admin/bill/mypdf', ['receiveddata' => $receiveddata]);
        return $pdf->download('invoice.pdf');
        exit;






        /*echo "<pre>";
        print_r(PDF);exit;
    
        $pdf = PDF::loadView('admin/bill/mypdf', $receiveddata);

        return $pdf->download('itsolutionstuff.pdf');*/
    }
}

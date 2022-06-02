<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Received;
use App\Models\Material;
use App\Models\Category;
use App\Models\User;
use App\Models\ReceivedChallan;
use Carbon\Carbon; 
use PDF;

class ReceivedChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Received: Challan";
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/receivechallan/index',compact('title','customers'));
    }

    public function challans(Request $request){
        $columns = array( 
            0 =>'receivechallan_id', 
            1 =>'material_id',
            2 => 'quantity',
            3 => 'ordered_at',
            4 => 'days',
            5 => 'price', 
        );
        
        $customermaterial = array();
        $customer_id = $request->input('filter_option', 0);
        $filter_date = $request->input('filter_date', null);
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value', null);

        $data = array();
        $rentTotal = 0;
        $filter_date = date('Y-m-d',strtotime($filter_date));

        if($customer_id){

            $rents = ReceivedChallan::whereHas('customer',function ($query) use($customer_id) {
                        $query->where('customer_id', $customer_id );
                    })->with(['customer', 'material' => function ($query) use($search) {
                        if($search){
                            $query->where('name', 'LIKE', "%{$search}%");
                        }
                    }])
                    ->where('receive_date', $filter_date)
                    ->orderBy('receive_date','ASC')
                    ->get();
       
            $totalData = count($rents);
            $totalFiltered = $totalData; 
            $c = 1;
            foreach ($rents as $post){
                $totalRentprice = 0;
                $rent_data = Carbon::parse($post->ordered_at);
                $diff = 15;
                $totalRentprice = ($post->material) ? ($post->quantity * $post->material->rentperPrice) * $diff : 0;
                $rentTotal +=$totalRentprice;

                if($post->material){
                    $nestedData['id'] = $c;
                    $nestedData['material'] = (isset($post->material))? $post->material->name:$post->material->name;
                    $nestedData['quantity'] = $post->quantity;
                    $nestedData['ordered_date'] = date('d-m-Y',strtotime($post->receive_date));
                    $nestedData['days'] = $diff;
                    $nestedData['perprice'] = $post->material->rentperPrice;
                    $nestedData['price'] = round($totalRentprice,2);
                    $data[] = $nestedData;
                    $c++;
                }
            }
        }

        $sortKeys = ['id', 'material', 'quantity', 'ordered_date', 'days','price' ];
        $orderDir = ($request->input('order.0.dir') == 'asc') ? SORT_ASC : SORT_DESC;
        
        array_multisort(array_column($data, $sortKeys[$request->input('order.0.column')]), $orderDir, SORT_NATURAL|SORT_FLAG_CASE, $data);
        
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => (isset($totalData))?intval($totalData):0,  
            "recordsFiltered" => (isset($totalFiltered))?intval($totalFiltered):0, 
            "data"            => $data,
            "renttotal"       =>round($rentTotal,2)
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
    public function show(Request $request, $id) {
        $timestamp = $request->input('timestamp') + 86400;
        $filter_date = date("Y-m-d", $timestamp);
        $title= "All detail";
        $customer_id = $id;
        $userdata = User::where('user_id',$customer_id)->first();
        $received = ReceivedChallan::with('customer','material')
        ->where('customer_id',$customer_id)
        ->where('receive_date', $filter_date)
        ->orderBy('receive_date','ASC')->get();
        
        $mixedcustomerdata = array_merge((array)json_decode($received));

        if(count($mixedcustomerdata) > 0) {
            $pdf = PDF::loadView('admin/receivechallan/show', [
                'mixedcustomerdata' => $mixedcustomerdata,
                'userdata'=>$userdata,
                'customer_id'=>$customer_id,
                'rents'=>$received
            ]);
            return $pdf->download('invoice.pdf');
        } else {
            return view()->share('admin/receivechallan/show',$mixedcustomerdata,$rents);
        }
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
}

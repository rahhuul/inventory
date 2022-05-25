<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Material;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Received;
use App\Models\RentChallan;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "All Rent";
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/rent/index',compact('title','customers'));
    }

    public function allRents(Request $request){
        $columns = array( 
            0 =>'rent_id', 
            1 =>'customer_id',
            2 => 'material_id',
            3 => 'ordered_at',
            4 => 'rent_id',
            5 => 'quantity',
            6 => 'ordered_at',
            7 => 'rent_id',
            8 => 'status'
        );
        $data = array();
        $customer_id = $request->input('filter_option', 0);
        if(!empty($customer_id)){ 
                $totalData = Rent::with('customer')->where('customer_id', $customer_id )->count();
                $totalFiltered = $totalData; 
        }
        else
        {
             $totalData = Rent::count();
             $totalFiltered = $totalData; 
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value', null); 

        $rents = Rent::whereHas('customer',function ($query) use($customer_id) {
                    $query->where('customer_id', $customer_id );
                })->whereHas('material')
                ->with(['customer','material' => function($q) use($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    }
                ])
                ->offset($start)
                ->limit($limit)
                ->orderBy('ordered_at')
                ->get();
        /* if(empty($request->input('search.value')) && !empty($customer_id)) {
        } else {
        $dt = date('Y-m-d', strtotime($search));
        
        $rents =  Rent::whereHas('customer',function ($query) use($customer_id) {
                $query->where('customer_id', $customer_id );
           })->whereHas('material')->with(['material' => function($q) use($search) {
            $q->where('name', 'LIKE', "%{$search}%"); // '=' is optional
        }, 'category', 'received'])
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('ordered_at',$dt)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Rent::whereHas('customer')->whereHas('material')->with(['material' => function($q) use($search) {
            $q->where('name', 'LIKE', "%{$search}%"); // '=' is optional
        }, 'category', 'received'])
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('ordered_at',$dt)
                    ->count();
        } */

        
        if(!empty($rents))
        {
            $c = 1;
            $total =0 ;
            $status ='';

            /* echo "<pre>";
            print_r($rents);
            exit; */

            foreach ($rents as $key=>$post){

                $rendDate = Carbon::parse($post->ordered_at);
                $now = Carbon::now();
                $diff = $rendDate->diffInDays($now);
                $diff = $diff + 1;
                $diff = ($diff < 15) ? 15 : $diff;
                
                $calcQty = ($post->remain_quantity == null || $post->remain_quantity == 0) ? $post->quantity : $post->remain_quantity;

                $rentTotal = (($post->material)) ? ($diff > 15) ? ($calcQty*$post->material->rentperPrice) * $diff : $calcQty * $post->material->rentperPrice * 15 : 0;


                $edit =  route('rent.edit',$post->rent_id);
                $view =  route('rent.show',$post->rent_id);
                $received = URL('rent/addreceive').'/'.$post->rent_id;
                if($post->customer && $post->material){
                    $nestedData['id'] = $c;
                    $nestedData['customer'] = ($post->customer) ? $post->customer->name : '';
                    $nestedData['material'] =  ($post->material) ? $post->material->name : '';
                    $nestedData['ordered_at'] = date('d-m-Y',strtotime($post->ordered_at));
                    $nestedData['price'] = ($post->material) ? $post->material->rentPrice : 0;
                    $nestedData['quantity'] = $calcQty;
                    $nestedData['days'] = $diff;
                    $nestedData['renttotal'] = round($rentTotal, 2);
                
                if($post->status == 0)
                {
                    $status = '<span class="badge badge-primary">Pending</span>';
                }
                else
                {
                    $status = '<span class="badge badge-success">Completed</span>';
                }
                 $nestedData['status'] = $status;
                $nestedData['options'] = "<a href='{$edit}' class='btn btn-info btn-sm'>
                <i class='fas fa-edit'>
                </i>
                </a>
                <a data-id='{$post->rent_id}' data-name='Rent' href='javascript:void(0)' class='btn btn-danger btn-sm'>
                <i class='fas fa-trash'>
                </i>
                </a>";
                $data[] = $nestedData;
                }
                $c++;
            }
         //echo $total;
        }
        //$data[] =$total;

        if($request->input('order.0.column') != 3){
        	$sortKeys = ['id', 'customer', 'material', 'ordered_at', 'price', 'quantity', 'days', 'renttotal' ];
        	$orderDir = ($request->input('order.0.dir') == 'asc') ? SORT_ASC : SORT_DESC;
        	array_multisort(array_column($data, $sortKeys[$request->input('order.0.column')]), $orderDir, SORT_NATURAL|SORT_FLAG_CASE, $data);
    	}

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
            );  

        echo json_encode($json_data);
    }

    public function addreceive($id){
        $title = "Add Receive";
        $rentdata = Rent::with('customer', 'category', 'material')->find($id);
        $customers = User::all()->pluck('name', 'user_id');
        $categories = Category::all()->pluck('name', 'category_id');
        $materials = Material::all()->pluck('name', 'material_id');
        $receivedata = Received::where('rent_id',$id)->get();
      /* echo "<pre>";
        print_r($rentdata);exit;*/
        return view('admin/receive/create',compact('title','rentdata','customers','materials','id','receivedata'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $title = "Add Rent";
        $customers = User::all()->pluck('name', 'user_id');
        $categories = Category::all()->pluck('name', 'category_id');
        $materials = Material::with('category')->get();

       // ->get();
        //
        //  echo "<pre>";
        // print_r($materials);exit;
        return view('admin/rent/create',compact('title', 'customers', 'categories', 'materials'));
    }

    public function getMaterials(Request $request){
        $category_id = $request->input('category_id');
        $materials = Material::where(['category_id' => $category_id])->get();

        $m=1;
        $result[0]['text'] = 'Select Material';
        $result[0]['id'] = '';
        foreach($materials as $material){
            $result[$m]['text'] = $material->name;
            $result[$m]['id'] = $material->material_id;
            $result[$m]['quantity'] = $material->quantity;
            $m++;
        }
        
        $json_data = array(
            "data" => $result   
        );

        echo json_encode($json_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer ='';
        $inputs = $request->input();

        
        foreach ($inputs['quantity'] as $key => $value) {
            $inputs['material_id'] = $key;
            $inputs['quantity'] = $value;
            $inputs['remain_quantity'] = $value;
            
            $material = Material::find($key);
            $material->quantity = $material->quantity - $value;
            $material->save();
            
            $inputs['ordered_at'] = date("Y-m-d", strtotime($inputs['ordered_at']));
            $customer = Rent::create($inputs);
            $inputs['rent_id'] = $customer->rent_id;
            
            RentChallan::create($inputs);
        }
        if($customer){
            return redirect()->route('rent.index')
                ->with('message','Rent added successfully')
                ->with('type', 'success');
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //$rent = Rent::with('customer', 'category', 'material')->first();
        
        return view('admin/rent/show',compact('rent'));
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        $title = "Edit Rent";
        $customers = User::all()->pluck('name', 'user_id');
        $categories = Category::all()->pluck('name', 'category_id');
        $materials = Material::with('category')->get();
        return view('admin/rent/edit', compact('title', 'rent', 'customers', 'categories', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        $inputs = $request->input();
        $inputs['ordered_at'] = date("Y-m-d", strtotime($inputs['ordered_at']));
        $material = Material::find($inputs['exist_material_id']);
        // if($inputs['exist_material_id'] == $inputs['material_id']){
            if($inputs['exist_quantity'] > $inputs['quantity']){
                $material->quantity = $material->quantity + ($inputs['exist_quantity'] - $inputs['quantity']);
                $material->save();
            }
            if($inputs['exist_quantity'] < $inputs['quantity']){
                $material->quantity = $material->quantity - ($inputs['quantity'] - $inputs['exist_quantity']);
                $material->save();
            }
        // }else{
        //     $material->quantity = $material->quantity + $inputs['exist_quantity'];
        //     $material->save();

        //     $new_material = Material::find($inputs['material_id']);
        //     $new_material->quantity = $new_material->quantity - $inputs['quantity'];
        //     $new_material->save();
        // }
        $userdata = $rent->update($inputs);

        if($userdata){
        return redirect()->route('rent.index')
         ->with('message','Rent updated successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        $material = Material::find($rent->material_id);
        $material->quantity = $material->quantity + $rent->quantity;
        $material->save();
        $rent->delete();
        return redirect()->route('rent.index')
                        ->with('message','Rent deleted successfully')
                        ->with('type', 'success');
    }
}

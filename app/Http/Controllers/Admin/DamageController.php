<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\User;
use App\Models\Damage;
use Carbon\Carbon;

class DamageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "All Damage";
        $listDamages  = Damage::get();
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/damage/index',compact('title','customers'));
    }

    public function allDamages(Request $request){
        $columns = array(
            0 =>'damage_id',
            1 =>'customer_id',
            2 =>'material_id',
            3=> 'price',
            4=> 'quantity'
        );

        $data = array();
        $customer_id = $request->input('filter_option', 0);
        if(!empty($customer_id)){ 
            $totalData = Damage::with('customer', 'material')->where('customer_id', $customer_id )->count();
            $totalFiltered = $totalData; 
        }
        else
        {
            $totalData = Damage::count();
            $totalFiltered = $totalData; 
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value', null); 

        $damages = Damage::whereHas('customer',function ($query) use($customer_id) {
                    $query->where('customer_id', $customer_id );
                })
                ->with(['customer','material' => function($q) use($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    }
                ])
                ->offset($start)
                ->limit($limit)
                //->orderBy('ordered_at')
                ->get();

        if(!empty($damages)){
            $c = 1;
            $total =0 ;
            $status ='';

            foreach ($damages as $key => $damage){
                $calcQty = $damage->quantity;
                $damageTotal = $calcQty * $damage->price;

                $edit =  route('damage.edit',$damage->damage_id);

                $nestedData['id'] = $c;
                $nestedData['customer'] = ($damage->customer) ? $damage->customer->name : '';
                $nestedData['material'] =  ($damage->material) ? $damage->material->name : '';
                $nestedData['price'] = ($damage->price) ? $damage->price : 0;
                $nestedData['quantity'] = $calcQty;
                $nestedData['total'] = round($damageTotal, 2);
                $nestedData['options'] = "<a href='".$edit."' class='btn btn-info btn-sm'>
                    <i class='fas fa-edit'>
                    </i>
                    </a>
                    <a data-id='{$damage->damage_id}' data-name='Received' href='javascript:void(0)' class='btn btn-danger btn-sm'>
                    <i class='fas fa-trash'>
                    </i>
                    </a>";

                $data[] = $nestedData;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Damage";
        //$categories = Category::all()->pluck('name', 'category_id');
        $customers = User::all()->pluck('name', 'user_id');
        $materials = Material::all()->pluck('name', 'material_id');
        return view('admin/damage/create',compact('title', 'customers', 'materials'));
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
        $damage = Damage::create($inputs);
        if($damage){
        return redirect()->route('damage.index')
         ->with('message','Damage added successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Damage $material)
    {
        return view('admin/damage/show',compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Damage $material)
    {
        $title = "Edit Damage";
        //$categories = Category::all()->pluck('name', 'category_id');
        return view('admin/damage/edit', compact('title','material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Damage $material)
    {
        $req = $request->all();
        $req['rentperPrice'] = ($req['rentPrice'])/15;
        $userdata = $material->update($req);

        if($userdata){
        return redirect()->route('damage.index')
         ->with('message','Damage updated successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Damage $material)
    {
        $material->delete();
        return redirect()->route('damage.index')
                        ->with('message','Damage deleted successfully')
                        ->with('type', 'success');
    }

    public function materialdelete(Request $request, Damage $material)
    {
        $id = $request->input('id');
        //$user->delete();
        $item = Damage::find($id);
        $item->delete();
        return redirect()->route('damage.index')
                        ->with('message','Damage deleted successfully')
                        ->with('type', 'success');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Material;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

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
        $listRents  = Rent::get();
        return view('admin/rent/index',compact('title','listRents'));
    }

    public function allRents(Request $request){
        $columns = array( 
            0 =>'rent_id', 
            1 =>'customer_id',
            2 => 'category_id',
            2 => 'material_id',
            3 => 'quantiry',
            4 => 'ordered_at',
        );

        $totalData = Rent::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
        $rents = Rent::with('customer', 'category', 'material')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $rents =  Rent::with('customer', 'category', 'material')
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Rent::with('customer', 'category', 'material')
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($rents))
        {
            $c = 1;
            foreach ($rents as $post){
            //$show =  route('user.show',$post->id);
                $edit =  route('rent.edit',$post->rent_id);
                $view =  route('rent.show',$post->rent_id);
                $nestedData['id'] = $c;
                $nestedData['customer'] = $post->customer->name;
                $nestedData['category'] = $post->category->name;
                $nestedData['material'] = $post->material->name;
                $nestedData['ordered_at'] = date('d-m-Y',strtotime($post->ordered_at));
                $nestedData['quantity'] = $post->quantity;
                $nestedData['options'] = "<a href='{$edit}' class='btn btn-info btn-sm'>
                <i class='fas fa-edit'>
                </i>
                </a>
                <a data-id='{$post->rent_id}' data-name='{$post->category->name}' href='javascript:void(0)' class='btn btn-danger btn-sm'>
                <i class='fas fa-trash'>
                </i>
                </a>
                <button onClick='showAjaxModal(\"$view\", \"$post->rent_id\")' class='btn btn-success btn-sm'>
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
        $materials = Material::all()->pluck('name', 'material_id');
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
        $inputs = $request->input();
        $inputs['ordered_at'] = date("Y-m-d", strtotime($inputs['ordered_at']));
        $customer = Rent::create($inputs);
        $material = Material::find($inputs['material_id']);
        $material->quantity = $material->quantity - $inputs['quantity'];
        $material->save();
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
        $materials = Material::all()->pluck('name', 'material_id');
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
        if($inputs['exist_material_id'] == $inputs['material_id']){
            if($inputs['exist_quantity'] > $inputs['quantity']){
                $material->quantity = $material->quantity + ($inputs['exist_quantity'] - $inputs['quantity']);
                $material->save();
            }
            if($inputs['exist_quantity'] < $inputs['quantity']){
                $material->quantity = $material->quantity - ($inputs['quantity'] - $inputs['exist_quantity']);
                $material->save();
            }
        }else{
            $material->quantity = $material->quantity + $inputs['exist_quantity'];
            $material->save();

            $new_material = Material::find($inputs['material_id']);
            $new_material->quantity = $new_material->quantity - $inputs['quantity'];
            $new_material->save();
        }
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

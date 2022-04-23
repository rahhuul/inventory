<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Category;
use Carbon\Carbon;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "All Material";
        $listMaterials  = Material::get();
        return view('admin/material/index',compact('title','listMaterials'));
    }

    public function allMaterials(Request $request){
        $columns = array( 
            0 =>'material_id', 
            1 =>'name',
            //2=> 'category',
            3=> 'rentprice',
            4=> 'damageprice',
        );

        $totalData = Material::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
        $materials = Material::with('category')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $materials =  Material::orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('damagePrice', 'LIKE',"%{$search}%")
                    ->orWhere('rentPrice', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Material::orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('quantity', 'LIKE',"%{$search}%")
                    ->orWhere('damagePrice', 'LIKE',"%{$search}%")
                    ->orWhere('rentPrice', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();

        if(!empty($materials))
        {
            $c = 1;
            foreach ($materials as $post){
            //$show =  route('user.show',$post->id);
                $edit =  route('material.edit',$post->material_id);
                $view =  route('material.show',$post->material_id);
                $nestedData['id'] = $c;
                $nestedData['name'] = $post->name;
                //$nestedData['category'] = $post->category->name;
                $nestedData['quantity'] = $post->quantity;
                $nestedData['rentprice'] = $post->rentPrice;
                $nestedData['damageprice'] = $post->damagePrice;
                $nestedData['options'] = "<a href='{$edit}' class='btn btn-info btn-sm'>
                <i class='fas fa-edit'>
                </i>
                </a>
                <a data-id='{$post->material_id}' data-name='{$post->name}' href='javascript:void(0)' class='btn btn-danger btn-sm'>
                <i class='fas fa-trash'>
                </i>
                </a>
                <button onClick='showAjaxModal(\"$view\", \"$post->name\")' class='btn btn-success btn-sm'>
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
        $title = "Add Material";
        //$categories = Category::all()->pluck('name', 'category_id');
        return view('admin/material/create',compact('title'));
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
        $inputs['rentperPrice'] = $inputs['rentPrice']/15;
        
        $customer = Material::create($inputs);
        if($customer){
        return redirect()->route('material.index')
         ->with('message','Material added successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return view('admin/material/show',compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $title = "Edit Material";
        //$categories = Category::all()->pluck('name', 'category_id');
        return view('admin/material/edit', compact('title','material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $req = $request->all();
        $req['rentperPrice'] = ($req['rentPrice'])/15;
        $userdata = $material->update($req);

        if($userdata){
        return redirect()->route('material.index')
         ->with('message','Material updated successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('material.index')
                        ->with('message','Material deleted successfully')
                        ->with('type', 'success');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
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

    public function allMaterials(){
        $columns = array( 
            0 =>'user_id', 
            1 =>'name',
            2=> 'mobile',
            3=> 'type'
        );

        $totalData = Material::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
        $materials = Material::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $materials =  Material::where('user_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('mobile', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Material::where('user_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('mobile', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($materials))
        {
            $c = 1;
            foreach ($materials as $post){
            //$show =  route('user.show',$post->id);
                $edit =  route('user.edit',$post->user_id);
                $view =  route('user.show',$post->user_id);
                $nestedData['id'] = $c;
                $nestedData['name'] = $post->name;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['type'] = ($post->type == 0) ? "Rental" : "Provider";
                $nestedData['options'] = "<a href='{$edit}' class='btn btn-info btn-sm'>
                <i class='fas fa-edit'>
                </i>
                </a>
                <a data-id='{$post->user_id}' data-name='{$post->name}' href='javascript:void(0)' class='btn btn-danger btn-sm'>
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
    public function edit(Material $material)
    {
        $title = "Edit Material";
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
        $userdata = $material->update($request->all());

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

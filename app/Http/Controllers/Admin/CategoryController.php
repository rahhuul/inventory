<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Category";
        $listcategorys  = Category::get();
        return view('admin/category/index',compact('title','listcategorys'));
    }

    public function allCategories(Request $request){
        $columns = array( 
            0 =>'category_id', 
            1 =>'name'
        );

        $totalData = Category::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
        $catogories = Category::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $catogories =  Category::where('category_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Category::where('category_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();

        if(!empty($catogories))
        {
            $c = 1;
            foreach ($catogories as $post){
            //$show =  route('user.show',$post->id);
                $edit =  route('category.edit',$post->category_id);
                $view =  route('category.show',$post->category_id);
                $nestedData['id'] = $c;
                $nestedData['name'] = $post->name;
                $nestedData['options'] = "<a href='{$edit}' class='btn btn-info btn-sm'>
                <i class='fas fa-edit'>
                </i>
                </a>
                <a data-id='{$post->category_id}' data-name='{$post->name}' href='javascript:void(0)' class='btn btn-danger btn-sm'>
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

    /*public function getdata(){
        $listusers             = Category::get();
        return $listusers;
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Category";
        return view('admin/category/create',compact('title'));
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
        $customer = Category::create($inputs);
        if($customer){
        return redirect()->route('category.index')
         ->with('message','Category added successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin/category/show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $title = "Edit Category";
        return view('admin/category/edit', compact('title','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $userdata = $category->update($request->all());

        if($userdata){
        return redirect()->route('category.index')
         ->with('message','Category updated successfully')
         ->with('type', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')
                        ->with('message','Category deleted successfully')
                        ->with('type', 'success');
    }
}

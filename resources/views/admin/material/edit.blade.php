@extends('admin.layouts.layout')

<!-- php code section start -->
@section('code_php')
@endsection
<!-- php code section end -->

<!-- title section start -->
@section('title')
    <title>{{$title}}</title>
@endsection
<!-- title section end -->

{{-- css section start --}}
@section('css')
@endsection
{{-- css section end --}}

@section('content')
<div class="content-wrapper">
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark"><small>{{$title}}</small></h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Home</a></li>
               <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
         </div>
      </div>
   </div>
</div>
{{-- {!! Form::open(['url' => '/admin/category/update/'.$category->id,'method'=>'POST', 'id' => 'category_form','enctype' => 'multipart/form-data']) !!} --}}
{!! Form::model($category, ['id' => 'category_form', 'method' => 'PATCH','route' => ['category.update', $category->category_id]]) !!}
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Category</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                     <i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <!-- /.card-header -->
               <!-- form start -->
               <!--  {!! Form::open(['id' => 'category_form']) !!} --> 
               <div class="card-body">
                  <div class="form-group">
                     {!! Form::label('Category Name', 'Category Name') !!}
                     {!! Form::text('name',$category->name, ['id' => "name", 'class' => 'form-control', 'placeholder' => "Enter Name"]) !!}
                  </div>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">
                  {!! Form::submit('save', ["class" => "btn btn-primary"]) !!}
               </div>
            </div>
            <!-- /.card -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </section>
{!! Form::close() !!}
   <!-- </form> -->
</div>

@endsection
<!-- Main Content section end -->


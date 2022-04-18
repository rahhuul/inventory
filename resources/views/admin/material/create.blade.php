@extends('admin.layouts.layout')

<!-- php code section start -->
@section('code_php')
@endsection
<!-- php code section end -->

<!-- title section start -->
@section('title')
    <title>Inventory : {{$title}}</title>
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
{!! Form::open(['route' => 'material.store','method'=>'POST', 'id' => 'material_form']) !!}
@csrf
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Material</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                     <i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <!-- /.card-header -->
               <!-- form start -->
               <div class="card-body">
                  <div class="form-group">
                     {!! Form::label('Material Name', 'Material Name') !!}
                     {!! Form::text('name','', ['id' => "name", 'class' => 'form-control', 'placeholder' => "Enter Name"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Quantity', 'Quantity') !!}
                     {!! Form::text('quantity','', ['id' => "quantity", 'class' => 'form-control', 'placeholder' => "Enter Quantity"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Damage Price', 'Damage Price') !!}
                     {!! Form::text('damagePrice','', ['id' => "damagePrice", 'class' => 'form-control', 'placeholder' => "Enter Damage Price"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Rental Price', 'Rental Price') !!}
                     {!! Form::text('rentPrice','', ['id' => "rentPrice", 'class' => 'form-control', 'placeholder' => "Enter Rental Price"]) !!}
                  </div>
                  {{-- <div class="form-group">
                     {!! Form::label('Category', 'Category') !!}
                     {!! Form::select('category_id', $categories, null, ['id' => 'category_id', 'class' => 'form-control select2', 'style' => 'width:100%']) !!}
                  </div> --}}
               </div>
               <div class="card-footer">
                  {!! Form::submit('save', ["class" => "btn btn-primary"]) !!}
               </div>
               <!-- </form> -->
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
</section>
{!! Form::close() !!}
</div>

@endsection
<!-- Main Content section end -->




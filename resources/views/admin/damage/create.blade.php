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
{!! Form::open(['route' => 'damage.store','method'=>'POST', 'id' => 'damage_form']) !!}
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
                        {!! Form::label('Select Customer', 'Select Customer') !!}
                        {!! Form::select('customer_id', $customers,null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Select Material', 'Select Material') !!}
                        {!! Form::select('material_id', $materials,null, ['id' => 'material_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Material"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Quantity', 'Quantity') !!}
                        {!! Form::text('quantity','', ['id' => "quantity", 'class' => 'form-control', 'placeholder' => "Enter Quantity", "required" => "required"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Price', 'Price') !!}
                        {!! Form::text('price','', ['id' => "price", 'class' => 'form-control', 'placeholder' => "Enter Price", "required" => "required"]) !!}
                    </div>
                  {{-- <div class="form-group">
                     {!! Form::label('Category', 'Category') !!}
                     {!! Form::select('category_id', $categories, null, ['id' => 'category_id', 'class' => 'form-control select2', 'style' => 'width:100%']) !!}
                  </div> --}}
               </div>
               <div class="card-footer">
                  {!! Form::submit('save', ["class" => "btn btn-primary", "id" => "save_damage"]) !!}
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

@section('script')
    <script src="{{URL('/')}}/assets/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{URL('/')}}/assets/admin/plugins/jquery-validation/additional-methods.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#material_form').validate({ // initialize the plugin
                rules: {
                    customer_id: {
                        required: true
                    },
                    material_id: {
                        required: true
                    },
                    quantity: {
                        required: true
                    },
                    price: {
                        required: true
                    }
                },
                messages: {
                    customer_id: {
                        required : "Please select customer name."
                    },
                    material_id: {
                        required : "Please select material name."
                    },
                    quantity: {
                        required: "Please enter a quantity."
                    },
                    rentPrice: {
                        required: "Please enter a rentPrice."
                    },
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    error.insertAfter(element);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".padding-leftright-null").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".padding-leftright-null").addClass("has-success").removeClass("has-error");
                },
                submitHandler: function (form) {
                    form.submit();
                    $("#save_damage").attr("disabled", true);
                }
            })
        })
    </script>
@endsection
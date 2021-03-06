@extends('admin.layouts.layout')

<!-- php code section start -->
@section('code_php')
@endsection
<!-- php code section end -->

<!-- title section start -->
@section('title')
    <title>NFT EVENT : {{$title}}</title>
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
         <div class="col-lg-6 col-6">
            <h1 class="m-0 text-dark"><small>{{$title}}</small></h1>
         </div>
         <div class="col-lg-6 col-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{URL('/admin/dashboard')}}">Home</a></li>
               <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">Go Back</a></li>
            </ol>
         </div>
      </div>
   </div>
</div>
{!! Form::open(['route' => 'user.store','method'=>'POST', 'id' => 'user_form']) !!}
@csrf
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Customer</h3>
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
                     {!! Form::label('Customer Name', 'Customer Name') !!}
                     {!! Form::text('name','', ['id' => "name", 'class' => 'form-control', 'placeholder' => "Enter Name"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Mobile No', 'Mobile No') !!}
                     {!! Form::text('mobile','', ['id' => "mobile", 'class' => 'form-control', 'placeholder' => "Enter mobile"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Address', 'Address') !!}
                     {!! Form::textarea('address','', ['id' => "address", 'class' => 'form-control', 'placeholder' => "Enter address",'rows' => 4, 'cols' => 40]) !!}
                  </div>
                  {{-- <div class="form-group">
                     {!! Form::label('Reference Name', 'Reference Name') !!}
                     {!! Form::text('reference_name','', ['id' => "reference_name", 'class' => 'form-control', 'placeholder' => "Enter Reference Name"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Reference Mobile', 'Reference Mobile') !!}
                     {!! Form::text('reference_mobile','', ['id' => "reference_mobile", 'class' => 'form-control', 'placeholder' => "Enter mobile"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Customer Type', 'Customer Type') !!}
                     <select name="type" class="form-control select2" style="width: 100%;">
                        <option value="">Select Customer Type</option>
                        <option value="0">Rental</option>
                        <option value="1">Provider</option>
                     </select>
                  </div> --}}
                  
               </div>
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <div class="card-footer">
         {!! Form::submit('save', ["class" => "btn btn-primary", "id" => "save_user"]) !!}
      </div>
      <!-- </form> -->
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
            $('#user_form').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true
                    },
                    mobile: {
                        required: true
                    },
                    address: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required : "Please enter your name."
                    },
                    mobile: {
                        required: "Please enter a mobile number."
                    },
                    address: {
                        required: "Please enter a address."
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
                    $("#save_user").attr("disabled", true);
                }
            })
        })
    </script>
@endsection
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
{!! Form::open(['route' => 'rent.store','method'=>'POST', 'id' => 'rent_form']) !!}
@csrf
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Rent</h3>
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
                     {!! Form::select('customer_id', $customers, null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Select Category', 'Select Category') !!}
                     {!! Form::select('category_id', $categories, null, ['id' => 'category_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Category"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Select Material', 'Select Material') !!}
                     {!! Form::select('material_id', [], null, ['id' => 'material_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Material"]) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Quantity', 'Quantity') !!}
                     {!! Form::text('quantity','', ['id' => "quantity", 'class' => 'form-control', 'placeholder' => "Enter Quantity"]) !!}
                  </div>

                  <div class="form-group">
                     {!! Form::label('Total Quantity', 'Total Quantity') !!}: 
                     {!! Form::label('0', '0', ['id' => 'totalQuantity']) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('Remain Quantity', 'Remain Quantity') !!}: 
                     {!! Form::label('0', '0', ['id' => 'remainQuantity']) !!}
                  </div>
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

@section('script')
<script>
   $('#category_id').on('select2:select', function (e) {
      var data = e.params.data;
      let category_id = data.id;
      $("#totalQuantity").html('0')
      $("#remainQuantity").html('0')
      $.ajax({
            headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "rent-materials",
            type: 'POST',
            data: {
               "category_id": category_id,
            },
            complete: function (response) {
               let newRes = JSON.parse(response.responseText);
               let data = newRes.data;
               $("#material_id").empty();
               $("#material_id").select2({data: data});
            },
            error: function(xhr) {

            }
      });
   });

   $('#material_id').on('select2:select', function (e) {
      var data = e.params.data;
      $("#totalQuantity").html(data.quantity)
   });

   $("#quantity").on('change', function(e){
      let total = parseInt($("#totalQuantity").html());
      let current = parseInt($(this).val());
      if(current > total){
         toastr.error("Order value is not more then Total");
         return false;
      }

      let remain = total - current;
      $("#remainQuantity").html(remain)
   });
</script>
@endsection
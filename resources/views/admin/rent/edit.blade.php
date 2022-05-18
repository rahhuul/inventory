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
{{-- {!! Form::open(['url' => '/admin/rent/update/'.$rent->id,'method'=>'POST', 'id' => 'rent_form','enctype' => 'multipart/form-data']) !!} --}}
{!! Form::model($rent, ['id' => 'rent_form', 'method' => 'PATCH','route' => ['rent.update', $rent->rent_id]]) !!}
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
               <!--  {!! Form::open(['id' => 'rent_form']) !!} --> 
                  <div class="card-body">
                   <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                     {!! Form::label('Select Customer', 'Select Customer') !!}
                     {!! Form::select('customer_id', $customers, $rent->customer_id, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                  </div>
               </div>
            
<div class="col-md-6">
            <div class="form-group">
                  {!! Form::label('Order Date', 'Order Date') !!}
                  <div class="input-group">
                     <div class="input-group-prepend">
                       <span class="input-group-text">
                         <i class="far fa-calendar-alt"></i>
                       </span>
                     </div> 
                     <input type="text" name="ordered_at" class="form-control float-right" id="reservation" value={{Carbon\Carbon::parse($rent->ordered_at)->format("d-m-Y")}}>
                   </div>
                  </div>
               </div>
                  </div>
        
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label>Select Material</label>

                   <select name="material_id" id="material_id" class="duallistbox" multiple="true">
                    @foreach ($materials as $mat)

                      <option value="{{$mat['material_id']}}" {{ ($rent->material_id) == $mat['material_id'] ? 'selected' : '' }}>{{$mat['name']}} &nbsp &nbsp &nbsp [{{$mat['quantity']}}]</option>
                    @endforeach
                  </select>

                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
               <div class="col-md-4" id="quantitybox">
              <div class="box" id="{{$rent->material_id}}"><label for="{{$rent->material->name}}">{{$rent->material->name}} &nbsp [{{$rent->material->quantity}}]</label>: <input type="text" name="quantity" class="form-control" id="quantity" placeholder = "Enter Quantity" value="{{$rent->quantity}}"></div>
             </div>

            </div>
            <!-- /.row -->
         
                  
               </div>
               <!-- /.card-body -->
               {!!Form::hidden('exist_material_id',$rent->material_id)!!}
               {!!Form::hidden('exist_quantity',$rent->quantity)!!}
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
@section('script')
<script>
   var demo2 = $('.duallistbox').bootstrapDualListbox({
   selectedlistlabel: 'Selected',
   infoText:false,
  });

   //let mindate = '{{Carbon\Carbon::parse($rent->ordered_at)->format("d-m-Y")}}';
   $('#reservation').daterangepicker({
      singleDatePicker: true,
      "locale": {
         "format": "DD-MM-YYYY",
         "separator": " - ",
      },
      // minDate: mindate,
       //startDate:mindate,
      showDropdowns: true,
      autoApply: true
   });

   $('#reservation').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('DD-MM-YYYY'));
   });

   /******************************* Get selected with inputs starts here *******************************/
   // let quantity = '{{$rent->quantity}}';
   //  $("#quantitybox").append('<div class="box" id="'+selected.value+'"><label for="'+selected.name+'">'+selected.name+'</label>: <input type="text" name="quantity['+quantity+']" class="form-control" id="quantity" placeholder = "Enter Quantity" ></div>');
   //          inputCreated.push(selected.value)
            

  
   $('select[name="material_id_helper1"]').prop('disabled', true);
   $('select[name="material_id_helper2"]').prop('disabled', true);

   /******************************* Get selected with inputs ends here *******************************/


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

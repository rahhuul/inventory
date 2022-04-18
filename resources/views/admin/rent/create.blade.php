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
                   <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                     {!! Form::label('Select Customer', 'Select Customer') !!}
                     {!! Form::select('customer_id', $customers, null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
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
                     <input type="text" name="ordered_at" class="form-control float-right" id="reservation">
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

    <option value="{{$mat['material_id']}}">{{$mat['name']}}  &nbsp &nbsp &nbsp [{{$mat['quantity']}}]</option>
   

@endforeach
 
</select>

                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
               <div class="col-md-4" id="quantitybox">
              
             </div>

            </div>
            <!-- /.row -->
         
                  
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
  var demo2 = $('.duallistbox').bootstrapDualListbox({
   selectedlistlabel: 'Selected',
   infoText:false,
  });

   let mindate = moment().format("DD-MM-YYYY");
   $('#reservation').daterangepicker({
      singleDatePicker: true,
      "locale": {
         "format": "DD-MM-YYYY",
         "separator": " - ",
      },
      // minDate: mindate,
      // startDate:mindate,
      showDropdowns: true,
      autoApply: true
   });

   $('#reservation').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('DD-MM-YYYY'));
   });
   $('#category_id').on('select2:select', function (e) {
      var data = e.params.data;
      let category_id = data.id;
      $("#totalQuantity").html('0')
      $("#remainQuantity").html('0')
      $.ajax({
            headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: baseUrl+"/rent-materials",
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

   /******************************* Get selected with inputs starts here *******************************/

   let selected_array = [];
   let inputCreated = [];

   $("select[name ='material_id_helper1']").on('change', function(e) {
   		updateSelected();
   		createQuantitybox();
   })

   $("select[name ='material_id_helper2']").on('change', function(e) {
   		updateUnSelected();
   		removeQuantitybox();
   })

   const createQuantitybox = () => {   	
   		selected_array.forEach((selected) => {
   			if(inputCreated.findIndex(el => el == selected.value) > -1){

   			}else{
				$("#quantitybox").append('<div class="box" id="'+selected.value+'"><label for="'+selected.name+'">'+selected.name+'</label>: <input type="text" name="quantity['+selected.value+']" class="form-control" id="quantity" placeholder = "Enter Quantity" ></div>');
				inputCreated.push(selected.value)
   			}
   		})
   }

   const removeQuantitybox = () => {
   		inputCreated.forEach((created) => {
   			if(selected_array.findIndex(el => el.value == created) > -1){
   			}else{
				$("#quantitybox").find('div#'+created).remove();
				var index = inputCreated.indexOf(created);
				if (index !== -1) {
				  	inputCreated.splice(index, 1);
				}
   			}
   		})
   }

   const updateUnSelected = () => {
   		let helper2 = $("select[name='material_id_helper2']");
   		let options = helper2[0].options;
   		selected_array=[];
		$(options).each(function(e) {
			sel_exist = selected_array.findIndex(el => el.value == $(this).val());
			if(sel_exist >= 0){
			}else{
	   			selected_array.push({
	   				name : $(this).text(),
	   				value: $(this).val()
	   			})
			}
   		});
   }

   const updateSelected = () => {
   		let helper2 = $("select[name='material_id_helper2']");
   		let options = helper2[0].options;
   		let sel_exist;
   		
		$(options).each(function(e) {
			sel_exist = selected_array.findIndex(el => el.value == $(this).val());
			
			if(sel_exist >= 0){
			}else{
	   			selected_array.push({
	   				name : $(this).text(),
	   				value: $(this).val()
	   			})
			}
   		});
	}


	/******************************* Get selected with inputs ends here *******************************/


   $('#material_id').on('select2:select', function (e) {
      var data = e.params.data;
      $("#totalQuantity").html(data.quantity)
   });

   $("#quantity").on('change', function(e){
      let total = parseInt($("#totalQuantity").html());
      let current = parseInt($(this).val());
      if(current > total){
         toastr.error("Order value is not more then Total");
         $(':input[type="submit"]').prop('disabled', true);
         return false;
      }
      else
      {
         $(':input[type="submit"]').prop('disabled', false);
      }

      let remain = total - current;
      $("#remainQuantity").html(remain)
   });
</script>
@endsection
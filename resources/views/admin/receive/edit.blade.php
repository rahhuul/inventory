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
{!! Form::model($received, ['id' => 'receive_form', 'method' => 'PATCH','route' => ['received.update', $received->received_id]]) !!}
@csrf
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Received</h3>
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
                     {!! Form::select('customer_id',$customers, $received->rent->customer->user_id, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                  </div>
               </div>
            
                <div class="col-md-6">
                   <div class="form-group">
                  {!! Form::label('Receive Date', 'Receive Date') !!}
                  <div class="input-group">
                     <div class="input-group-prepend">
                       <span class="input-group-text">
                         <i class="far fa-calendar-alt"></i>
                       </span>
                     </div>
                     <input type="text" name="receive_date" class="form-control float-right" id="receive_date">
                   </div>
                  </div>
               </div>
                  </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Select Material</label>
                   <select name="material_id" id="material_id" class="duallistbox" multiple="true">
 <option value="{{($rev->rent->material->material_id)}}" disabled="true">{{$rev->rent->material->name}} &nbsp [{{$rev->rent->remain_quantity}}] &nbsp &nbsp</option>
                  </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
             <div class="row">
             
                <div class="col-md-12" id="quantitybox">

@if($rev->rent->remain_quantity == 0)
 <div class="row"><div class="col-md-3 box" id="{{$rev->rent->material->material_id}}"><label for="{{$rev->rent->material->name}}">{{$rev->rent->material->name}} &nbsp [{{$rev->rent->remain_quantity}}] &nbsp &nbsp</label></div>:

      <div class="col-md-4">
         <label for="{{$rev->rent->material->name}}">Received Quantity</label>
      <input type="text" name="received_quantity" class="form-control" id="received_quantity" placeholder = "Enter Quantity" value="{{$received->received_quantity}}" >
      </div>
      <div class="col-md-4">
         <label for="{{$rev->rent->material->name}}">Pending Quantity</label>
         <input type="text" name="pending_material" class="form-control" id="pending_material" placeholder = "Pending material" value="{{$received->pending_material}}" ></div></div>

@else
 <div class="row"><div class="col-md-3 box" id="{{$rev->rent->material->material_id}}"><label for="{{$rev->rent->material->name}}">{{$rev->rent->material->name}} &nbsp [{{$rev->rent->remain_quantity}}] &nbsp &nbsp</label></div>:
                  <div class="col-md-4">
                     <label for="{{$rev->rent->material->name}}">Received Quantity</label>
                    <input type="text" name="received_quantity" class="form-control" id="received_quantity" placeholder = "Enter Quantity" value="{{$received->received_quantity}}" >
                  </div>
                  <div class="col-md-4">
                     <label for="{{$rev->rent->material->name}}">Pending Quantity</label>
                     <input type="text" name="pending_material" class="form-control" id="pending_material" placeholder = "Pending material" value="{{$received->pending_material}}" ></div></div>
@endif
                 
                </div>
            </div>
                    {!!Form::hidden('exist_received_id',$rev->received_id)!!}
                    {!!Form::hidden('exist_rent_id',$rev->rent_id)!!}
                    {!!Form::hidden('exist_rent_quantity',$rev->rent->quantity)!!}
                    {!!Form::hidden('exist_received_quantity',$rev->received_quantity)!!}
                    {!!Form::hidden('exist_material_id',$rev->material_id)!!}
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
 //  selectedlistlabel: 'Selected',
   infoText:false,
   moveOnSelect: true, 
  });

    let mindate = '{{Carbon\Carbon::parse($received->receive_date)->format("d-m-Y")}}';
   $('#receive_date').daterangepicker({
      singleDatePicker: true,
      "locale": {
         "format": "DD-MM-YYYY",
         "separator": " - ",
      },
       //minDate: mindate,
      startDate:mindate,
      showDropdowns: true,
      autoApply: true
   });



   $('#receive_date').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('DD-MM-YYYY'));
   });
   

   /******************************* Get selected with inputs starts here *******************************/

   let selected_array = [];
   let inputCreated = [];
   

   $('#customer_id').on('change', function(e) {
    var custval = $(this).val();
         $.ajax({
            headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: baseUrl+"/receive-materials",
            type: 'POST',
            data: {
               "customer_id": custval,
            },
            complete: function (response) {
               let newRes = JSON.parse(response.responseText);
           
               $.each(newRes.data, function(key, value) {
                demo2.append($('<option>', {
                  value: value.id,
                  text: value.name +" "+"["+value.rentquantity+"]rq"+" "+"["+value.materialquantity+"]mq"
                }));
               demo2.bootstrapDualListbox('refresh', true);
              });
            },
      }); 
   })


   $("select[name ='material_id_helper1']").on('change', function(e) {
      updateSelected();
      createQuantitybox();
   })

   $("select[name ='material_id_helper2']").on('change', function(e) {
      updateUnSelected();
      removeQuantitybox();
   })

   // function getdata(){
   //  //onchange="getdata()"
   //  alert("hello");
   //  console.log($(this));
   // }

   const createQuantitybox = () => {    
      selected_array.forEach((selected) => {
        if(inputCreated.findIndex(el => el == selected.value) > -1){

        }else{
        /* $("#quantitybox").append('<div class="row"><div class="col-md-2 box" id="'+selected.value+'"><label for="'+selected.name+'">'+selected.name+'</label></div>:<div class="col-md-2"><input type="text" name="material['+selected.value+'][received_quantity]" class="form-control" id="received_quantity" placeholder = "Enter Quantity"></div><div class="col-md-2"><input type="text" name="material['+selected.value+'][damaged_quantity]" class="form-control" id="damaged_quantity" placeholder = "Damaged Quantity" ></div><div class="col-md-2"><input type="text" name="material['+selected.value+'][losed_quantity]" class="form-control" id="losed_quantity" placeholder = "Losed Quantity" ></div><div class="col-md-2"><input type="text" name="material['+selected.value+'][pending_material]" class="form-control" id="pending_material" placeholder = "Pending material" ></div></div>');
        inputCreated.push(selected.value) */
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
      console.log("options",options);
      let sel_exist;
      
    $(options).each(function(e) {
      sel_exist = selected_array.findIndex(el => el.value == $(this).val());
      
      if(sel_exist >= 0){
      }else{
          selected_array.push({
            name : $(this).text(),
            value: $(this).val()
          })
          console.log("selected_array",selected_array);
      }
      });
  }


  /******************************* Get selected with inputs ends here *******************************/


   // $('#material_id').on('select2:select', function (e) {
   //    var data = e.params.data;
   //    $("#totalQuantity").html(data.quantity)
   // });

   // $("#quantity").on('change', function(e){
   //    let total = parseInt($("#totalQuantity").html());
   //    let current = parseInt($(this).val());
   //    if(current > total){
   //       toastr.error("Order value is not more then Total");
   //       $(':input[type="submit"]').prop('disabled', true);
   //       return false;
   //    }
   //    else
   //    {
   //       $(':input[type="submit"]').prop('disabled', false);
   //    }

   //    let remain = total - current;
   //    $("#remainQuantity").html(remain)
   // });
</script>
@endsection
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
{!! Form::open(['route' => 'received.store','method'=>'POST', 'id' => 'receive_form']) !!}
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
                     {!! Form::select('customer_id',$customers, null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
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
                  </select>

                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
             <div class="row">
             
                <div class="col-md-12" id="quantitybox"></div>
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
 //  selectedlistlabel: 'Selected',
   infoText:false,
   moveOnSelect: true, 
  });

   let mindate = moment().format("DD-MM-YYYY");
   $('#receive_date').daterangepicker({
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
               let u_exist;
               $.each(newRes.data, function(key, value) {

                  //$('<input>').attr({type: 'hidden',id: 'orderdate['+value.id+']',name:'orderdate',value:value.orderdate}).appendTo("#quantitybox");
                demo2.append($('<option>', {
      				    value: value.id,
      				    text: value.name +" "+'[Date-'+value.orderdate+"] "+' [ReceivedQuantity-'+value.status+"] "
                  +''+'[Rentquantity-'+''+value.rentquantity+']',
                  data_rentid:value.rentid,
                  orderdate:value.orderdate
				        }
                ));
              
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

   function getquantity(data){
    
  console.log("data",data);

   }

   const createQuantitybox = () => {    
      selected_array.forEach((selected) => {
        if(inputCreated.findIndex(el => el.value == selected.value && el.name == selected.name ) > -1){

        }else{
        $("#quantitybox").append('<div class="row"><div class="col-md-2"></div><div class="col-md-2"><label for="Received Quantity">Received Quantity</label></div><div class="col-md-2"><label for="Damaged Quantity">Damaged Quantity</label></div><div class="col-md-2"><label for="Losed Quantity">Losed Quantity</label></div><div class="col-md-2"><label for="Pending Quantity">Pending Quantity</label></div></div><div class="row"><div class="col-md-2 box" id="'+selected.value+'"><label for="'+selected.name+'">'+selected.name+'</label></div>:<div class="col-md-2"><input type="text" name="rent['+selected.data_rentid+'][received_quantity]" class="form-control" id="received_quantity['+selected.data_rentid+']" placeholder = "Enter Quantity" onchange="getquantity(this)" ></div><div class="col-md-2"><input type="text" name="rent['+selected.data_rentid+'][damaged_quantity]" class="form-control" id="damaged_quantity" placeholder = "Damaged Quantity" ></div><div class="col-md-2"><input type="text" name="rent['+selected.data_rentid+'][losed_quantity]" class="form-control" id="losed_quantity" placeholder = "Losed Quantity" ></div><div class="col-md-2"><input type="text" name="rent['+selected.data_rentid+'][pending_material]" class="form-control" id="pending_material" placeholder = "Pending material" ></div><div class="col-md-2"><input type="hidden" name="rent['+selected.data_rentid+'][orderdate]" value="'+selected.orderdate+'"class="form-control" id="rentid" ></div><div class="col-md-2"><input type="hidden" name="rent['+selected.data_rentid+'][material]" value="'+selected.value+'" class="form-control" id="rentid" ></div></div>');
        //inputCreated.push(selected.value)
        inputCreated.push({
            name : selected.name,
            value: selected.value
          })
        }
      })
   }

   const removeQuantitybox = () => {
      inputCreated.forEach((created) => {
        if(selected_array.findIndex(el => el.value == created && el.name == created  ) > -1){
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
      sel_exist = selected_array.findIndex(el => el.value == $(this).val() && el.name == $(this).text());
      if(sel_exist >= 0){
      }else{
          selected_array.push({
            name : $(this).text(),
            value: $(this).val(),
            data_rentid:$(this).attr("data_rentid"),
            orderdate:$(this).orderdate
          })
      }
      });
   }

   const updateSelected = () => {
      let helper2 = $("select[name='material_id_helper2']");
      console.log("helper2",helper2);
      let options = helper2[0].options;
      let sel_exist;
      
    $(options).each(function(e) {
      sel_exist = selected_array.findIndex(el => el.value == $(this).val() && el.name == $(this).text());
      
      if(sel_exist >= 0){
      }else{
          selected_array.push({
            name : $(this).text(),
            value: $(this).val(),
            data_rentid:$(this).attr("data_rentid"),
            orderdate:$(this).attr("orderdate")
          })
      }
      });
  }


  /******************************* Get selected with inputs ends here *******************************/
</script>
@endsection
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
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     <div>
                       {!! Form::label('Select Customer', 'Select Customer') !!}
                     {!! Form::select('customer_id', $customers,null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                     </div>
                     <br> 
                     <div class="card">
                        <div class="card-header">
                           <h3 class="card-title">Rent</h3>
                        </div>
                        <div class="card-body table-responsive col-sm-12">
                        	<div class="card">
                                <div class="card-header">Pending Materials</div>
                                <div class="card-body col-sm-12">
                                    <div class="row" id="groupingRow">
                                    </div>
                                </div>
                            </div>
                           <table id="ex1" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Material</th>
                                    <th>Date</th>
                                    <th>Days</th>
                                    <th>Quantity</th>
                                    <th>Price / Day</th>
                                    <th>QuantityPrice / Day</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th colspan="6" style="text-align:right"></th>
                                    <th style="text-align:right"></th>
                                    <th style="text-align:right"></th>
                                    <th></th>
                                 </tr>
                           </tfoot>
                           </table>
                        </div>
                     </div>
                  </div> 
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

@endsection
<!-- Main Content section end -->

@section('script')
<script type="text/javascript">
   var table = $('#ex1').DataTable({
         processing: true,
         serverSide: true,
         ajax: function (data, callback, settings){
            function a( data ){
                return $.extend( {}, data, {
                    "filter_option": $("#customer_id").val().toLowerCase(),
                    _token: "{{csrf_token()}}"
                })
            };
            let abc = a(data);
             $.ajax({
                 "url": "{{ url('pendingmaterial') }}",
                 "dataType": "json",
                "type": "POST",
                "data": abc,
                success: function(data) {
                    //groupingRow
                    let groupHtml = '';
                    for( let pending in data.groupPending ){
                        groupHtml += '<div class="col-md-2"><b>'+data.groupPending[pending].material+'[<span style="color:green">'+data.groupPending[pending].received+'</span>/'+data.groupPending[pending].quantity+'] :</b> </div><div class="col-md-2"><span style="color:red">'+data.groupPending[pending].pending+'</span></div>'
                    }

                    $("#groupingRow").html(groupHtml);
                    callback(data);
                }
            });
         },
         "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]],
         "order": [[2, "asc" ]],
         "columns": [
                { "data": "id",orderable: false },
                { "data": "customer" },
                { "data": "material" },
                { "data": "ordered_at" },
                { "data": "days" },
                { "data": "quantity",orderable: false },
                { "data": "perdayprice",orderable: false },
                { "data": "quantityprice",orderable: false },
                { "data": "price",orderable: false }, 
                { "data": "options",orderable: false }
         ],
         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
  
            // Total over this page
            pageTotal = api
                .column(8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(8).footer() ).html(
                '???'+pageTotal.toFixed(3)
            );

 
            // Total over this page
            pagequantity = api
                .column(7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(7).footer() ).html(
                'Per day Quantity:  ???'+pagequantity.toFixed(3)
            );


            // Total over this page
            pageper = api
                .column(6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(6).footer() ).html(
                'Per day:  ???'+pageper.toFixed(3)
            );


        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
               //$('td',nRow).css('color', 'white');
               if (aData['ordered_date'] != "") {
                  $('td', nRow).eq(5).css('background-color', 'Red');
                  $('td', nRow).eq(5).css('color', 'white');
               }
         },
      });

    $(document).ready(function () {

        $('#customer_id').bind("keyup change", function(){
        table.draw();
    });
      

      $(document).on('click', ".btn-danger", function() {
         var id   = $(this).data('id');
         var name   = $(this).data('name');
         console.log("id >>> ", id);

         Swal.fire({
            title: "Delete Rent",
            html: "Want to delete, <b>"+name+"</b> ?",
            buttonsStyling: false,
            confirmButtonText: "<i class='la la-times'></i> Yes",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            customClass: {
               confirmButton: "btn btn-danger",
               cancelButton: "btn btn-default"
            }
         }).then(function(result) {
            if (result.value) {
               $.ajax({
                     headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     url: "/admin/rent/" + id,
                     type: 'delete',
                     dataType: "JSON",
                     data: {
                        "id": id
                     },
                     complete: function (response) {
                        toastr.error(name+" removed");
                        //t.row("#"+id).remove().draw();
                        //table.draw()
                     },
                     error: function(xhr) {

                     }
               });
            }
         });
         });



   });


   $('#modal_ajax').on('shown.bs.modal', function(event) {
  let mindate = moment().format("DD-MM-YYYY");
   $('#receive_date').daterangepicker({
      singleDatePicker: true,
      "locale": {
         "format": "DD-MM-YYYY",
         "separator": " - ",
      },
      minDate: mindate,
      startDate:mindate,
      showDropdowns: true,
      autoApply: true,
      parentEl: '#modal_ajax .modal-content .modal-body'   
   });
    var material_quantity = $("#material_quantity").val();
      $("#totalMaterial").html(material_quantity);

      $("#received_quantity").on('change', function(e){

         let total = parseInt($("#totalMaterial").html());
      let current = parseInt($(this).val());
      if(current > total){
         toastr.error("Order value is not more then Total");
         return false;
      }

      let remain = total - current;
      $("#pending_material").val(remain);
      });


   $('#receive_date').on('show.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('DD-MM-YYYY'));
   });    
}); 


    function myFunction(){
      var checkBox = document.getElementById("is_damage");
      if (checkBox.checked == true){
            $("#damaged_quantity").show();
      } else {
          $("#damaged_quantity").hide();
        }

   };

   

    


     // $("#totalMaterial").html()
   

   /*$("#quantity").on('change', function(e){
      let total = parseInt($("#totalQuantity").html());
      let current = parseInt($(this).val());
      if(current > total){
         toastr.error("Order value is not more then Total");
         return false;
      }

      let remain = total - current;
      $("#remainQuantity").html(remain)
   });*/

   // transction_deposit._fetch_data_dep();
</script>
@endsection
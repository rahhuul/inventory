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
             <div class="col-sm-6" style="text-align: right;">
               <a href="{{URL('/admin/received/create')}}" class="btn btn-primary addcat">Add Receive</a>
            </div>
           {{--  <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">{{$title}}</li>
               </ol>
            </div> --}}
         </div>
      </div>
   </div>
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body" style="padding: 0px !important;">
                     <div class="col-md-12">
                        <br>
                        <div class="col-md-3">
                         {!! Form::label('Select Customer', 'Select Customer') !!}
                         {!! Form::select('customer_id', $customers,null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                        </div>
                     </div>
                     
                     <div class="card">
                        <!-- <div class="card-header">
                           <h3 class="card-title">Received Material</h3>
                        </div> -->
                        {{ Form::hidden('custid', '',array('id' => 'custid')) }}
                        <div class="card-body table-responsive col-sm-12">
                           <table id="ex2" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Material</th>
                                    <th>Price</th>
                                    <th>From Date</th>
                                    <th>Receive Date</th>
                                    <th>Days</th>
                                    <th>Received Quantity</th>
                                    <th>Received Price</th>
                                    <th>Action</th>
                                    
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <tr>
                                     <th colspan="8" style="text-align:right">Received Total:</th>
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
    var table = $('#ex2').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            "url": "{{ url('receivs') }}",
            "dataType": "json",
            "type": "POST",
            "data":function( d ){
                return $.extend( {}, d, {
           "filter_option": $("#customer_id").val().toLowerCase(),
            _token: "{{csrf_token()}}"
         } )
            }
           
         },
         "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
         "columns": [
                { "data": "id",orderable: false },
                { "data": "customer" },
                { "data": "material" },
                { "data": "price" },
                { "data": "from_date" },
                { "data": "receive_date" },
                { "data": "days" },
                { "data": "received_quantity" }, 
                { "data": "received_price" }, 
                { "data": "options",orderable: false },  
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
 
            // Total over all pages
            total = api
                .column(8)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column(8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(8).footer() ).html('₹'+pageTotal);
        }
      });





    $(document).ready(function () {
      //table.draw();

      $('#customer_id').bind("keyup change", function(){
        table.draw();
    });

      $(document).on('click', ".btn-danger", function() {
         var id   = $(this).data('id');
         var name   = $(this).data('name');
         console.log("id >>> ", id);

         Swal.fire({
            title: "Delete Received",
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
                     url: baseUrl + "/admin/received/" + id,
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

</script>
@endsection
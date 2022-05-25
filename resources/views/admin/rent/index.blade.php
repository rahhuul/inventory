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
               <a href="{{URL('/admin/rent/create')}}" class="btn btn-primary addcat">Add Rent</a>
            </div>
            <!-- <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">{{$title}}</li>
               </ol>
            </div> -->
         </div>
      </div>
   </div>
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body" style="padding: 0px !important;">
                     <!-- <div>
                        <a href="{{URL('/admin/rent/create')}}" class="btn btn-primary addcat">Add Rent</a>
                     </div>
                     <br>  -->
                     <div class="col-md-12">
                        <br>
                        <div class="col-md-3">
                        {!! Form::label('Select Customer', 'Select Customer') !!}
                        {!! Form::select('customer_id', $customers,null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                        </div>
                     </div>
                     
                     <div class="card">
                        <!-- <div class="card-header">
                           <h3 class="card-title">Rent</h3>
                        </div> -->
                        <div class="card-body table-responsive col-sm-12">
                           <table id="ex1" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Material</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Days</th>
                                    <th>Rent Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                    <tr>
                                       <th colspan="7" style="text-align:right">Rent Total:</th>
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
         ajax: {
            "url": "{{ url('rents') }}",
            "dataType": "json",
            "type": "POST",

            "data":function( d ){
                return $.extend( {}, d, {
           "filter_option": $("#customer_id").val().toLowerCase(),
            _token: "{{csrf_token()}}"
         } )
            }
         },
         "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]],
         "order": [[3, "asc" ]],
         "columns": [
                { "data": "id", orderable: false },
                { "data": "customer" },
                { "data": "material" },
                { "data": "ordered_at" },
                { "data": "price", orderable: false },
                { "data": "quantity", orderable: false }, 
                { "data": "days", orderable: false }, 
                { "data":"renttotal", orderable: false},
                { "data":"status", orderable: false},
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
 
            // Total over all pages
            total = api
                .column(7)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column(7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(7).footer() ).html(
                '₹'+pageTotal
            );
        }
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
                     url: baseUrl+"/admin/rent/" + id,
                     type: 'delete',
                     complete: function (response) {
                        toastr.error(name+" removed");
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
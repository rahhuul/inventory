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
   {!! Form::open(['route' => 'bill.store','method'=>'POST', 'id' => 'bill_form']) !!}
@csrf
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

                     <div class="card-body table-responsive col-sm-12">
                           <table id="ex1" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>Order Date</th>
                                    <th>Received Date</th>
                                    <th>Days</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                               <tfoot>
                                    <tr>
                                      <th colspan="6"></th>
                                        <th style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr>
                              </tfoot>
                           </table>
                        </div>
                           <div class="card-footer">
                      <!--  <input class="btn btn-primary" type="submit" value="save"> -->
                         <div class="col-12">
                          <a id="pdf" class="btn btn-primary float-right" style="margin-right: 5px;">Generate PDF </a>
                         </div>
                    </div>
                  </div> 
               </div>
            </div>
         </div>
      </div>
   </section>
   {!! Form::close() !!}
</div>

@endsection
<!-- Main Content section end -->

@section('script')
<script type="text/javascript">
   // $("#bill_form").validate({ 
   //              rules : {
   //                  customer_id : {
   //                      required : true
   //                  },
   //              },
   //              messages : {
   //                  customer_id : {
   //                      required : "Please Select anyone customer "
   //                  },
   //              },
   //              errorElement: "em",
   //              errorPlacement: function(error, element) {
   //                error.addClass( "help-block" );
   //                error.insertAfter( element );
                                
   //              },
   //          });
     var table = $('#ex1').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            "url": "{{ url('billcustomermaterial') }}",
            "dataType": "json",
            "type": "POST",
            "data":function( d ){
                return $.extend( {}, d, {
           "filter_option": $("#customer_id").val().toLowerCase(),
            _token: "{{csrf_token()}}"
         } )
            },
            "drawCallback": function (settings) { 
                // Here the response
                console.log("res",settings);
                var response = settings; 
                $("a").attr("href", response)
                //console.log(response);
            },
            // response:function(res){
            
            // }
         },
         "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]],
         "order": [[1, "asc" ]],
         "columns": [
                { "data": "id",orderable: false },
                { "data": "material"},
                { "data": "quantity",orderable: false},
                { "data": "ordered_date",orderable: false},
                { "data": "received_date",orderable: false},
                { "data": "days",orderable: false},
                { "data": "price",orderable: false }, 
                { "data": "total" ,orderable: false},
         ],
          "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
             var response = this.api().ajax.json();
           if(response){
             $( this.api().column( 4 ).footer() ).html('(Renttotal['+response.renttotal+'] - Receivedtotal['+response.receivedtotal+'])');
           }
 
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
            $( api.column(7).footer() ).html('₹'+pageTotal
            );
        },
      

      });

    $(document).ready(function () {

        $('#customer_id').bind("keyup change", function(){
          var  customer_id = $("#customer_id").val();
           var edit = "{{ url('admin/bill')}}"+'/'+customer_id;
           $("#pdf").attr("href", edit);
         
        table.draw();
        });
    });
</script>
@endsection
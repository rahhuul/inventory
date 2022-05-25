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
                         <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Form::label('Select Customer', 'Select Customer') !!}
                                {!! Form::select('customer_id', $customers,null, ['id' => 'customer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer"]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('Order Date', 'Order Date') !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input required='required' type="text" name="filter_date" class="form-control float-right" id="filter_date">
                                </div>
                            </div>
                        </div>
                        
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
                                    <th>Days</th>
                                    <th>Per Day Price</th>
                                    <th>Price</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                               <tfoot>
                                    <tr>
                                      <th colspan="5"></th>
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
    
    let mindate = moment().format("DD-MM-YYYY");
    $('#filter_date').daterangepicker({
        singleDatePicker: true,
        "locale": {
            "format": "DD-MM-YYYY",
            "separator": " - ",
        },
        showDropdowns: true,
        autoApply: true
    });
    
    $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
        console.log(picker.startDate.format('DD-MM-YYYY'));
    });
    
    function toTimestamp(strDate){
        myDate = strDate.split("-");
        var newDate = new Date( myDate[2], myDate[1] - 1, myDate[0]);
        var datum = new Date(newDate).getTime();
        console.log("datum >>>>>>>>>>> ", datum)
        return datum/1000;
    }

    let filterDate = $("#filter_date").val();
    let filterTmestamp = toTimestamp(filterDate)

     var table = $('#ex1').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            "url": "{{ url('rentchallan') }}",
            "dataType": "json",
            "type": "POST",
            "data":function( d ){
                return $.extend( {}, d, {
                    "filter_option": $("#customer_id").val().toLowerCase(),
                    "filter_date": $("#filter_date").val(),
                    _token: "{{csrf_token()}}"
                })
            },
            "drawCallback": function (settings) { 
                var response = settings; 
                $("a").attr("href", response)
            },
         },
         "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]],
         "order": [[3, "asc" ]],
         "columns": [
                { "data": "id",orderable: false },
                { "data": "material"},
                { "data": "quantity",orderable: false},
                { "data": "ordered_date",orderable: false},
                { "data": "days",orderable: false},
                { "data": "perprice",orderable: false},
                { "data": "price",orderable: false }
         ],
          "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
            var response = this.api().ajax.json();
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            total = api
                .column(6)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            pageTotal = api
                .column(6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            $( api.column(6).footer() ).html('₹'+pageTotal);
        },
    });

    $(document).ready(function () {
        $('#customer_id').bind("keyup change", function(){
            var customer_id = $("#customer_id").val().toLowerCase();
            filterTmestamp = toTimestamp($("#filter_date").val());
            var edit = "{{ url('admin/rentchallan')}}"+'/'+customer_id+'/?timestamp='+filterTmestamp
            $("#pdf").attr("href", edit);
            table.draw();
        });

        $('#filter_date').bind("change", function(){
            var customer_id = $("#customer_id").val().toLowerCase();
            filterTmestamp = toTimestamp($("#filter_date").val());
            var edit = "{{ url('admin/rentchallan/')}}"+'/'+customer_id+'/?timestamp='+filterTmestamp
            $("#pdf").attr("href", edit);
            table.draw();
        });
    });
</script>
@endsection
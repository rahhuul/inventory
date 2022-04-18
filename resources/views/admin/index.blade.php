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
                   <ul class="list-group list-group-unbordered mb-3">
<li class="list-group-item">
<b>A/C Amount</b> <a class="float-right" id="amount">0</a> 
</li>
<li class="list-group-item">
<b>Pending Material Bill</b> <a class="float-right" id="pendingbill">0</a>
</li>
<li class="list-group-item">
<b>Received Material Bill</b> <a class="float-right" id="receivedbill">0</a>
</li>
<li class="list-group-item">
<b>Total</b> <a class="float-right" id="total">0</a>
</li>
</ul>
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
  $('#customer_id').on('change', function() {
    var customer_id = this.value;
    $.ajax({
            "url": "{{ url('accountstatus') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ 
              _token: "{{csrf_token()}}",
              customer_id:customer_id

            }
            , success: function(result){
              $("#pendingbill").text(result.pendingbill);
              $("#receivedbill").text(result.receivedbill);
              $("#total").text(result.total);
              $("#amount").text(result.useramount);

            console.log("result",result);
            }
         })
  
});
</script>
@endsection

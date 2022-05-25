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
                     <!-- <div>
                        <a href="{{URL('/admin/category/create')}}" class="btn btn-primary addcat">Add Category</a>
                     </div> -->
                     <br> 
                     <div class="card">
                        <!-- <div class="card-header">
                           <h3 class="card-title">Category</h3>
                        </div> -->
                        <div class="card-body table-responsive col-sm-12">
                           <table id="ex4" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
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
    $(document).ready(function () {
      var table = $('#ex4').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            "url": "{{ url('bill') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"}
         },
         "columns": [
                { "data": "id",orderable: false },
                { "data": "customer" },
                { "data": "material" },
                { "data": "ordered_at" },
                { "data": "quantity" },
                { "data": "options",orderable: false }
         ]	
      });
   });
</script>
@endsection
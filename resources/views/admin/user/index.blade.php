@extends('admin.layouts.layout')

<!-- php code section start -->
@section('code_php')
@endsection 
<!-- php code section end -->

<!-- title section start -->
@section('title')
    <title>NFT EVENT : {{$title}}</title>
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
                        <a href="{{URL('/admin/user/create')}}" class="btn btn-primary addcat">Add Customer</a>
                     </div>
                     <br> 
                     <div class="card">
                        <div class="card-header">
                           <h3 class="card-title">Customer</h3>
                        </div>
                        <div class="card-body table-responsive col-sm-12">
                           <table id="ex1" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php  $i=1; @endphp
                                 @foreach ($listusers as $key => $data)
                                 <tr>
                                    <th>{{$i}}</th>
                                    <th>{{$data->name}}</th>
                                    <th>{{$data->email}}</th>
                                    <th>{{$data->address}}</th>
                                    <th>{{$data->mobile}}</th>
                                    <th>
                                       <a href="{{url('/admin/user/edit/'.$data->id)}}" class="btn btn-info btn-sm">
                                       <i class="fas fa-pencil-alt">
                                       </i>
                                       </a>
                                       <a href="{{url('/admin/user/delete/'.$data->id)}}" class="btn btn-danger btn-sm">
                                       <i class="fas fa-trash">
                                       </i>
                                       </a>
                                 </tr>
                                 @php  $i+=1; @endphp
                                 @endforeach
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
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
    var table = $('#ex1').DataTable({
           
            paging:true,
            searching: true,
            ordering:true
           });
});
     
   // transction_deposit._fetch_data_dep();
</script>
@endsection
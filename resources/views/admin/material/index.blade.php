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
               <a href="{{URL('/admin/material/create')}}" class="btn btn-primary addcat">Add Material</a>
            </div>
            
            <!-- <div class="col-sm-4" >
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
                     
                     <div class="card">
                        <!-- <div class="card-header">
                           <h3 class="card-title">Material</h3>
                        </div> -->
                        <div class="card-body table-responsive col-sm-12">
                           <table id="ex1" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Rent Price</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Rent Price</th>
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
         processing: true,
         serverSide: true,
         ajax: {
            "url": "{{ url('materials') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"}
         },
         "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]],
         "createdRow": function(row, data, dataIndex) {
                let material_id = data.material_id;
               $(row).prop('id', material_id); 
            },
         "order": [[1, "asc" ]],
         "columns": [
                { "data": "id",orderable: false},
                { "data": "name" },
                { "data": "quantity" },
                { "data": "rentprice" },
                { "data": "options",orderable: false }
         ]	
      });

      $(document).on('click', ".btn-danger", function() {
         var id   = $(this).data('id');
         var name   = $(this).data('name');
         console.log("id >>> ", id);

         Swal.fire({
            title: "Delete Material",
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
                     //url: "/admin/material/" + id,
                     url: "{{ route('deletematerial') }}",
                     type: 'POST',
                     dataType: "JSON",
                     data: {
                        "id": id,
                        "token" : '{{ csrf_token() }}',
                     },
                     complete: function (response) {
                        toastr.error(name+" removed");
                        table.row("#"+id).remove().draw();
                        //table.draw()
                     },
                     error: function(xhr) {

                     }
               });
            }
         });
         });

   });
     
   // transction_deposit._fetch_data_dep();
</script>
@endsection
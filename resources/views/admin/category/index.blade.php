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
                        <a href="{{URL('/admin/category/create')}}" class="btn btn-primary addcat">Add Category</a>
                     </div>
                     <br> 
                     <div class="card">
                        <div class="card-header">
                           <h3 class="card-title">Category</h3>
                        </div>
                        <div class="card-body table-responsive col-sm-12">
                           <table id="ex1" class="table table-bordered table-striped data-table_funddep">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php  $i=1; @endphp
                                 @foreach ($listcategorys as $key => $data)
                                 <tr>
                                    <th>{{$i}}</th>
                                    <th>{{$data->name}}</th>
                                    <th>
                                       <a href="{{route('category.edit', $data->category_id)}}" class="btn btn-info btn-sm">
                                       <i class="fas fa-pencil-alt">
                                       </i>
                                       </a>
                                       <a data-id="{{$data->category_id}}" data-name="{{$data->name}}" href="javascript:void(0)" class="btn btn-danger btn-sm">
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

      $(".btn-danger").on('click', function() {
         var id   = $(this).data('id');
         var name   = $(this).data('name');
         console.log("id >>> ", id);

         Swal.fire({
            title: "Delete Category",
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
                     url: "/admin/category/" + id,
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
     
   // transction_deposit._fetch_data_dep();
</script>
@endsection
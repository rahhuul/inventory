<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    
    <h3 class="profile-username text-center">Rent</h3>

    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Customer</b> <a class="float-right">{{$rent->customer->name}}</a>
      </li> 
      {{-- <li class="list-group-item">
        <b>Category</b> <a class="float-right">{{$rent->category->name}}</a>
      </li>  --}}
      <li class="list-group-item">
        <b>Material</b> <a class="float-right">{{$rent->material->name}}</a>
      </li>
      <li class="list-group-item">
        <b>Quantity</b> <a class="float-right">{{$rent->quantity}}</a>
      </li>
      <li class="list-group-item">
        <b>Return Quantity</b> <a class="float-right">{{$rent->return_quantity}}</a>
      </li>
      <li class="list-group-item">
        <b>Remain Quantity</b> <a class="float-right">{{$rent->remain_quantity}}</a>
      </li>
      <li class="list-group-item">
        <b>Order Date</b> <a class="float-right">{{ Carbon\Carbon::parse($rent->ordered_at)->format('d-m-Y') }}
        </a>
      </li>
    </ul>
  </div>
  <!-- /.card-body -->
</div>
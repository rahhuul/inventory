<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    
    <h3 class="profile-username text-center">Receive</h3>
    
    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Customer</b> <a class="float-right">{{$received->rent->customer->name}}</a>
      </li> 

    {{--   <li class="list-group-item">
        <b>Category</b> <a class="float-right">{{$received->rent->category->name}}</a>
      </li>  --}} 
      <li class="list-group-item">
        <b>Material</b> <a class="float-right">{{$received->rent->material->name}}</a>
      </li>
      <li class="list-group-item">
        <b>Received Quantity</b> <a class="float-right">{{$received->received_quantity}}</a>
      </li>
      <li class="list-group-item">
        <b>Received Date</b> <a class="float-right">{{ Carbon\Carbon::parse($received->receive_date)->format('d-m-Y') }}
        </a>
      </li>      
     <li class="list-group-item">
        <b>Damaged Quantity</b> <a class="float-right">{{$received->damaged_quantity?$received->damaged_quantity:0}}</a>
      </li>
       <li class="list-group-item">
        @php 
          $damagedprice = $received->damaged_quantity * $received->rent->material->damagePrice;
        @endphp
        <b>Damaged Price</b> <a class="float-right">{{$damagedprice}} </a>
      </li>
       <li class="list-group-item">
        @php 
          $rentprice = $received->received_quantity * $received->rent->material->rentPrice;
        @endphp
        <b>Rent Price</b> <a class="float-right">{{$rentprice}} </a>
      </li>
     
      
    </ul>
  </div>
  <!-- /.card-body -->
</div>
<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    
    <h3 class="profile-username text-center">Pending Material</h3>

    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Customer</b> <a class="float-right">{{$alldetail->rent->customer->name}}</a>
      </li> 
     
      <li class="list-group-item">
        <b>Material</b> <a class="float-right">{{$alldetail->rent->material->name}}</a>
      </li>
      <li class="list-group-item">
        <b>Quantity</b> <a class="float-right">{{$alldetail->rent->quantity}}</a>
      </li>
      <li class="list-group-item">
        <b>Return Quantity</b> <a class="float-right">{{$alldetail->rent->return_quantity?$alldetail->rent->return_quantity:0}}</a>
      </li>
      <li class="list-group-item">
        <b>Remain Quantity</b> <a class="float-right">{{$alldetail->rent->remain_quantity?$alldetail->rent->remain_quantity:0}}</a>
      </li>
      <li class="list-group-item">
        <b>Order Date</b> <a class="float-right">{{ Carbon\Carbon::parse($alldetail->rent->ordered_at)->format('d-m-Y') }}
        </a>
      </li>

        <li class="list-group-item">
        @php $penmaterial = ($alldetail->pending_material !='') ? $alldetail->pending_material : 0 ;@endphp 
        <b>Pending Material</b> <a class="float-right">{{($penmaterial)}}</a>
      </li>
    </ul>
  </div>
  <!-- /.card-body -->
</div>
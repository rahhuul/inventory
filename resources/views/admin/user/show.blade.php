<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    
    <h3 class="profile-username text-center">{{$user->name}}</h3>

    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Mobile</b> <a class="float-right">{{$user->mobile}}</a> 
      </li> 
      <li class="list-group-item">
        <b>Balance</b> <a class="float-right">{{($user->amount!='')?$user->amount:0}}</a>
      </li>
      <li class="list-group-item">
        <b>Address</b> <a class="float-right">{{$user->address}}</a>
      </li>
      <li class="list-group-item">
        <b>Reference Name</b> <a class="float-right">{{$user->reference_name}}</a>
      </li>
      <li class="list-group-item">
        <b>Reference Mobile</b> <a class="float-right">{{$user->reference_mobile}}</a>
      </li>
      <li class="list-group-item">
        <b>User Type</b> <a class="float-right">{{($user->type == 0) ? "Rental" : "Provider"}}</a>
      </li>
    </ul>
  </div>
  <!-- /.card-body -->
</div>
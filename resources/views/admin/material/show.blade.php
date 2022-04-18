<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    
    <h3 class="profile-username text-center">{{$material->name}}</h3>

    <ul class="list-group list-group-unbordered mb-3">
      {{-- <li class="list-group-item">
        <b>Category</b> <a class="float-right">{{$material->category->name}}</a>
      </li> --}}
      <li class="list-group-item">
        <b>Quantity</b> <a class="float-right">{{$material->quantity}}</a>
      </li>
      <li class="list-group-item">
        <b>Rent Price</b> <a class="float-right">{{$material->rentPrice}}</a>
      </li>
      <li class="list-group-item">
        <b>Damage Price</b> <a class="float-right">{{$material->damagePrice}}</a>
      </li>
      
    </ul>
  </div>
  <!-- /.card-body -->
</div>
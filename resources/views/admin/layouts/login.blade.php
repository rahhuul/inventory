@extends('admin.layouts.login_layout')

<!-- Main Content section start -->
@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Inventory</b>Management</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form name="login_frm" id="login_frm" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="txtusername">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="error txtusername"></div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="txtpassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="error txtuserpassword"></div>
        <div class="row">
        
          <!-- /.col -->
          <div class="col-4">
            <input type="submit" class="btn btn-primary btn-block" value="Sign In" name="e_action">
          </div>
          <!-- /.col -->
        </div>
      </form>
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

@endsection
<!-- Main Content section end -->
{{-- script tag start --}}
@section('script')
<script src="{{URL('/')}}/assets/admin/assets/js/jquery.validate.js"></script>
<script src="{{URL('/')}}/assets/admin/js/main_admin.js"></script>
<script type="text/javascript" src="{{URL('/')}}/assets/js/noty.min.js"></script>
<script type="text/javascript">
    cubemine_admin.loginvalidate();
</script>
@endsection
{{-- script tag end --}}
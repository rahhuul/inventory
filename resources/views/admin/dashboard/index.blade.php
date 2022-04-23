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
<div class="wrapper">
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" style="text-align: center;font-weight: bold;text-transform: uppercase;letter-spacing: 3px;">Jay Swaminarayan</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
     <section class="content">
      {{--  <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row" style="text-align: center;">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/user')}}" style="color: #fff;letter-spacing: 2px;">All <br> Customers </a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/material')}}" style="color: #fff;letter-spacing: 2px;">All <br> Material</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/rent')}}" style="color: #fff;letter-spacing: 2px;">Rent <br> Material</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/received')}}" style="color: #fff;letter-spacing: 2px;">Received <br> Material</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <!-- Small boxes (Stat box) -->
        <div class="row" style="text-align: center;">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/pending')}}" style="color: #fff;letter-spacing: 2px;">Pending <br> Material</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/customaterial')}}" style="color: #fff;letter-spacing: 2px;">Customer <br> Material</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/bill')}}" style="color: #fff;letter-spacing: 2px;">Generate <br> Bill</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4 style="margin: 0px;"><a href="{{URL('/admin/bill')}}" style="color: #fff;letter-spacing: 2px;">Account <br> Status</a></h4>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
       
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->  --}}
    </section>
    <!-- /.content -->
  </div>
 
</div>
<!-- ./wrapper -->
@endsection


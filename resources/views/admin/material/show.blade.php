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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Event Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>   <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-sm-6">
               <div class="card">
                <div class="card-header">
                      <h3>Basic Detail</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><b>Title</b></td>
                                    <td>{{$eventresult->title}}</td>
                                </tr>
                                <tr>
                                    <td><b>Description</b></td>
                                    <td>{{$eventresult->description}}</td>
                                </tr>
                               
                                <tr>
                                    <td><b>Customer Type</b></td>
                                    <td>{{$eventresult['category']->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Timezone</b></td>
                                    <td>{{$eventresult->timezone}}</td>
                                </tr>
                                <tr>  
                                    <td><b>Image</b></td>
                                    <td><img src="{{url('assets/upload/'.$eventresult->image)}}" width="100px" height="100px"></img></td>
                                </tr>
                                 </tbody></table></div></div></div></div>
                <div class="col-sm-6">
                 <div class="card">
                <div class="card-header">
                      <h3>Creator Details</h3>
                    <div class="table-responsive">
                                  <table class="table">
                            <tbody>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td>{{$eventresult->name}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Email</b></td>
                                    <td>{{$eventresult->email}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Phone</b></td>
                                    <td>{{$eventresult->phone}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Website</b></td>
                                    <td>{{$eventresult->website}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Twitter</b></td>
                                    <td>{{$eventresult->twitter}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Instagram</b></td>
                                    <td>{{$eventresult->instagram}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Facebook</b></td>
                                    <td>{{$eventresult->facebook}}</td>
                                </tr>
                                </tbody></table></div></div></div></div>
                                  <div class="col-sm-6">
                <div class="card">
                <div class="card-header">
                                <h3>Event Price</h3>
                    <div class="table-responsive">
                                 <table class="table">
                            <tbody>
                                 <tr>
                                    <td><b>Pre-Sale Price</b></td>
                                    <td>{{$eventresult->preprice}}</td>
                                </tr> 
                                <tr>
                                    <td><b>Price</b></td>
                                    <td>{{$eventresult->price}}</td>
                                </tr> 
                                <tr>
                                    <td><b>Supply</b></td>
                                    <td>{{$eventresult->supply}}</td>
                                </tr>
                                </tbody></table></div></div></div></div>
                                  <div class="col-sm-6">
                 <div class="card">
                <div class="card-header">
                  <h3>Event Dates</h3>
                    <div class="table-responsive">
                            <table class="table">
                            <tbody>
                                 <tr>
                                    <td><b>Pre-Sale Start Date</b></td>
                                    <td>
                                        {{ $eventresult->pre_start_date!='' ? \Carbon\Carbon::parse($eventresult->pre_start_date)->format('d M Y h:i A') : null }}
                                       </td>
                                </tr>
                                 <tr>
                                    <td><b>Pre-Sale End Date</b></td>
                                    <td> {{ $eventresult->pre_end_date!='' ? \Carbon\Carbon::parse($eventresult->pre_end_date)->format('d M Y h:i A') : null }}
                                    </td>
                                </tr> 
                                <tr>
                                    <td><b>Launch Start date</b></td>
                                    <td> {{ $eventresult->launch_start_date!='' ? \Carbon\Carbon::parse($eventresult->launch_start_date)->format('d M Y h:i A') : null }} 
                                    </td>
                                </tr> 
                                <tr>
                                    <td><b>Launch End date</b></td>
                                    <td> 
                                        {{ $eventresult->launch_end_date!='' ? \Carbon\Carbon::parse($eventresult->launch_end_date)->format('d M Y h:i A') : null }}
                                    </td>
                                </tr>
                                </tbody></table></div></div></div></div>
                                  <div class="col-sm-6">
                 <div class="card">
                <div class="card-header">
                                <h3>Event Details</h3>
                    <div class="table-responsive">
                                 <table class="table">
                            <tbody>
                                <tr>
                                    <td><b>Discord Url</b></td>
                                    <td>{{$eventresult->discord_url}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Twitter Url</b></td>
                                    <td>{{$eventresult->twitter_url}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Website Url</b></td>
                                    <td>{{$eventresult->website_url}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Marketplace link</b></td>
                                    <td>{{$eventresult->marketplace_link}}</td>
                                </tr>
                                 <tr>
                                    <td><b>Address</b></td>
                                    <td>{{$eventresult->address}}</td>
                                </tr>
                              </tbody></table></div></div></div></div>
                               <div class="col-sm-6">
                 <div class="card">
                <div class="card-header">
                                 <h3>Event Specification</h3>
                    <div class="table-responsive">
                                 <table class="table">
                            <tbody>
                                   <tr>
                                    <td><b>Event Tag</b></td>
                                    @if($eventresult['tag']!='')
                                    <td>
                                    @foreach($eventresult['tag'] as $tag)
                                    {{$tag['tagname']}}
                                      @endforeach
                                      </td>
                                      @else
                                      <td></td>
                                      @endif



                                </tr>
                                 <tr>
                                    <td><b>Event Collection</b></td>
                                    @if($eventresult['collection']!='')
                                    <td>{{$eventresult['collection']->collname}}</td>
                                  @else
                                  <td></td>
                                @endif
                                </tr>
                                 <tr>
                                    <td><b>Image Type</b></td>
                                    @if($eventresult['imgtype']!='')
                                     <td>{{$eventresult['imgtype']->imgname}}</td>
                                    @else
                                      <td></td>
                                    @endif
                                  </tr>
                                 <tr>
                                    <td><b>Event Contract</b></td>
                                    @if($eventresult['contract']!='')
                                      <td>{{$eventresult['contract']->contname}}</td>
                                    @else
                                      <td></td>
                                    @endif
                                </tr>
                                 <tr>
                                    <td><b>Event Currency</b></td>
                                    @if($eventresult['currency']!='')
                                      <td>{{$eventresult['currency']->name}}</td>
                                    @else
                                      <td></td>
                                    @endif
                                </tr>
                                </tbody></table></div></div></div></div>
                           <!--  </tbody>
                        </table> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>

@endsection
<!-- Main Content section end -->


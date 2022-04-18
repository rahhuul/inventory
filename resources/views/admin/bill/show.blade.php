<head>
    <style type="text/css">
    .card-primary.card-outline {
    border-top: 3px solid #007bff;
    }
    .card-body {
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
}
.invoice {
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125);
    position: relative;
}
.p-3 {
    padding: 1rem!important;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}
.row {
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -7.5px;
    margin-left: -7.5px;
}
.col-sm-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}
.main-footer {
    background-color: #fff;
    border-top: 1px solid #dee2e6;
    color: #869099;
    padding: 1rem;
}
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.col-12 {
    -webkit-flex: 0 0 100%;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
.table:not(.table-dark) {
    color: inherit;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    background-color: transparent;
}
table {
    border-collapse: collapse;
}
*, ::after, ::before {
    box-sizing: border-box;
}
user agent stylesheet
table {
    display: table;
    border-collapse: separate;
    box-sizing: border-box;
    text-indent: initial;
    border-spacing: 2px;
    border-color: grey;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table td, .table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
th {
    text-align: inherit;
    text-align: -webkit-match-parent;
}
*, ::after, ::before {
    box-sizing: border-box;
}
user agent stylesheet
th {
    display: table-cell;
    vertical-align: inherit;
    font-weight: bold;
    text-align: -internal-center;
}
thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
}
.table td, .table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
*, ::after, ::before {
    box-sizing: border-box;
}
user agent stylesheet
td {
    display: table-cell;
    vertical-align: inherit;
}
.table:not(.table-dark) {
    color: inherit;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    background-color: transparent;
}
table {
    border-collapse: collapse;
}
user agent stylesheet
table {
    border-collapse: separate;
    text-indent: initial;
    border-spacing: 2px;
}
tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}
b, strong {
    font-weight: bolder;
}

*, ::after, ::before {
    box-sizing: border-box;
}

.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 7.5px;
    padding-left: 7.5px;
}
body {
    margin: 0;
    font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff;
}
.float-right {
    float: right!important;
}
.small, small {
    font-size: 80%;
    font-weight: 400;
}
.h4, h4 {
    font-size: 1.5rem;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-bottom: 0.5rem;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.2;
    color: inherit;
}

h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
}
</style> 
</head>

<div class="invoice p-3 mb-3">

<div class="row">
<div class="col-12">
<h4>
<i class="fas fa-globe"></i> Inventory
<small class="float-right">Date: {{\Carbon\Carbon::now()->format('d/m/Y')}}</small>
</h4>
</div>

</div>

<div class="row invoice-info">

  <div class="col-sm-12" style="padding-bottom: 30px;">
    
    <div class="row">
      <div class="col-md-12">
        To
      </div>
    </div>

    <div class="" style="float: left;">
      <address>
        <strong>{{$userdata->name}}</strong><br>
          {{$userdata->address}}<br>
          Phone: {{$userdata->mobile}} <br>
        </address>
    </div>

    <div class="" style="float: right;">
      <b>Invoice #007612</b><br>
      <b>Order ID:</b>{{$rents[0]->rent_id}}<br>
    </div>
    

  </div>

<br><br><br>

</div>


<div class="row">
<div class="col-12 table-responsive">
<table class="table table-striped">
<thead>
<tr>
 <th>No</th>
<th>Material</th>
<th>Quantity</th>
<th>Order Date</th>
<th>Received Date</th>
<th>Price</th>
<th>Total</th>
</tr>
</thead>
<tbody>

   @php 
    $i=1;
    $pending = '';
    $renttotal = 0;
    $receivedtotal = 0;
    $totalRentprice = 0;
     $total =0;
   @endphp


  @foreach ($mixedcustomerdata as $val)
  @php
   if(isset($val->status))
            {
                $rendDate = Carbon\Carbon::parse($val->ordered_at);
                $now = Carbon\Carbon::now();
                $diff = $rendDate->diffInDays($now);
                
                $calcQty = ($val->remain_quantity == null || $val->remain_quantity == 0) ? $val->quantity : $val->remain_quantity;

                $totalRentprice = ($diff > 15) ? ($calcQty*$val->material->rentperPrice) * $diff : $calcQty * $val->material->rentperPrice * 15;
                $renttotal += $totalRentprice;
            }
            else
            {
                $receiveDate = Carbon\Carbon::parse($val->receive_date);
                $rent_data = $rendDate;
                $diff = $receiveDate->diffInDays($rent_data) + 1;
                $totalRentprice = ($val->received_quantity * $val->material->rentperPrice) * $diff;
                $receivedtotal +=$totalRentprice; 
            }
            $total += round($totalRentprice,2);
 @endphp
<tr>
<td>{{$i}}</td>
<td>{{(isset($val->status))?$val->material->name:$val->material->name}}</td>
<td>{{(isset($val->status))?($val->quantity):((isset($val->received_id))?$val->received_quantity:0)}}</td>
<td>{{(isset($val->status))?date('d-m-Y',strtotime($val->ordered_at)):'-'}}</td>
<td>{{(isset($val->receive_status))?date('d-m-Y',strtotime($val->receive_date)):'-'}}</td>
<td>{{$val->material->rentPrice}}</td>
<td>{{ number_format($totalRentprice, 2) }}</td>
 
</tr>
@php $i++;
$renttotal = round($renttotal,2);
$receivedtotal = round($receivedtotal,2); 
@endphp
  @endforeach
   <tr>

    <td colspan="5">(Renttotal[{{$renttotal}}] - Receivedtotal[{{$receivedtotal}}])</td>
    <td><b>Total:</b></td>
    <td>{{$total}}</td>
  </tr>


</tbody>
</table>
</div>

</div>





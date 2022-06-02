<!DOCTYPE html>
<html>
<head>
    <title>Generate PDF Laravel 8 - NiceSnippets.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:30px;
        padding:50px;
        background:#fff;
    }
    .pdf-btn{
        margin-top:30px;
    }
</style>    
<body>
    <div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
   
    <!-- info row -->
        <div class="col-12">
        <div class="table">
          <table class="table" border="1">
            <tr>
                <td colspan="2" align="center" >INVOICE</td>
            </tr>
            <tr>
              <td>Contact person Name:{{$receiveddata['customer']['name']}}</td>
            </tr>
            <tr>
              <td>Address:{{$receiveddata['customer']['address']}}</td>
            </tr>
            <tr>
              <td>Mobile no:{{$receiveddata['customer']['mobile']}},{{$receiveddata['customer']['reference_mobile']}}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="col-12">

        <div class="table">
          <table class="table" border="1">
            <tr>
              <td>Invoice Type:Pending Material Bill</td>
               <td>Date:{{\Carbon\Carbon::now()->format('d-M-Y')}}</td>
            </tr>
            <tr>
              <td>Customer Name:{{$receiveddata['customer']['name']}}</td>
              <td>Reference Name:{{$receiveddata['customer']['reference_name']}}</td>
            </tr>
            <tr>
              <td>Mobile No:{{$receiveddata['customer']['mobile']}}</td>
              <td>Mobile No:{{$receiveddata['customer']['reference_mobile']}}</td>
            </tr>

             <tr>
              <td>Address:{{$receiveddata['customer']['address']}}</td>
              <td>Address:</td>
            </tr>
          </table>
        </div>
      </div>
   
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped" border="1">
          <thead>
          <tr>
            <th>No</th>
            <th>Material Name</th>
            <th>Rent Quantity</th>
            <th>Start date</th>
            <th>Days</th>
            <th>Rent Price</th>
            <!-- <th>Damage Price</th>
            <th>Damage Quantity</th> -->
           
          </tr>
          </thead>
          <tbody>
          @php 
            $i=1;
            $day = 15;
            $days ='';
            $d =0;
            $totalrent=0;
            $tdmquantity = 0;
            $diff_in_days = '';
            $totald=0;
        @endphp


          @foreach ($receiveddata['received'] as $val)

          $to =  \Carbon\Carbon::now()->format('Y-m-d');
          $from = \Carbon\Carbon::createFromFormat('Y-m-d', $receiveddata['ordered_at']);
         $diff_in_days = $to->diffInDays($from);
    

    @php  $date1 =$receiveddata['ordered_at']; 
          $date2 = $val['receive_date'];
         $diff = abs(strtotime($date2) - strtotime($date1));
         $years = floor($diff / (365*60*60*24));
         $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = (int)($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24);
          $d +=$days;

          $tdmquantity +=$val['damaged_quantity'];
         @endphp




          @if($day > $d)
   @php $totalrent = $receiveddata['material']['rentPrice']* $day * $receiveddata['quantity']; @endphp
@else
   @php 
   $extraday = $d - $day;
   $day = $extraday ;
   echo $totalrent = $receiveddata['material']['rentPrice']* $day *$receiveddata['quantity'];@endphp
@endphp 

<!-- @php $totaldamageprice = $val['damaged_quantity']*$receiveddata['material']['damagePrice']; 
echo $totald = $totalrent + $totaldamageprice; 

@endphp -->
 
@endif
 
         

        <tr>
        <td>{{$i}}</td>
        <td>{{$receiveddata['material']['name']}}</td>
        <td>{{$receiveddata['quantity']}}</td>
        <td>{{$receiveddata['ordered_at']}}</td>
        <td>{{$days}}</td>
        <td>{{$receiveddata['material']['rentPrice']}}</td>
        
        <!-- <td>{{$receiveddata['material']['damagePrice']}}</td>
        <td>{{$val['damaged_quantity']}}</td> -->
</tr>
        @php $i++; @endphp
          @endforeach
          <tr>
              <td colspan="3"><strong>Copyright © 2014-2021<a href="">AdminLTE.io</a>.</strong></td>
              <td colspan="2">Total Amount</td>
              <td>{{$totalrent}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

   
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
</body>
</html>
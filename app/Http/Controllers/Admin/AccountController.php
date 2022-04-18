<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\Received;
use App\Models\Material;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Generate Bill";
        $customers = User::all()->pluck('name', 'user_id');
        return view('admin/account/index',compact('title','customers'));
    }

    public function getaccountdetail(Request $request){

        $customer_id = $request->input('customer_id');
        $userdata = User::where('user_id',$customer_id)->first();
        
        $rentdata = Rent::with('customer','material')->where('customer_id',$customer_id)->where('status',0)->get();
        $receeiveddata = Received::with('customer', 'material', 'rent')
                        ->where('customer_id', $customer_id)
                        ->where('receive_status', '1')
                        ->get();
        
        $pending = 0;
        $received = 0;

        foreach ($rentdata as $key => $value){
            $pendingQty =($value->remain_quantity == null || $value->remain_quantity == 0) ? $value->quantity : $value->remain_quantity;
            $receivedQty = $value->return_quantity;

            if($pendingQty > 0){
                $rendDate = Carbon::parse($value->ordered_at);
                $now = Carbon::now();
                $diff = $rendDate->diffInDays($now);
                $diff = $diff+1;
                $diff = ($diff < 15) ? 15 : $diff;
                
                $pending += ($value->material->rentperPrice*$pendingQty)*$diff;
            }

            /* if($receivedQty > 0){
                $rendDate = Carbon::parse($value->ordered_at);
                $recDate = Carbon::parse($value->received[0]->receive_date);
                $recdiff = $rendDate->diffInDays($recDate);
                $recdiff = $recdiff+1;
                if($recdiff<15)
                {
                    $recdiff= 15;
                }
                
                $received += ($value->material->rentperPrice*$receivedQty)*$recdiff;
            } */
        }

        foreach ($receeiveddata as $key => $value){
            $receivedQty = $value->received_quantity;
            $rentDate = $value->rent->ordered_at;
            $receiveDate = $value->receive_date;

            if($receivedQty > 0){
                $rendDate = Carbon::parse($rentDate);
                $recDate = Carbon::parse($receiveDate);
                $recdiff = $rendDate->diffInDays($recDate);
                $recdiff = $recdiff+1;
                $recdiff = ($recdiff < 15) ? 15 : $recdiff;

                $received += ($value->material->rentperPrice*$receivedQty)*$recdiff;
            }
        }
        $total = $pending + $received;

        $account_data['total'] = round($total, 2);
        $account_data['receivedbill'] = round($received, 2);
        $account_data['pendingbill'] = round($pending, 2);
        $account_data['useramount'] = ($userdata->amount!='')?$userdata->amount:0;
        return $account_data;
        exit;
    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

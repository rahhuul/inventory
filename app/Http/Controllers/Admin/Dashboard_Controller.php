<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Users;
use Cookie,DB;
use Carbon\Carbon;
use DataTables;
use Carbon\CarbonPeriod;


class Dashboard_Controller extends Controller
{
    public function __construct(){
    }

    /*dashboard fuhnction start*/
   	public function index(Request $request){
 		$title      = "Dashboard";
   		return view('admin/dashboard/index',compact('title')); 
   	}
    /*dashboard fuhnction end*/

}


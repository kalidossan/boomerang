<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkOrderController extends Controller {
    
    public function index(){

    }
    
    public function work_order(Request $request){

        $data['work_order'] = DB::table('CRM_WORK_ORDER')->where('CWO_WO_ID',$request->work_order_select)->first();
        return response()->json($data);
    }

    
}

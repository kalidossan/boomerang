<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Message;

class ReportController extends Controller {
    
       public function customer_retailer_report(Request $request) {
        $date1 = "";
        $date2 = "";
        $date = "";
        if (isset($request->date_between1) && isset($request->date_between2)) {

            $date1 = date('Y-m-d H:i:00', strtotime(trim($request->date_between1)));
            $date2 = date('Y-m-d H:i:00', strtotime(trim($request->date_between2)));

            $data['customer'] = DB::table('CRM_CUSTOMER_MASTER')
                            ->whereBetween('CCM_DOB', [$date1, $date2])->get();
        } else {
            $data['customer'] = DB::table('CRM_CUSTOMER_MASTER')->limit(30)->get();
        }
        return view('retailer.customer_retailer_report', $data);
    }
    
      public function payment_retailer_report(Request $request) {
        $date1 = "";
        $date2 = "";
        $date = "";
        if (isset($request->date_between1) && isset($request->date_between2)) {

            $date1 = date('Y-m-d H:i:00', strtotime(trim($request->date_between1)));
            $date2 = date('Y-m-d H:i:00', strtotime(trim($request->date_between2)));

            $data['payment_log'] = DB::table('CRM_WORK_ORDER_PAY_LOG')
                            ->whereBetween('CWOPL_CREATED_DT', [$date1, $date2])->get();
        } else {
            $data['payment_log'] = DB::table('CRM_WORK_ORDER_PAY_LOG')->limit(30)->get();
        }
        return view('retailer.payment_retailer_report', $data);
    }
      public function sms_retailer_report(Request $request) {
        $date1 = "";
        $date2 = "";
        $date = "";
        if (isset($request->date_between1) && isset($request->date_between2)) {

            $date1 = date('Y-m-d H:i:00', strtotime(trim($request->date_between1)));
            $date2 = date('Y-m-d H:i:00', strtotime(trim($request->date_between2)));

            $data['sms_log'] = DB::table('CRM_SMS_REPORT')
                            ->whereBetween('CWOPL_CREATED_DT', [$date1, $date2])->get();
        } else {
            $data['sms_log'] = DB::table('CRM_SMS_REPORT')->limit(30)->get();
        }
        return view('retailer.sms_retailer_report', $data);
    }
    

    
}

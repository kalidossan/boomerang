<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Carbon\Carbon;

class RetailerController extends Controller {

    public function index() {
        if (Auth::user()->biz_id == 0) {
            return redirect('admin');
        }


        $events = [];
        $data = Event::all();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                                $value->title, true, new \DateTime($value->start_date), new \DateTime($value->end_date . ' +1 day'), null, [
                            'color' => '#337ab7',
                            //'url' => 'home#message',
                            'backgroundColor' => '#337ab7'
                                ]
                );
            }
        }
        $retailer_panel['categories_label'] = DB::table('CRM_CATEGORIES_MASTER')
                ->select('CCM_ID', 'CCM_LABEL_NAME')
                ->where('ccm_ret_biz_id', Auth::user()->biz_id)
                ->get();
        $retailer_panel['categories'] = DB::table('CRM_CAT_VALUES_MASTER')
                ->select('CCVM_ID', 'CCVM_VALUE', 'CCVM_CCM_ID')
                ->get();
        $retailer_panel['customer'] = DB::table('CRM_CUSTOMER_MASTER')->limit(30)->get();
        $retailer_panel['retailer'] = DB::table('CRM_RETAILER_MASTER')->first();

        if (isset($request->cid)) {
            $cid = $request->cid;
        } else {
            $cid = 1;
        }

        $retailer_panel['retailer_categories'] = DB::table('CRM_CATEGORIES_MASTER')->select('*')->where('CCM_RET_BIZ_ID', Auth::user()->biz_id)->get();
        $retailer_categories_values = (new Category)->categoryValues($cid);

        $retailer_panel['categories_master'] = DB::table('CRM_CATEGORIES_MASTER')->select('*')->where('CCM_RET_BIZ_ID', Auth::user()->biz_id)->get();
        $retailer_panel['categories_master_values'] = (new Category)->categoryValues($cid);

        $retailer_panel['retailer_request'] = DB::table('CRM_ADD_REQUEST')
                ->join('CRM_CUST_RET_LINK', 'CRM_CUST_RET_LINK.CCRL_LINK_ID', '=', 'CRM_ADD_REQUEST.CAR_CCRL_LINK_ID')
                ->join('CRM_CUSTOMER_MASTER', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID', '=', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID')
                ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                ->where('CRM_ADD_REQUEST.CAR_REQ_TEXT_STATUS', 0)
                ->get();

        $retailer_panel['calendar'] = Calendar::addEvents($events);

        $retailer_panel['sender_id'] = DB::table('CRM_SENDER_ID')
                ->where('CSI_RET_BIZID', Auth::user()->biz_id)
                ->first();
        return view('retailer.retailer', $retailer_panel);
    }

    public function password_reset(Request $request) {
        $udata['password'] = \Hash::make($request->password_update);
        DB::table('users')->where('role_id', '<>', 1)->where('biz_id', Auth::user()->biz_id)->update($udata);
    }
    
      public function sender_id(Request $request) {
        $udata['CSI_TEMP_SENDERID'] = $request->temporary_sender_id;
        DB::table('CRM_SENDER_ID')->where('CSI_RET_BIZID', Auth::user()->biz_id)->update($udata);
    }

    public function retailer_reponse(Request $request) {
        $data['CAR_RESPONSE_DT'] = Carbon::now();
        $data['CAR_RESPONSE_TEXT'] = $request->retailer_response_text;
        $data['CAR_REQ_TEXT_STATUS'] = 1;
        DB::table('CRM_ADD_REQUEST')->where('CAR_REQUEST_ID', $request->retailer_response_id)->update($data);
        return response()->json(['success' => 'Response Submitted']);
    }

}

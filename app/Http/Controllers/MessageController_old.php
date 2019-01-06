<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Message;

class MessageController extends Controller {

    public function flipAndGroup($input) {
        $outArr = array();
        array_walk($input, function($value, $key) use (&$outArr) {
            if (!isset($outArr[$value]) || !is_array($outArr[$value])) {
                $outArr[$value] = [];
            }
            $outArr[$value][] = $key;
        });
        return $outArr;
    }

    public function message_center(Request $request) {

        if (isset($request->msg_history_id)) {
            $data['msg_send_again'] = DB::table('CRM_MC_HISTORY')->where('CMH_ID', $request->msg_history_id)->first();
            $data['mc_category_values'] = DB::table('CRM_MC_CAT_VALUES_HISTORY')
                    ->select('CMCV_CCM_LABEL_NAME', 'CMCV_CCVM_VALUE')
                    ->where('CMCV_ID', $request->msg_history_id)
                    ->get();
            //print_r($data['mc_category_values']);
        } else {
            $data['msg_send_again'] = array();
        }

        $data['categories_label'] = DB::table('CRM_CATEGORIES_MASTER')
                ->select('CCM_ID', 'CCM_LABEL_NAME')
                ->where('ccm_ret_biz_id', Auth::user()->biz_id)
                ->get();
        // dd($categories_label[0]->CCM_ID);
        $data['categories'] = DB::table('CRM_CAT_VALUES_MASTER')
                ->select('CCVM_ID', 'CCVM_VALUE', 'CCVM_CCM_ID')
                ->get();
        //$plan = DB::table('CRM_PLAN_ENTRY_MASTER')->get();

        return view('retailer.message_center', $data);
    }

    public function mc_category_values(Request $request) {
        $data['mc_category_values'] = DB::table('CRM_MC_CAT_VALUES_HISTORY')
                ->select('CMCV_CCM_LABEL_NAME', 'CMCV_CCVM_VALUE')
                ->where('CMCV_ID', $request->msg_history_id)
                ->get();
        return response()->json($data);
    }

    public function message_history(Request $request) {

        $data['message_history'] = DB::table('CRM_MC_HISTORY')->where('CMH_RET_BIZ_ID', Auth::user()->biz_id)->get();

        return view('retailer.message_history', $data);
    }

    public function store(Request $request) {

        if ($request->c_mc_category_values_id!=null) {

            $category_values_ids = explode(',', $request->c_mc_category_values_id);


            foreach ($category_values_ids as $k => $category_values_id) {

                $getCatLabelId = DB::table('CRM_CAT_VALUES_MASTER')
                                ->where('CCVM_ID', $category_values_id)
                                ->first()
                        ->CCVM_CCM_ID;

                $category_labels_ids[$category_values_id] = $getCatLabelId;
            }

            $combine_label_values = $this->flipAndGroup($category_labels_ids);


            foreach ($combine_label_values as $key => $value) {

                foreach ($value as $k => $v) {

                    $vkey[$key][] = $v;
                }

                $one_combine_label_values[$key] = implode(',', $vkey[$key]);

                $label_values = $one_combine_label_values;
            }
        }

        \DB::beginTransaction();
        try {
            $sender_id = DB::table('CRM_SENDER_ID')->where('CSI_RET_BIZID', Auth::user()->biz_id)->first()->CSI_SENDER_ID;

            // if ($request->c_message_type == 0) {

            if ($request->c_gender_group == '2') {
                $select_gender = [0, 1];
            } else {
                $select_gender = array($request->c_gender_group);
            }

            if ($request->c_cust_pros_target == '2') {
                $select_audience = [0, 1];
            } else {
                $select_audience = array($request->c_cust_pros_target);
            }

            $customer = array();
            $cust_1 = array();
            $cust_2 = array();

            $customer_1 = DB::table('CRM_CUSTOMER_MASTER')
                    ->join('CRM_CUST_RET_LINK', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID', '=', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID')
                    ->select('CCM_MOBILE_NO')
                    ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                    ->whereIn('CCM_GENDER', $select_gender)
                    ->orWhereIn('CCRL_CUST_PROS_TYPE', $select_audience)
                    ->get();

            foreach ($customer_1 as $key => $value) {
                $cust_1[] = $value->CCM_MOBILE_NO;
            }


            $mc_cat_val = explode(',', $request->c_mc_category_values_id);

            $link_id = DB::table('CRM_CUST_RET_LINK')->select('CCRL_LINK_ID')
                            ->where('CCRL_RET_BIZ_ID', Auth::user()->biz_id)->get();

            foreach ($link_id as $key => $value) {

                $mc_cust_cat_val = DB::table('CRM_CUST_CAT_VALUES')->select('CCCV_VALUE')
                                ->where('CCCV_LINK_ID', $value->CCRL_LINK_ID)->first();

                foreach ($mc_cat_val as $k => $v) {

                    if ($v == $mc_cust_cat_val->CCCV_VALUE) {

                        $cust_2[] = DB::table('CRM_CUSTOMER_MASTER')
                                        ->join('CRM_CUST_RET_LINK', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID', '=', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID')
                                        ->join('CRM_CUST_CAT_VALUES', 'CRM_CUST_CAT_VALUES.CCCV_LINK_ID', '=', 'CRM_CUST_RET_LINK.CCRL_LINK_ID')
                                        ->select('CCM_MOBILE_NO')
                                        ->where('CRM_CUST_CAT_VALUES.CCCV_LINK_ID', $value->CCRL_LINK_ID)
                                        ->first()->CCM_MOBILE_NO;
                    }
                }
            }


            $customer[] = array_unique(array_merge($cust_1, $cust_2));

            $cust_no = array();

            foreach ($customer as $key => $value) {
                $cust_no[] = $value;
            }

            $valid_till = date_create($request->c_valid_till);
            $valid_till_time = date_create($request->c_valid_till_time);
            $data['cme_ret_biz_id'] = Auth::user()->biz_id;
            $data['CME_SENDER_ID'] = $sender_id;
            $data['cme_msg_type'] = $request->c_message_type;
            $data['cme_msg_txt'] = $request->c_msg_txt;
            $data['cme_title'] = $request->c_message_title;
            $data['cme_msg_2b_sent'] = count($customer);
            $data['cme_ccm_gender'] = $request->c_gender_group;
            $data['cme_ccrl_cust_pros_type'] = $request->c_cust_pros_target;
            $data['cme_msg_status'] = 0;
            $data['cme_before_days'] = 0;
            $data['cme_schd_date'] = date_format($valid_till, "Y-m-d H:i:s");
            $data['cme_schd_time'] = date_format($valid_till_time, "H:i:s");
            $data['cme_created_dt'] = Carbon::now();
            $data['cme_created_by'] = Auth::user()->biz_id;
            $data['cme_modified_dt'] = Carbon::now();
            $data['cme_modified_by'] = Auth::user()->biz_id;

            $no_customer = count($customer);
            $sms_count = strlen($request->c_msg_txt);

            $smsLength = strlen($request->c_msg_txt);
            ;

            $sms_count = (int) (($smsLength * $no_customer) / 160);
            $sms_count_round = ($smsLength * $no_customer) % 160;

            if ($sms_count_round != '0') {

                $tot_sms = $sms_count + 1;
            } else {
                $tot_sms = $sms_count;
            }

            $data['CME_SMS_COUNT'] = $tot_sms;


            $bmid = DB::table('CRM_MC_EVENTS')->insertGetId($data);


            foreach ($customer as $key => $value) {
                foreach ($value as $k => $v) {
                    DB::table('CRM_MC_EVENTS_PH_NOS')->insert(
                            ['CMEP_CME_ID' => $bmid, 'CMEP_PH_NO' => $v]
                    );
                }
            }

            if ($request->c_mc_category_values_id!=null) {

                foreach ($label_values as $key => $value) {
                    $cvdata['CMCV_CME_CMB_ID'] = $bmid;
                    $cvdata['CMCV_CCM_LABEL_NAME'] = $key;
                    $cvdata['CMCV_CCVM_VALUE'] = $value;
                    $cvdata['CMCV_CREATED_DT'] = Carbon::now();
                    $cvdata['CMCV_CREATED_BY'] = Auth::user()->biz_id;
                    $cvdata['CMCV_MODIFIED_DT'] = Carbon::now();
                    $cvdata['CMCV_MODIFIED_BY'] = Auth::user()->biz_id;
                    DB::table('CRM_MC_CAT_VALUES')->insert($cvdata);
                }
            }


            // } else {
            //     $customer = DB::table('CRM_CUSTOMER_MASTER')
            //             ->whereDate('CCM_DOB', '=', date('m-d'))
            //             ->get();
            //     $valid_till = date_create($request->c_valid_till);
            //     $valid_till_time = date_create($request->c_valid_till_time);
            //     $data['cme_ret_biz_id'] = Auth::user()->biz_id;
            //     $data['CME_SENDER_ID'] = $sender_id;
            //     $data['cme_msg_type'] = $request->c_message_type;
            //     $data['cme_msg_txt'] = $request->c_msg_txt;
            //     $data['cme_title'] = $request->c_message_title;
            //     $data['cme_msg_2b_sent'] = count($customer);
            //     $data['cme_ccm_gender'] = $request->c_gender_group;
            //     $data['cme_ccrl_cust_pros_type'] = $request->c_cust_pros_target;
            //     $data['cme_msg_status'] = 0;
            //     $data['cme_before_days'] = 0;
            //     $data['cme_schd_date'] = date_format($valid_till, "Y-m-d H:i:s");
            //     $data['cme_schd_time'] = date_format($valid_till_time, "H:i:s");
            //     $data['cme_created_dt'] = Carbon::now();
            //     $data['cme_created_by'] = Auth::user()->biz_id;
            //     $data['cme_modified_dt'] = Carbon::now();
            //     $data['cme_modified_by'] = Auth::user()->biz_id;
            //     $no_customer = count($customer);
            //     $sms_count = strlen($request->c_msg_txt);
            //     $data['CME_SMS_COUNT'] = $sms_count * $no_customer;
            //     DB::table('CRM_MC_EVENTS')->insert($data);
            // }

            \DB::commit();

            $success = true;
        } catch (\Exception $e) {
            $success = false;

            echo $e;

            print "Customer Not Saved.";

            \DB::rollback();
        }

        return response()->json(['success' => 'Customer Saved Successfully']);
    }

//    public function msgModerator(Request $request) {
//
//        $data['moderator'] = (new Message)->msgModerator();
//        return view('msg_moderator', $data);
//    }
//    
    public function msgModerator(Request $request) {
        $valid_till_date = date_create($request->till_date);
        $valid_till_time = date_create($request->till_time);
        $data['cme_schd_date'] = date_format($valid_till_date, "Y-m-d H:i:s");
        $data['cme_schd_time'] = date_format($valid_till_time, "H:i:s");
        $data['cme_msg_txt'] = $request->msg_content;
        $data['cme_msg_status'] = 1;
        $bmid = DB::table('CRM_MC_EVENTS')->where('CME_ID', $request->msg_id)->update($data);
        return response()->json(['success' => 'Messages Approved']);
    }

}

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

        if ($request->c_mc_category_values_id != null) {

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

            if ($request->c_cust_pros_target == '3') {
                $select_cust_pros = [1, 2];
            } else {
                $select_cust_pros = array($request->c_cust_pros_target);
            }


            $customer = array();
            $cust_1 = array();
            $cust_1_1 = array();  // Gender 
            $cust_2 = array();    // customer / Prospect in Gender

            $customer_1 = DB::table('CRM_CUSTOMER_MASTER')
                    ->join('CRM_CUST_RET_LINK', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID', '=', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID')
                    ->select('CCM_MOBILE_NO')
                    ->whereIn('CCM_GENDER', $select_gender)
                    ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                    ->get();



            foreach ($customer_1 as $key => $value) {
                $cust_1_1[] = $value->CCM_MOBILE_NO;
            }


            $customer_2 = DB::table('CRM_CUSTOMER_MASTER')
                    ->join('CRM_CUST_RET_LINK', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID', '=', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID')
                    ->select('CCM_MOBILE_NO')
                    ->WhereIn('CCRL_CUST_PROS_TYPE', $select_cust_pros)
                    ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                    ->get();


            if (count($customer_2) != "0") {
                foreach ($customer_2 as $key => $value) {

                    if (in_array($value->CCM_MOBILE_NO, $cust_1_1))
                        $cust_1[] = $value->CCM_MOBILE_NO;
                }
            }

            else {

                $cust_1 = $customer_1;
            }



            $mc_cat_val = explode(',', $request->c_mc_category_values_id);

            $link_id = DB::table('CRM_CUST_RET_LINK')->select('CCRL_LINK_ID', 'CCRL_CCM_CUST_ID')
                            ->where('CCRL_RET_BIZ_ID', Auth::user()->biz_id)->get();

            if (((count($link_id) != '0')) && ((count($mc_cat_val) != '0'))) {

                foreach ($link_id as $key => $value) {

                    $mc_cust_cat_val = DB::table('CRM_CUST_CAT_VALUES')->select('CCCV_VALUE')
                            ->where('CCCV_LINK_ID', $value->CCRL_LINK_ID)
                            ->get();

                    if ((count($mc_cust_cat_val) != '0')) {
                        foreach ($mc_cust_cat_val as $mc_cust_cat_val_key => $mc_cust_cat_val_value) {

                            $check_cat_value_array = explode(',', $mc_cust_cat_val_value->CCCV_VALUE);

                            foreach ($check_cat_value_array as $check_cat_value_array_key => $check_cat_value_array_value) {
                                foreach ($mc_cat_val as $k => $v) {

                                    if ($v == $check_cat_value_array_value) {

                                        $cust_2[] = DB::table('CRM_CUSTOMER_MASTER')
                                                        ->select('CCM_MOBILE_NO')
                                                        ->where('CCM_CUST_ID', $value->CCRL_CCM_CUST_ID)
                                                        ->first()->CCM_MOBILE_NO;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $cust_2 = array();
            }

            $cust_2 = array_unique($cust_2);


            if (count($cust_2) != "0") {
                foreach ($cust_2 as $key => $value) {
                    if (in_array($value, $cust_1))
                        $customer[] = $value;
                }
            }
            else {
                $customer = $cust_1;
            }


            $cust_no = array();

            if (count($customer) != "0") {
                foreach ($customer as $key => $value) {
                    $cust_no[] = $value;
                }
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
            $smsLength = strlen($request->c_msg_txt);
            $sms_count_160 = (int) ($smsLength / 160 );
            $sms_count_160_plus = $smsLength % 160;

            if ($sms_count_160_plus == '0') {
                $sms_count_160_plus = $sms_count_160_plus;
            } else {
                $sms_count_160_plus = 1;
            }

            $sms_count_round = $sms_count_160 + $sms_count_160_plus;

            $tot_sms = $sms_count_round * $no_customer;

            $data['CME_SMS_COUNT'] = $tot_sms;

            $bmid = DB::table('CRM_MC_EVENTS')->insertGetId($data);

            foreach ($customer as $key => $value) {
                DB::table('CRM_MC_EVENTS_PH_NOS')->insert(
                        ['CMEP_CME_ID' => $bmid, 'CMEP_PH_NO' => $value]
                );
            }

            if ($request->c_mc_category_values_id != null) {

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

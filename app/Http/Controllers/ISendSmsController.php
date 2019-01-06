<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Message;
use Softon\Sms\Facades\Sms;

class ISendSmsController extends Controller {

    protected $msg_id;
    protected $msg_type;

    protected function messageHistory($id, $customer_id) {

        $message_sheduling = DB::table('CRM_MC_EVENTS')
                ->where('CME_ID', $id)
                ->first();

        $mhdata['CMH_RET_BIZ_ID'] = $message_sheduling->CME_RET_BIZ_ID;
        $mhdata['CMH_CMCVH_ID'] = 0;
        $mhdata['CMH_MSG_TYPE'] = $message_sheduling->CME_MSG_TYPE;
        $mhdata['CMH_CUST_ID'] = $customer_id;
        $mhdata['CMH_TITLE'] = $message_sheduling->CME_TITLE;
        $mhdata['CMH_CONTENT'] = $message_sheduling->CME_MSG_TXT;
        $mhdata['CMH_CCM_GENDER'] = $message_sheduling->CME_CCM_GENDER;
        $mhdata['CMH_CCRL_CUST_PROS_TYPE'] = $message_sheduling->CME_CCRL_CUST_PROS_TYPE;
        $mhdata['CMH_CREATED_DT'] = Carbon::now();
        $mc_history_id = DB::table('CRM_MC_HISTORY')->insertGetId($mhdata);

        $category_value = DB::table('CRM_MC_CAT_VALUES')
                ->where('CMCV_CME_CMB_ID', $id)
                ->get();

        foreach ($category_value as $k => $cvalue) {
            $mc_ch['CMCV_ID'] = $mc_history_id;
            $mc_ch['CMCV_CCM_LABEL_NAME'] = $cvalue->CMCV_CCM_LABEL_NAME;
            $mc_ch['CMCV_CCVM_VALUE'] = $cvalue->CMCV_CCVM_VALUE;
            DB::table('CRM_MC_CAT_VALUES_HISTORY')->insert($mc_ch);
        }

        $data['message_sheduling'] = DB::table('CRM_MC_EVENTS')->where('CME_ID', '=', $id)->update(['CME_MSG_STATUS' => 2]);
    }

    protected function messageHistoryFailure($id, $reason, $biz_id, $customer_id) {

        $mhdata['CMH_ID'] = $id;
        $mhdata['CMHF_BIZ_ID'] = $biz_id;
        $mhdata['CMHF_CUST_ID'] = $customer_id;
        $mhdata['CMHF_Failure_Reason'] = $reason;
        $mhdata['CMHF_CREATED_DT'] = Carbon::now();
        DB::table('CRM_MC_HISTORY_FAILURE')->insert($mhdata);
    }

    protected function messageHistorySuccess($id, $response, $biz_id, $customer_id) {

        $res = explode('|', $response);
        $txn_msg = $res[2];

        $transaction_message = explode('-', $txn_msg);

        $transaction_id = $transaction_message[0];
        $message_id = $transaction_message[1];

        $mhdata['CMH_ID'] = $id;
        $mhdata['CMHS_TXN_ID'] = $transaction_id;
        $mhdata['CMHS_MSG_ID'] = $message_id;

        $mhdata['CMHS_BIZ_ID'] = $biz_id;
        $mhdata['CMHS_CUST_ID'] = $customer_id;
        $mhdata['CMHS_CREATED_DT'] = Carbon::now();
        DB::table('CRM_MC_HISTORY_SUCCESS')->insert($mhdata);
    }

    protected function createMessageHistory($error_response_code, $response_value, $id, $biz_id, $customer_id) {
        $this->messageHistory($id, $customer_id);

        if ($error_response_code == 1) {
            $this->messageHistoryFailure($id, $response_value, $biz_id, $customer_id);
        } else {
            $this->messageHistorySuccess($id, $response_value, $biz_id, $customer_id);
        }

        $message_sheduling = DB::table('CRM_MC_EVENTS')
                ->where('CME_ID', $id)
                ->first();

        smsUpdate($message_sheduling->CME_RET_BIZ_ID, 0, $message_sheduling->CME_SMS_COUNT);
    }

    protected function sendMessages($msg_id, $msg_type) {

        $pn = array();

        if ($msg_type == '0') {

            $sms_tpl = 'sms.events';
        } elseif ($msg_type == '1') {

            $sms_tpl = 'sms.birthday';
        } else {

            $sms_tpl = 'sms.anniversay';
        }

        $phone_numbers = DB::table('CRM_MC_EVENTS_PH_NOS')
                ->where('CMEP_CME_ID', $msg_id)
                ->get();

        foreach ($phone_numbers as $phone) {
            $pn[] = $phone->CMEP_PH_NO;
        }

        $phone_nos = array_unique($pn);

        $phone_nos_string = implode(',', $phone_nos);

        $msg = DB::table('CRM_MC_EVENTS')
                ->where('CME_ID', $msg_id)
                ->first();
        $msg_txt = $msg->CME_MSG_TXT;
        $msg_title = $msg->CME_TITLE;
        $sender_id = $msg->CME_SENDER_ID;
        $biz_id = $msg->CME_RET_BIZ_ID;

        $events = Sms::send($phone_nos, $sms_tpl, ['title' => $msg_title, 'msg' => $msg_txt], $sender_id)->response();

        $tmp = explode("\n", $events['response']);

        foreach ($tmp as $key => $value) {


            if ($value != null) {

                $res = explode('|', $value);

                $ph_no = preg_replace('/\s+/', '', $res[1]);

                $phone_no = substr($ph_no, 2);

                //dd($phone_no);

                $customer_id = DB::table('CRM_CUSTOMER_MASTER')
                                ->select('CCM_CUST_ID')
                                ->where('CCM_MOBILE_NO', $phone_no)
                                ->first()->CCM_CUST_ID;

                $this->createMessageHistory($events['status']['error'], $value, $msg->CME_ID, $biz_id, $customer_id);
            }
        }
    }

    protected function iSchedule(Request $request) {

        $send_now = DB::table('CRM_MC_EVENTS')->where('CME_ID', $request->msg_id)->first();

        $this->msg_id = $send_now->CME_ID;
        $this->msg_type = $send_now->CME_MSG_TYPE;

        if ($send_now->CME_MSG_TYPE == '0') {

            $this->sendMessages($this->msg_id, $this->msg_type);
        } elseif ($send_now->CME_MSG_TYPE == '1') {
            $this->sendMessages($this->msg_id, $this->msg_type);
        } else {
            $this->sendMessages($this->msg_id, $this->msg_type);
        }
    }

}

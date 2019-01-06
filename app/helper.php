<?php

use Illuminate\Support\Facades\Auth;

function linkInfoFromMobileNo($pid) {
    $link_info = DB::table('CRM_CUST_RET_LINK')
            ->select('CCRL_LINK_ID')
            ->join('CRM_CUSTOMER_MASTER', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID', '=', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID')
            ->where('CCM_MOBILE_NO', $pid)
            ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
            ->first();
    return $link_info;
}

function sms_balance() {

    return DB::table('users')
                    ->where([
                        ['biz_id', '=', Auth::user()->biz_id],
                        ['role_id', '<>', 1]
                    ])->first()->sms_balance;
}

function smsUpdate($ret_id, $sms_credit = 0, $sms_debit = 0) {

    $getSMS = DB::table('users')->where('biz_id', $ret_id)->first()->sms_balance;


    if ($sms_debit == 0) {

        $sms_update['sms_balance'] = $getSMS + $sms_credit;
    } else {

        $sms_update['sms_balance'] = $getSMS - $sms_debit;
    }

    DB::table('users')->where('biz_id', $ret_id)->where('role_id', '<>', 1)->update($sms_update);
}

function retailerList() {

    return DB::table('CRM_RETAILER_MASTER')->get();
}

function smsCount($msg_id) {

    $msg = DB::table('CRM_MC_EVENTS')->where('CME_ID', $msg_id)->first();

    $no_customer = $msg->CME_MSG_2B_SENT;

    $sms_count = strlen($msg->CME_MSG_TXT);

    return ($sms_count * $no_customer) . $sms_count;
}

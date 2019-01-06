<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Softon\Sms\Facades\Sms;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ScheduleMessage::class,
        Commands\ApproveMessage::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
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

        DB::table('CRM_MC_HISTORY')->insert($mhdata);
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

        $message = DB::table('CRM_MC_EVENTS')
                ->where('CME_ID', $msg_id)
                ->get();

        if (count($message) != 0) {
            foreach ($message as $msg) {
                $msg_txt = $msg->CME_MSG_TXT;
                $msg_title = $msg->CME_TITLE;
                $sender_id = $msg->CME_SENDER_ID;
                $biz_id = $msg->CME_RET_BIZ_ID;
                
                $events = Sms::send($phone_nos, $sms_tpl, ['title' => $msg_title, 'msg' => $msg_txt], $sender_id)->response();
                print_r($events);

              
            }
        }
    }

    protected function schedule(Schedule $schedule) {

        $campaign = DB::table('CRM_MC_EVENTS')->where('CME_MSG_STATUS', 1)->get();
        
        $iteration = 0;

        foreach ($campaign as $k => $v) {
            
            $day_tmp = strtotime($campaign[$iteration]->CME_SCHD_DATE);
            $time_tmp = explode(':', $campaign[$iteration]->CME_SCHD_TIME);

            $day = date('d', $day_tmp);
            $time = $time_tmp[0] . ':' . $time_tmp[1];

            $this->msg_id = $campaign[$iteration]->CME_ID;
            $this->msg_type = $campaign[$iteration]->CME_MSG_TYPE;
            

            if ($campaign[$iteration]->CME_MSG_TYPE == '0') {

                $schedule->call(function() {
                            $this->sendMessages($this->msg_id, $this->msg_type);
                        })->name('events')
                        ->withoutOverlapping()
                        ->monthlyOn($day, $time)
                        ->cron('* * * * * *');
            } elseif ($campaign[$iteration]->CME_MSG_TYPE == '1') {


                $schedule->call(function() {
                            $this->sendMessages($this->msg_id, $this->msg_type);
                        })->name('birthday')
                        ->withoutOverlapping()
                        ->dailyAt('10:00')
                        ->cron('* * * * * *');
            } else {
                $schedule->call(function() {
                            $this->sendMessages($this->msg_id, $this->msg_type);
                        })->name('marriage')
                        ->withoutOverlapping()
                        ->dailyAt('10:00')
                        ->cron('* * * * * *');
            }
            
            $iteration = $iteration + 1;
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}

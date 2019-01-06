<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Softon\Sms\Facades\Sms;  

class ScheduleMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Schedule:Message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

  


    protected function messageHistory($id) {

        $message_sheduling = DB::table('CRM_MC_EVENTS')
                ->where('CME_ID', $id)
                ->first();

        $mhdata['CMH_RET_BIZ_ID'] = $message_sheduling->CME_RET_BIZ_ID;
        $mhdata['CMH_CMCVH_ID'] = 0;
        $mhdata['CMH_MSG_TYPE'] = $message_sheduling->CME_MSG_TYPE;

        $mhdata['CMH_TITLE'] = $message_sheduling->CME_TITLE;
        $mhdata['CMH_CONTENT'] = $message_sheduling->CME_MSG_TXT;
        $mhdata['CMH_CCM_GENDER'] = $message_sheduling->CME_CCM_GENDER;
        $mhdata['CMH_CCRL_CUST_PROS_TYPE'] = $message_sheduling->CME_CCRL_CUST_PROS_TYPE;
        $mhdata['CMH_CREATED_DT'] = Carbon::now();

        DB::table('CRM_MC_HISTORY')->insert($mhdata);
        $data['message_sheduling'] = DB::table('CRM_MC_EVENTS')->where('CME_ID', '=', $id)->update(['CME_MSG_STATUS' => 2]);
    }

    protected function messageHistoryFailure($id, $reason,$biz_id) {

        $mhdata['CMH_ID'] = $id;
        $mhdata['CMHF_BIZ_ID'] = $biz_id;
        $mhdata['CMHF_Failure_Reason'] = $reason;
        $mhdata['CMHF_CREATED_DT'] = Carbon::now();
        DB::table('CRM_MC_HISTORY_FAILURE')->insert($mhdata);
    }

    protected function messageHistorySuccess($id,$biz_id) {
        $mhdata['CMH_ID'] = $id;
        $mhdata['CMHS_BIZ_ID'] = $biz_id;
        $mhdata['CMHS_CREATED_DT'] = Carbon::now();
        DB::table('CRM_MC_HISTORY_SUCCESS')->insert($mhdata);
    }

    protected function createMessageHistory($error_response_code, $error_response_value, $id,$biz_id) {
        $this->messageHistory($id);

        if ($error_response_code == 1) {
            $this->messageHistoryFailure($id, $error_response_value,$biz_id);
        } else {
            $this->messageHistorySuccess($id,$biz_id);
        }

        $message_sheduling = DB::table('CRM_MC_EVENTS')
                ->where('CME_ID', $id)
                ->first();

        smsUpdate($message_sheduling->CME_RET_BIZ_ID, 0, $message_sheduling->CME_SMS_COUNT);
    }

    protected function sendWishes($phone_numbers) {

        $message = DB::table('CRM_MC_EVENTS')->where('CME_MSG_STATUS', 1)->get();

        if (count($message) != 0) {
            foreach ($message as $msg) {
                $msg_txt = $msg->CME_MSG_TXT;
                $msg_title = $msg->CME_TITLE;

                foreach ($phone_numbers as $phone) {

                    $wishes = Sms::send([$phone], 'sms.anniversay', ['title' => $msg_title, 'msg' => $msg_txt,])->response();
                    $this->createMessageHistory($wishes['status']['error'], $events['response'], $msg->CME_ID);
                }
            }
        }
    }

    protected function sendMessages() {

    $phone_numbers = DB::table('CRM_CUSTOMER_MASTER')
                            ->leftJoin('crm_mc_events as a', 'a.CME_CCM_GENDER', '=', 'CRM_CUSTOMER_MASTER.CCM_GENDER')
                            ->leftJoin('crm_mc_events as b', 'CRM_CUSTOMER_MASTER.CCM_CUST_PROS_TYPE', '=', 'b.CME_CCRL_CUST_PROS_TYPE')
                            ->select('CCM_MOBILE_NO', 'CCM_FIRST_NAME')
                            ->whereNotNull('CCM_MOBILE_NO')
                            ->get();

                    $pn = array();
                    foreach ($phone_numbers as $phone) {
                        $pn[] = $phone->CCM_MOBILE_NO;
                    }

                    $phone_numbers = array_unique($pn);

        $message = DB::table('CRM_MC_EVENTS')->where('CME_MSG_STATUS', 1)->get();

        if (count($message) != 0) {
            foreach ($message as $msg) {
                $msg_txt = $msg->CME_MSG_TXT;
                $msg_title = $msg->CME_TITLE;
                $sender_id = $msg->CME_SENDER_ID;
                $biz_id = $msg->CME_SENDER_ID;
                
                foreach ($phone_numbers as $phone) {
                $events = Sms::send([$phone], 'sms.anniversay', ['title' => $msg_title, 'msg' => $msg_txt,],$sender_id)->response();

                dd($events);
                    $this->createMessageHistory($events['status']['error'], $events['response'], $msg->CME_ID,$biz_id);
                }
            }
        }
    }

    // protected function sendMessages($phone_numbers){
    //       $message = DB::table('CRM_MC_EVENTS')->where('CME_MSG_STATUS', 1)->get();
    //                 if (count($message) != 0) {
    //                     foreach ($message as $msg) {
    //                         $msg_txt = $msg->CME_MSG_TXT;
    //                         $msg_title = $msg->CME_TITLE;
    //                         $events = Sms::send([$phone_numbers], 'sms.anniversay', ['title' => $msg_title, 'msg' => $msg_txt,])->response();
    //                         $this->createMessageHistory($events['status']['error'],$events['response'],$msg->CME_ID);
    //                     }
    //                 }
    // }


    protected function wishes(Schedule $schedule) {
        $schedule->call(function() {

                    $phone_numbers = DB::table('CRM_CUSTOMER_MASTER')
                            ->select('CCM_MOBILE_NO')
                            ->whereDay('CCM_DOB', date("d"))
                            ->whereMonth('CCM_DOB', date("m"))
                            ->get();
                    $pn = array();

                    foreach ($phone_numbers as $phone) {
                        //linkInfoFromMobileNo($phone);
                        $pn[] = $phone->CCM_MOBILE_NO;
                    }

                    $this->sendWishes($pn);
                })->name('Birthday Wishes')
                ->withoutOverlapping()
                ->cron('* * * * * *');
    }

    public function handle()
    {

        echo "hi";
     
     
     
     //$scheduled_sms = Sms::send(['9944514048'],'sms.test',['user'=>'Kali','token'=>'tkn boom1',])->response();  
     
     
     
     //DB::table('categories')->insert($data);
     //return redirect('sms/status');
    }

}

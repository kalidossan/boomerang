<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller {

        public function profile(){
        return view('profile');     
    }


    public function bizId(Request $request){
        $data['biz_id'] = $request->retailer;
        DB::table('users')->where('id',Auth::user()->id)->update($data);
        return response()->json($data);
    }
    
    public function index(){ 
     

        if(Auth::user()->role_id!='1'){
            return redirect('retailer');
        }

        $data['plan'] = DB::table('CRM_PLAN_ENTRY_MASTER')->get();
        $data['payment_for'] = DB::table('CRM_RET_PAYMENT_FOR')->get();
        $data['retailers'] = DB::table('CRM_RETAILER_MASTER')->get();

        $data['message_sheduling'] = DB::table('CRM_MC_EVENTS')
                                    ->join('users', 'users.biz_id', '=', 'CRM_MC_EVENTS.CME_RET_BIZ_ID')
                                    ->where('CME_MSG_STATUS',0)
                                    ->where('users.role_id','<>',1)
                                    ->orderBy('CRM_MC_EVENTS.CME_SCHD_DATE','desc')
                                    ->get();
        
        $data['work_order'] = DB::table('CRM_WORK_ORDER')->where('CWO_FINAL_PND_AMT','<>',0)->get();

        $data['plan_subscription'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',0)->get();
        $data['plan_sms'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',2)->get();
        $data['plan_renewal'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',1)->get();
        $data['payment_mode'] = DB::table('CRM_RET_PAYMENT_MODE')->get();
        $data['business_categories'] = DB::table('CRM_BIZCAT_MASTER')->where('CBM_Category_Status',1)->get();

        $data['xl_customer_upload'] = DB::table('CRM_CUSTOMER_UPLOAD')->where('CCU_STATUS',0)->get();

        
  
        return view('admin',$data);      
    }

   
    
    public function plan_amount(Request $request){
        $data['plan_amount'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('cpe_plan_id',$request->plan_amount)->get();
        return response()->json($data);
    }

    public function store(Request $request) {

        \DB::beginTransaction();
        try {
            $data['CPE_PLAN_TYPE'] = $request->plan_entry;
            $data['CPE_AMOUNT'] = $request->plan_entry_amount;
            $data['CPE_SMS_ALLOTED'] = $request->sms_count;
            $data['CPE_TENURE_MONTHS'] = $request->tennure;
 
            $data['CPE_TENURE_DAYS'] = $request->tennure_in_days;
            $data['CPE_DISPLAY_TYPE'] = $request->pub_prv_access;
            $data['CPE_PLAN_NAME'] = $request->plan_name;
            $data['cpe_created_dt'] = Carbon::now();
            $data['cpe_created_by'] = Auth::user()->id;
            $data['cpe_modified_dt'] = Carbon::now();
            $data['cpe_modified_by'] = Auth::user()->id;
            $data['cpe_active_status'] = 1;
            DB::table('crm_plan_entry_master')->insert($data);

            \DB::commit();

            $success = true;
        } catch (\Exception $e) {
            $success = false;

            echo $e;

            print "Plan Not Saved.";

            \DB::rollback();
        }



        return response()->json(['success' => 'Plan Saved Successfully']);
    }

}

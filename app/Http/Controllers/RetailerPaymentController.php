<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RetailerPaymentController extends Controller
{
     public function retailerPayment()
    {
      $data['plan_sms'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',2)->get();
      $data['plan_renewal'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',1)->get();
      $data['plan_subscription'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',0)->get();
      $data['payment_mode'] = DB::table('CRM_RET_PAYMENT_MODE')->get();
      $data['payment_for'] = DB::table('CRM_RET_PAYMENT_FOR')->get();
      $data['work_order'] = DB::table('CRM_WORK_ORDER')->get();

      return view('retailer_payment',$data);
    }
    
         public function retailerPaymentFor(Request $request)
         {

            $services = $request->payment_for_values; 

            $payment_type = $request->payment_type;  
             
           // $woid = DB::table('CRM_WORK_ORDER_PAYMENTS')->where('CWO_RET_BIZ_ID',$request->biz_id)->first()->CWO_RET_BIZ_ID;
            $data['CWO_RET_BIZ_ID'] = $request->biz_id;
            $data['CWO_CPE_ACT_AMT'] = $request->plan_amount_actual;            
            $data['CWO_CPE_AMOUNT'] = $request->plan_amount;
            $data['CWO_FINAL_PND_AMT'] = ($request->plan_amount_actual) - ($request->plan_amount);
            $data['CWO_CREATED_DT'] = Carbon::now();
            $data['CWO_CREATED_BY'] = Auth::user()->id;;
            $data['CWO_MODIFIED_DT'] = Carbon::now();
            $data['CWO_MODIFIED_BY'] = Auth::user()->id;
  
            $wid = DB::table('CRM_WORK_ORDER')->insertGetId($data);

            $plan['subscription_plan'] = $request->plan_amount_subscription;
            $plan['renewal_plan'] = $request->plan_amount_renewal;
            $plan['sms_plan'] = $request->plan_amount_sms;
            
            foreach($plan as $key=>$value){
                if($value!=='0'){
                if($key=='subscription_plan'){
                  $wdata['CWOD_CPE_PLAN_TYPE'] = 1;
                  $wdata['CWOD_CPE_PLAN_NAME'] = $request->plan_name_subscription;
                  $wdata['CWOD_CPE_AMOUNT'] = $value;         
                }
                elseif($key=='renewal_plan'){
                  $wdata['CWOD_CPE_PLAN_TYPE'] = 2;
                  $wdata['CWOD_CPE_PLAN_NAME'] = $request->plan_name_renewal;
                   $wdata['CWOD_CPE_AMOUNT'] = $value;   
                    
                }
                else{                   
                  $wdata['CWOD_CPE_PLAN_TYPE'] = 3;
                  $wdata['CWOD_CPE_PLAN_NAME'] = $request->plan_name_sms;
                   $wdata['CWOD_CPE_AMOUNT'] = $value;                      
                }
                
            $wdata['CWOD_CWO_WO_ID'] = $wid;
           
            $wdata['CWOD_CREATED_DT'] = Carbon::now();
            $wdata['CWOD_CREATED_BY'] = Auth::user()->id;
            $wdata['CWOD_MODIFIED_DT'] = Carbon::now();
            $wdata['CWOD_MODIFIED_BY'] = Auth::user()->id;
            

            DB::table('CRM_WORK_ORDER_DETAILS')->insert($wdata);
            }
          }
            

            $datap['CWOP_CWO_WO_ID'] = $wid;
            $datap['CWOP_AMOUNT_PAID'] = $request->plan_amount;
            $datap['CWOP_PAY_REF'] = $request->payment_reference_no;
            $datap['CWOP_PAYMENT_MODE'] = $request->payment_mode;
            $datap['CWOP_BANK_NAME'] = $request->bank;
            $datap['CWOP_PAY_DATE'] = Carbon::now();
            $datap['CWOP_PND_AMOUNT'] = 0;
            $datap['CWOP_INT_VER'] = $request->payment_verification;
            $datap['CWOP_SALES_PERSON'] = 0;
      
            $datap['cwop_created_dt'] = Carbon::now();
            $datap['cwop_created_by'] = 0;
            $datap['cwop_modified_dt'] = Carbon::now();
            $datap['cwop_modified_by'] = 0;
  
            $pid = DB::table('CRM_WORK_ORDER_PAYMENTS')->insertGetId($datap);
     
            $pdata['CWOPL_PAYMENT_ID'] = $pid;
            $pdata['CWOPL_CWO_WO_ID'] = $wid;
            $pdata['CWOPL_AMOUNT_PAID'] = $request->plan_amount;
            $pdata['CWOPL_PAY_REF'] = $request->payment_reference_no;
            $pdata['CWOPL_PAYMENT_MODE'] = $request->payment_mode;
            $pdata['CWOPL_BANK_NAME'] = $request->bank;
            $pdata['CWOPL_PAY_DATE'] = Carbon::now();
            $pdata['CWOPL_PND_AMOUNT'] = 0;
            $pdata['CWOPL_INT_VER'] = $request->payment_verification;
            $pdata['CWOPL_SALES_PERSON'] = 0;
      
            $pdata['cwopl_created_dt'] = Carbon::now();
            $pdata['cwopl_created_by'] = 0;
            $pdata['cwopl_modified_dt'] = Carbon::now();
            $pdata['cwopl_modified_by'] = 0;
  
            DB::table('CRM_WORK_ORDER_PAY_LOG')->insert($pdata);

            if($request->plan_name_sms!='0'){

            $sms['CSL_SMS_Purchased'] = DB::table('CRM_PLAN_ENTRY_MASTER')->select()->where('CPE_PLAN_NAME',$request->plan_name_sms)->first()->CPE_SMS_ALLOTED;

            $sms['CSL_RET_BIZ_ID'] = $request->biz_id;

            DB::table('CRM_SMS_REPORT')->insert($sms);
            
            smsUpdate($request->biz_id,$sms['CSL_SMS_Purchased'],0);
            
            }

        $data['plan_subscription'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',0)->get();
        $data['plan_sms'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',2)->get();
        $data['plan_renewal'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('CPE_PLAN_TYPE',1)->get();
        $data['payment_mode'] = DB::table('CRM_RET_PAYMENT_MODE')->get();
            //return response()->json($data);
            
            return view('retailer_payment',$data);  

         }
    
    

    public function payment(Request $request)
    {
            $data['CWOP_CWO_WO_ID'] = $request->txnid;
            $data['CWOP_AMOUNT_PAID'] = $request->amount;
            $data['CWOP_PAY_REF'] = $request->payuMoneyId;
            $data['CWOP_BANK_NAME'] = $request->amount;
            $data['CWOP_PAY_DATE'] = Carbon::now();
            $data['CWOP_PND_AMOUNT'] = 0;
            $data['CWOP_INT_VER'] = "payumoney";
            $data['CWOP_SALES_PERSON'] = 0;
      
            $data['cwop_created_dt'] = Carbon::now();
            $data['cwop_created_by'] = 0;
            $data['cwop_modified_dt'] = Carbon::now();
            $data['cwop_modified_by'] = 0;
  
            $pid = DB::table('CRM_WORK_ORDER_PAYMENTS')->insertGetId($data);
     
            $pdata['CWOPL_PAYMENT_ID'] = $pid;
            $pdata['CWOPL_CWO_WO_ID'] = $request->txnid;
            $pdata['CWOPL_AMOUNT_PAID'] = $request->amount;
            $pdata['CWOPL_PAY_REF'] = $request->payuMoneyId;
            $pdata['CWOPL_BANK_NAME'] = $request->amount;
            $pdata['CWOPL_PAY_DATE'] = Carbon::now();
            $pdata['CWOPL_PND_AMOUNT'] = 0;
            $pdata['CWOPL_INT_VER'] = "payumoney";
            $pdata['CWOPL_SALES_PERSON'] = 0;
      
            $pdata['cwopl_created_dt'] = Carbon::now();
            $pdata['cwopl_created_by'] = 0;
            $pdata['cwopl_modified_dt'] = Carbon::now();
            $pdata['cwopl_modified_by'] = 0;
  
            DB::table('CRM_WORK_ORDER_PAY_LOG')->insert($pdata);

       return view ('payment_success',$data);
    }
   
    
}

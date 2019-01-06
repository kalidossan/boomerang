<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Softon\Indipay\Facades\Indipay;  

class PaymentController extends Controller
{
     public function payment(request $request) {
         
             $txnid = $request->session()->all();
            // dd($txnid['data']['plan_amount']);
             if(isset($txnid['data'])){
                  $parameters = [
            'txnid' => $txnid['data']['id'],
            'firstname' => 'first_name',
            'email' => 'kalidossan.s@gmail.com',
            'phone' => '9944514048',
            'productinfo' => 'Boomerang',
            'service_provider' => 'payu_paisa',
            'amount' => $txnid['data']['plan_amount'],
      ];
                 
             }
             else{
                 
                  $parameters = [
            'txnid' => "93823894238",
            'firstname' => 'first_name',
            'email' => 'kalidossan.s@gmail.com',
            'phone' => '9944514048',
            'productinfo' => 'Boomerang',
            'service_provider' => 'payu_paisa',
            'amount' => "9842",
      ];
                 
             }
            

      // gateway = CCAvenue / PayUMoney / EBS / Citrus / InstaMojo

      // $order = Indipay::gateway('PayUMoney')->prepare($parameters);
      // return Indipay::process($order);
      
      $order = Indipay::prepare($parameters);
      //dd($order);
      return Indipay::process($order);
       
    
    }

     public function makePayment()
    {
      return view('make_payment');
    }

    public function paymentsuccess(Request $request)
    {
       $response = Indipay::response($request);
      // dd($response);
       
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
    public function paymentfailure(Request $request)
    {
        
        
         $response = Indipay::response($request);
         
            $data['CWOP_CWO_WO_ID'] = $request->txnid;
            $data['CWOP_AMOUNT_PAID'] = 0;
            $data['CWOP_PAY_REF'] = $request->payuMoneyId;
            $data['CWOP_BANK_NAME'] = $request->amount;
            $data['CWOP_PAY_DATE'] = Carbon::now();
            $data['CWOP_PND_AMOUNT'] = $request->amount;
            $data['CWOP_INT_VER'] = "payumoney";
            $data['CWOP_SALES_PERSON'] = 0;
      
            $data['cwop_created_dt'] = Carbon::now();
            $data['cwop_created_by'] = 0;
            $data['cwop_modified_dt'] = Carbon::now();
            $data['cwop_modified_by'] = 0;
  
            $pid = DB::table('CRM_WORK_ORDER_PAYMENTS')->insertGetId($data);
     
            $pdata['CWOPL_PAYMENT_ID'] = $pid;
            $pdata['CWOPL_CWO_WO_ID'] = $request->txnid;
            $pdata['CWOPL_AMOUNT_PAID'] = 0;
            $pdata['CWOPL_PAY_REF'] = $request->payuMoneyId;
            $pdata['CWOPL_BANK_NAME'] = $request->amount;
            $pdata['CWOPL_PAY_DATE'] = Carbon::now();
            $pdata['CWOPL_PND_AMOUNT'] = $request->amount;
            $pdata['CWOPL_INT_VER'] = "payumoney";
            $pdata['CWOPL_SALES_PERSON'] = 0;
      
            $pdata['cwopl_created_dt'] = Carbon::now();
            $pdata['cwopl_created_by'] = 0;
            $pdata['cwopl_modified_dt'] = Carbon::now();
            $pdata['cwopl_modified_by'] = 0;
  
            DB::table('CRM_WORK_ORDER_PAY_LOG')->insert($pdata);
//         dd($response);
//     $parameters = [     "mihpayid" => "403993715518329926",
//  "mode" => "CC",
//  "status" => "failure",
//  "unmappedstatus" => "failed",
//  "key" => "rjQUPktU",
//  "txnid" => "123322123322",
//  "amount" => "100.0",
//  "addedon" => "2018-09-22 15:43:30",
//  "productinfo" => "room2",
//  "firstname" => "kalidossan",
//  "lastname" => null,
//  "address1" => null,
//  "address2" => null,
//  "city" => null,
//  "state" => null,
//  "country" => null,
//  "zipcode" => null,
//  "email" => "kalidossan.s@gmail.com",
//  "phone" => "9944514048",
//  "udf1" => null,
//  "udf2" => null,
//  "udf3" => null,
//  "udf4" => null,
//  "udf5" => null,
//  "udf6" => null,
//  "udf7" => null,
//  "udf8" => null,
//  "udf9" => null,
//  "udf10" => null,
//  "hash" => "e3a20a40eec7f59f91f72e9411a69670f72a87f77706af45e3c9d3f6f48c9ea166eee141e79d4a1ed9d21604220476992e64268f7387c4e75dcff04b23343265",
//  "field1" => "925431",
//  "field2" => "705859",
//  "field3" => "20180922",
//  "field4" => "MC",
//  "field5" => "493100710461",
//  "field6" => "45",
//  "field7" => "1",
//  "field8" => "3DS",
//  "field9" => "Verification of Secure Hash Failed: E700 -- Unspecified Failure -- Unknown Error -- Unable to be determined--E500",
//  "PG_TYPE" => "AXISPG",
//  "encryptedPaymentId" => "1E852CD038EB7906A7B91589FF76EB07",
//  "bank_ref_num" => "925431",
//  "bankcode" => "CC",
//  "error" => "E500",
//  "error_Message" => "Bank failed to authenticate the customer",
//  "name_on_card" => "payu",
//  "cardnum" => "512345XXXXXX2346",
//  "cardhash" => "This field is no longer supported in postback params.",
// // "amount_split" => "{"PAYU":"100.0"}",
//  "payuMoneyId" => "1111841623",
//  "discount" => "0.00",
//  "net_amount_debit" => "0.00"];
       return view ('payment_failure',$data);
    }
    
}

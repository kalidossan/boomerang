<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Softon\Indipay\Facades\Indipay;
class RetailerRegistrationController extends Controller {
    public function index() {

        $data['plan'] = DB::table('CRM_PLAN_ENTRY_MASTER')->get();
        return view("retailer_sign_up", $data);
    }

    public function retailer(Request $request) {


        $mobile_no = $request->mobile; 


        $data['retailer'] = DB::table('CRM_RETAILER_MASTER')->where('RET_MOBILE_NO', $mobile_no)->first();


        if ($data['retailer'] == null) {
            $data['is_new'] = 'y';
            return response()->json($data);
        } else {
            $data['is_new'] = 'n';   



            $biz_id = DB::table('CRM_RETAILER_MASTER')->where('RET_MOBILE_NO',$mobile_no )->first()->RET_BIZ_ID;
           

         $data['sender_id']  = DB::table('CRM_SENDER_ID')->where('CSI_RET_BIZID',$biz_id )->first()->CSI_SENDER_ID;         

            return response()->json($data);
        }

    }




    public function registration(Request $request) {

        $mobile_no = $request->reg_mobile; 

        $retailer  = DB::table('CRM_RETAILER_MASTER')->where('RET_MOBILE_NO', $mobile_no)->first();

               if (Auth::check()) {
                $data['ret_created_by'] = Auth::user()->id;
                $data['ret_modified_by'] = Auth::user()->id;
                $wo_data['cwo_created_by'] = Auth::user()->id;
                $wo_data['cwo_modified_by'] = Auth::user()->id;
             }

        if ($retailer == null) {

        \DB::beginTransaction();
        try {

            $data['RET_BIZ_NAME'] = $request->reg_biz_name;
            $data['RET_FIRST_NAME'] = $request->first_name;
            $data['RET_LAST_NAME'] = $request->last_name;
            $data['RET_EMAIL_ID'] = $request->mail;
            $data['RET_MOBILE_NO'] = $request->reg_mobile;
            $data['RET_FB_ID'] = $request->fb_id;
            $data['RET_INSTA_ID'] = $request->instagram_id;
            $dos = date_create($request->dos);
            $data['RET_BIZ_START_DT'] = date_format($dos, "Y-m-d H:i:s");
            $data['RET_BIZ_CATEGORY'] = $request->biz_category;
            $data['RET_GST_NUMBER'] = $request->gst_no;
            $data['RET_PINCODE'] = $request->pincode;
            $data['RET_STREET_NAME'] = $request->street;
            $data['RET_AREA_NAME'] = $request->area;
            $data['RET_CITY_NAME'] = $request->city;
            $data['RET_STATE_NAME'] = $request->state;
            $data['RET_FLAT_NO'] = $request->flat_no;
            $data['RET_CREATED_DT'] = Carbon::now();
            $data['RET_MODIFIED_DT'] = Carbon::now();
            $data['RET_ACTIVE_STATUS'] = 1;

            $id = DB::table('CRM_RETAILER_MASTER')->insertGetId($data);
            $wo_data['CWO_CPE_AMOUNT'] = $request->plan_amount;
            $wo_data['CWO_RET_BIZ_ID'] = $id;
            $wo_data['CWO_CPE_ACT_AMT'] = $request->plan_amount;
            $wo_data['CWO_FINAL_PND_AMT'] = 0;
            $wo_data['CWO_CREATED_DT'] = Carbon::now();
            $wo_data['CWO_MODIFIED_DT'] = Carbon::now();
            $wo_id = DB::table('CRM_WORK_ORDER')->insertGetId($wo_data);

            $wod_data['CWOD_CWO_WO_ID'] = $wo_id;
            $wod_data['CWOD_CPE_PLAN_TYPE'] = $request->plan_type;
            $wod_data['CWOD_CPE_PLAN_NAME'] = $request->plan_name;
            $wod_data['CWOD_CPE_AMOUNT'] = $request->plan_amount;
            $wod_data['CWOD_CREATED_DT'] = Carbon::now();
            $wod_data['CWOD_CREATED_BY'] = $id;
            $wod_data['CWOD_MODIFIED_DT'] = Carbon::now();
            $wod_data['CWOD_MODIFIED_BY'] = $id;

            $wod_id = DB::table('CRM_WORK_ORDER_DETAILS')->insertGetId($wod_data);
            
            $sdata['CSI_TEMP_SENDERID'] = $request->sender_id;
            $sdata['CSI_SENDER_ID'] = $request->sender_id;

            $sdata['CSI_RET_BIZID'] = $id;
            $sdata['CSI_SENDERID_STATUS'] = 1;
            DB::table('CRM_SENDER_ID')->insert($sdata);

            $udata['name']  = $request->first_name;
            $udata['email'] = $request->reg_mobile;
            $udata['biz_id'] = $id;
            $udata['password'] = \Hash::make('password');
            $udata['role_id'] = 5;
            DB::table('users')->insert($udata);


            \DB::commit();

            $success = true;
        } catch (\Exception $e) {
            $success = false;


            print "Retailer Not Saved.";

            \DB::rollback();
        }

        $data['id'] = $wo_id;
        $data['plan_amount'] = $request->plan_amount;

         if (Auth::check()) {
            return response()->json($data);
         }
         else{
            return redirect('makePayment')->with('data', $data);
         }


         $data['success'] = 'Retailer Saved Successfully';

         return response()->json($data);



        }
        else{

            $data['RET_BIZ_NAME'] = $request->reg_biz_name;
            $data['RET_FIRST_NAME'] = $request->first_name;
            $data['RET_LAST_NAME'] = $request->last_name;
            $data['RET_EMAIL_ID'] = $request->mail;
            $data['RET_FB_ID'] = $request->fb_id;
            $data['RET_INSTA_ID'] = $request->instagram_id;
            $dos = date_create($request->dos);
            $data['RET_BIZ_START_DT'] = date_format($dos, "Y-m-d H:i:s");
            $data['RET_BIZ_CATEGORY'] = $request->biz_category;
            $data['RET_GST_NUMBER'] = $request->gst_no;
            $data['RET_PINCODE'] = $request->pincode;
            $data['RET_STREET_NAME'] = $request->street;
            $data['RET_AREA_NAME'] = $request->area;
            $data['RET_CITY_NAME'] = $request->city;
            $data['RET_FLAT_NO'] = $request->flat_no;
            $data['RET_STATE_NAME'] = $request->state;
            $data['RET_CREATED_DT'] = Carbon::now();
            $data['RET_MODIFIED_DT'] = Carbon::now();
            $data['RET_ACTIVE_STATUS'] = 1;

            DB::table('CRM_RETAILER_MASTER')->where('RET_MOBILE_NO',$mobile_no )->update($data);
            $biz_id = DB::table('CRM_RETAILER_MASTER')->where('RET_MOBILE_NO',$mobile_no )->first()->RET_BIZ_ID;
            $sdata['CSI_SENDER_ID'] = $request->sender_id;
            DB::table('CRM_SENDER_ID')->where('CSI_RET_BIZID',$biz_id )->update($sdata);
            $data['success'] = 'Retailer Updated Successfully';
            return response()->json($data);


        }
        
    }

    public function show(Request $request) {

        $mobile_no = $request->mobile;

        $data['retailer'] = DB::table('CRM_RETAILER_MASTER')->where('RET_MOBILE_NO', $mobile_no)->first();

        if ($data['retailer'] == null) {
            $data['is_new'] = 'y';
            return response()->json($data);
        } else {
            $data['is_new'] = 'n';



            $data['work_order'] = DB::table('CRM_WORK_ORDER')->where('CWO_FINAL_PND_AMT','<>',0)
                                ->where('CWO_RET_BIZ_ID', $data['retailer']->RET_BIZ_ID)->get();

            $pending_amount = DB::table('CRM_WORK_ORDER')->where('CWO_RET_BIZ_ID', $data['retailer']->RET_BIZ_ID)->get();

            $ret_pending_amnt = 0;

            foreach ($pending_amount as $pending) {
                $ret_pending_amnt += $pending->CWO_FINAL_PND_AMT;
            }

            if ($ret_pending_amnt == 0) {
                
            } else {
                $data['pending_amount'] = $ret_pending_amnt;
            }

            return response()->json($data);
        }
    }

}

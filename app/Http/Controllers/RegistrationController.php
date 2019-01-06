<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Carbon\Carbon;
/*
class RegistrationController extends Controller {

    public function store(Request $request) {


        $mobile_no = $request->mobile;

        $customer = DB::table('CRM_CUSTOMER_MASTER')->where('CCM_MOBILE_NO',$mobile_no)->first();

          if ($customer== null) {

        \DB::beginTransaction();
        try {
            $data['ccm_first_name'] = $request->first_name;
            $data['ccm_last_name'] = $request->last_name;
            $data['ccm_email_id'] = $request->mail;
            $data['ccm_mobile_no'] = $request->reg_mobile;
            $dob = date_create($request->dob);
            $doa = date_create($request->doa);
            $data['ccm_dob'] = date_format($dob, "Y-m-d H:i:s");
            $data['ccm_doa'] = date_format($doa, "Y-m-d H:i:s");
            $data['ccm_gender'] = $request->gender;
            $data['ccm_created_dt'] = Carbon::now();
            $data['ccm_created_by'] = Auth::user()->id;
            $data['ccm_modified_dt'] = Carbon::now();
            $data['ccm_modified_by'] = Auth::user()->id;
            $data['ccm_active_status'] = 1;
            $id = DB::table('crm_customer_master')->insertGetId($data);

            $ldata['ccrl_ccm_cust_id'] = $id;
            $ldata['ccrl_ret_biz_id'] = Auth::user()->id;
            $ldata['ccrl_optout_status'] = 1;
            $ldata['ccrl_cust_pros_type'] = $request->cust_pros;
            $ldata['ccrl_created_dt'] = Carbon::now();
            $ldata['ccrl_created_by'] = Auth::user()->id;
            $ldata['ccrl_modified_dt'] = Carbon::now();
            $ldata['ccrl_modified_by'] = Auth::user()->id;
            $id1 = DB::table('crm_cust_ret_link')->insertGetId($ldata);


            $exp = date_create($request->exp_dte);
            $rdata['car_ccrl_link_id'] = $id1;
            $rdata['car_req_text_status'] = 0;
            $rdata['car_request_dt'] = date_format($exp, "Y-m-d H:i:s");
            $rdata['car_request_text'] = $request->arequest;
            $rdata['car_created_dt'] = Carbon::now();
            $rdata['car_created_by'] = Auth::user()->id;
            $rdata['car_modified_dt'] = Carbon::now();
            $rdata['car_modified_by'] = Auth::user()->id;
            $id2 = DB::table('crm_add_request')->insertGetId($rdata);


            $vdata['ccvd_ccrl_link_id'] = $id2;
            $vdata['ccvd_visit_flag'] = 1;
            $vdata['ccvd_created_dt'] = Carbon::now();
            $vdata['ccvd_created_by'] = Auth::user()->id;       
            DB::table('crm_cust_visit_details')->insert($vdata);

            $cdata['ccd_ccrl_link_id'] = $id2;
            $cdata['ccd_label_name'] = "";
            $cdata['ccd_created_dt'] = Carbon::now();
            $cdata['ccd_created_by'] = Auth::user()->id;
            $cdata['ccd_modified_dt'] = Carbon::now();
            $cdata['ccd_modified_by'] = Auth::user()->id;
            $id3 = DB::table('crm_categories_details')->insertGetId($cdata);

            $cvdata['ccvd_ccd_id'] = $id3;
            $cvdata['ccvd_value'] = "";
            $cvdata['ccvd_created_dt'] = Carbon::now();
            $cvdata['ccvd_created_by'] = Auth::user()->id;
            $cvdata['ccvd_modified_dt'] = Carbon::now();
            $cvdata['ccvd_modified_by'] = Auth::user()->id;
            DB::table('crm_cat_values_details')->insert($cvdata);

            \DB::commit();

            $success = true;
        } catch (\Exception $e) {
            $success = false;

            echo $e;

            print "Customer Not Saved.";

            \DB::rollback();
        }


        return response()->json(['success' => 'Customer Saved4 Successfully']);

       } 
        
        else {

            $data['ccm_first_name'] = $request->first_name;
            $data['ccm_last_name'] = $request->last_name;
            $data['ccm_email_id'] = $request->mail;
            $data['ccm_mobile_no'] = $request->reg_mobile;
            $dob = date_create($request->dob);
            $doa = date_create($request->doa);
            $data['ccm_dob'] = date_format($dob, "Y-m-d H:i:s");
            $data['ccm_doa'] = date_format($doa, "Y-m-d H:i:s");
            $data['ccm_gender'] = $request->gender;
            $data['ccm_created_dt'] = Carbon::now();
            $data['ccm_created_by'] = Auth::user()->id;
            $data['ccm_modified_dt'] = Carbon::now();
            $data['ccm_modified_by'] = Auth::user()->id;
            $data['ccm_active_status'] = 1;

            DB::table('crm_customer_master')->where('CCM_MOBILE_NO',$mobile_no)->update($data);

            return response()->json(['success' => 'Customer Updated Successfully']);

        }


    }

}

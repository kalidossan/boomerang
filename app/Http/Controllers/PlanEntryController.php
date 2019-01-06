<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanEntryController extends Controller {

    public function index() {

        $data['plan'] = DB::table('CRM_PLAN_ENTRY_MASTER')->get();

        return view('plan_entry', $data);
    }

    public function plan_amount(Request $request) {
        $data['plan_amount'] = DB::table('CRM_PLAN_ENTRY_MASTER')->where('cpe_plan_id', $request->plan_amount)->get();
        return response()->json($data);
    }

    public function store(Request $request) {

        \DB::beginTransaction();
        try {
            $data['CPE_PLAN_TYPE'] = $request->plan_entry_master;
            $data['CPE_AMOUNT'] = $request->plan_entry_amount;
            $data['CPE_SMS_ALLOTED'] = $request->sms_count;
            $data['CPE_TENURE_MONTHS'] = $request->tennure;

            $data['CPE_TENURE_DAYS'] = $request->tennure_in_days;
            $data['CPE_DISPLAY_TYPE'] = $request->pub_prv_access;
            $data['CPE_PLAN_NAME'] = $request->plan_name_master;
            $data['cpe_created_dt'] = Carbon::now();
            $data['cpe_created_by'] = Auth::user()->id;
            $data['cpe_modified_dt'] = Carbon::now();
            $data['cpe_modified_by'] = Auth::user()->id;
            $data['cpe_active_status'] = 1;

            DB::table('CRM_PLAN_ENTRY_MASTER')->insert($data);


            \DB::commit();

            $success = true;
        } catch (\Exception $e) {
            $success = false;

            echo $e;

            print "Plan Not Saved.";

            \DB::rollback();
        }

        $data['plan'] = DB::table('CRM_PLAN_ENTRY_MASTER')->get();

        return view('plan_entry', $data);

        // return response()->json(['success' => 'Plan Saved Successfully']);
    }

}

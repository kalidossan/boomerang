<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Excel;
use File;

class CustomerController extends Controller {

    public function customer(Request $request) {

        $mobile_no = $request->mobile;

        $data['customer'] = DB::table('CRM_CUSTOMER_MASTER')
                ->where('CCM_MOBILE_NO', $mobile_no)
                ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                ->join('CRM_CUST_RET_LINK', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID', '=', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID')
                ->first();


        $data['existing_customer'] = DB::table('CRM_CUSTOMER_MASTER')
                ->where('CCM_MOBILE_NO', $mobile_no)
                ->first();


        if ($data['existing_customer'] == null) {
            $data['is_new'] = 'y';
            return response()->json($data);
        } else {

            if ($data['customer'] == null) {
                $data['others'] = 'y';
            } else {
                $data['others'] = 'n';
                $data['cust_type'] = DB::table('CRM_CUST_RET_LINK')
                                ->where('CCRL_CCM_CUST_ID', $data['customer']->CCM_CUST_ID)
                                ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                                ->first()->CCRL_CUST_PROS_TYPE;
                $data['cust_category_values'] = DB::table('CRM_CUST_CAT_VALUES')
                        ->select('CCCV_LABEL', 'CCCV_VALUE')
                        ->join('CRM_CUST_RET_LINK', 'CRM_CUST_RET_LINK.CCRL_LINK_ID', '=', 'CRM_CUST_CAT_VALUES.CCCV_LINK_ID')
                        ->join('CRM_CUSTOMER_MASTER', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID', '=', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID')
                        ->where('CCM_CUST_ID', $data['customer']->CCM_CUST_ID)
                        ->get();
                $check_retailers = DB::table('CRM_CUST_RET_LINK')
                                ->where('CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID', $data['customer']->CCM_CUST_ID)
                                ->first()->CCRL_RET_BIZ_ID;

                if ($check_retailers == Auth::user()->biz_id) {
                    $data['check_retailers'] = '1';
                } else {
                    $data['check_retailers'] = '0';
                }
                $link_id = linkInfoFromMobileNo($mobile_no)->CCRL_LINK_ID;

                $current_ret_visit_count = DB::table('CRM_CUST_VISIT_DETAILS')->where('CCVD_CCRL_LINK_ID', $link_id)->first();

                if ($current_ret_visit_count == null) {
                    $data['visit'] = 0;
                } else {
                    $data['visit'] = $current_ret_visit_count->CCVD_VISIT_FLAG;
                }
            }
            $data['is_new'] = 'n';
            return response()->json($data);
        }
    }

    public function flipAndGroup($input) {
        $outArr = array();
        array_walk($input, function($value, $key) use (&$outArr) {
            if (!isset($outArr[$value]) || !is_array($outArr[$value])) {
                $outArr[$value] = [];
            }
            $outArr[$value][] = $key;
        });
        return $outArr;
    }

    public function downloadTpl() {

        Excel::create('template', function($excel) {



            // Set the title
            $excel->setTitle('Our new awesome title');

            // Chain the setters
            $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Sheet Name', function($sheet) {

                $head_category = array();
                $category_label = DB::table('CRM_CATEGORIES_MASTER')->select('CCM_LABEL_NAME')
                                ->where('CCM_CREATED_BY', Auth::user()->biz_id)->get()->toArray();

                foreach ($category_label as $key => $value) {
                    $head_category[] = $value->CCM_LABEL_NAME;
                }

                $head = array(
                    'FirstName',
                    'LastName',
                    'Mobile',
                    'Email',
                    'DOB',
                    'DOA',
                    'Gender',
                    'Area',
                    'OptOutStatus',
                    'CustProspt',
                );

                $data = array_merge($head, $head_category);
                $sheet->fromArray($data, null, 'A1', false, false);
            });


            $excel->sheet('sheet_name', function ( $sheet ) {
                $sheet->row(1, array(
                    'My Row Title'
                ));
                $sheet->SetCellValue("A1", "PHP");
                $sheet->SetCellValue("A2", "WordPress");
                $sheet->SetCellValue("A3", "Laravel");
                $sheet->SetCellValue("A4", "Magento");

                //Gather data from these cells
                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'php', $sheet, 'A2:A4'
                        )
                );

                $col_count = 100; //Getting the value of column count
                for ($i = 1; $i <= $col_count; $i ++) {
                    $objValidation = $sheet->getCell('B' . $i)->getDataValidation();
                    $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Input error');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please pick a value from the drop-down list.');
                    $objValidation->setFormula1('php'); //note this!
                }
            });
        })->download('xlsx');

        return Redirect::back();
    }

    public function getDownload(Request $request) {


        $file_name = DB::table('CRM_CUSTOMER_UPLOAD')->select('CCU_FILE_NAME')->where('CCU_ID', $request->dwld_id)->first()->CCU_FILE_NAME;


        $file = public_path() . "/xls/" . $file_name;

        $headers = [
            'Content-Type' => 'data:application/vnd.ms-excel',
            'file_name' => $file_name,
        ];

        return response()->download($file);
    }

    public function customerApproval(Request $request) {

        $file_name = DB::table('CRM_CUSTOMER_UPLOAD')->select('CCU_FILE_NAME', 'CCU_RET_BIZ_ID')
                ->where('CCU_ID', $request->upld_id)
                ->first();

        $path = public_path() . '/xls/' . $file_name->CCU_FILE_NAME;

        $data = Excel::load($path, function($reader) {
                    
                })->get();

        if (!empty($data) && $data->count()) {

            foreach ($data as $key => $value) {

                $unique_customer_mobile = DB::table('CRM_CUSTOMER_MASTER')->where('CCM_MOBILE_NO', $value->mobile)->get();

                if (count($unique_customer_mobile)!=1) {
                if (!empty($value->mobile)) {

                    $cdata['ccm_first_name'] = $value->firstname;
                    $cdata['ccm_last_name'] = $value->lastname;
                    $cdata['ccm_email_id'] = $value->email;
                    $cdata['ccm_mobile_no'] = $value->mobile;
                    $dob = date_create($value->dob);
                    $doa = date_create($value->doa);
                    $cdata['ccm_dob'] = date_format($dob, "Y-m-d H:i:s");
                    $cdata['ccm_doa'] = date_format($doa, "Y-m-d H:i:s");

                    if ($value->gender == 'f' || $value->gender == 'F') {
                        $cdata['ccm_gender'] = 1;
                    } else {
                        $cdata['ccm_gender'] = 0;
                    }

                    $cdata['CCM_AREA_NAME'] = $value->area;
                    $cdata['ccm_created_dt'] = Carbon::now();
                    $cdata['ccm_created_by'] = $file_name->CCU_RET_BIZ_ID;
                    $cdata['ccm_modified_dt'] = Carbon::now();
                    $cdata['ccm_modified_by'] = $file_name->CCU_RET_BIZ_ID;
                    $cdata['ccm_active_status'] = 1;
                    $cdata['CCM_CUST_PROS_TYPE'] = $value->cust_pros;
                    $id = DB::table('CRM_CUSTOMER_MASTER')->insertGetId($cdata);

                    $ldata['ccrl_ccm_cust_id'] = $id;
                    $ldata['ccrl_ret_biz_id'] = $file_name->CCU_RET_BIZ_ID;
                    $ldata['ccrl_optout_status'] = $value->OptOutStatus;
                    $ldata['ccrl_cust_pros_type'] = $value->CustProspt;
                    $ldata['ccrl_created_dt'] = Carbon::now();
                    $ldata['ccrl_created_by'] = $file_name->CCU_RET_BIZ_ID;
                    $ldata['ccrl_modified_dt'] = Carbon::now();
                    $ldata['ccrl_modified_by'] = $file_name->CCU_RET_BIZ_ID;

                    $id1 = DB::table('CRM_CUST_RET_LINK')->insertGetId($ldata);

                    $index = 0;
                    $tmp = array();
                    $total_index = count($value);


                    foreach ($value as $k => $v) {


                        if (($index > 9)) {
                            $k_temp = DB::table('CRM_CATEGORIES_MASTER')->select('CCM_ID')
                                    ->where([
                                        ['CCM_RET_BIZ_ID', '=', $file_name->CCU_RET_BIZ_ID],
                                        ['CCM_LABEL_NAME', '=', $k]
                                    ])
                                    ->first();

                            if ($k_temp != null) {

                                $map_ids = explode(',', $v);
                                $map_ids_array = array();

                                foreach ($map_ids as $map_key => $map_value) {
                                    
                                    if ($map_value != null) {

                                    $mapping_value = DB::table('CRM_CAT_VALUES_MASTER')
                                            ->select('CCVM_ID')
                                            ->where([
                                                ['CCVM_VALUE', '=', trim($map_value)],
                                                ['CCVM_CREATED_BY', '=', $file_name->CCU_RET_BIZ_ID]
                                            ])
                                            ->first();

                                    
                                        $map_ids_array[] = $mapping_value->CCVM_ID;
                                    }
                                }

                                $category_values_string = implode(',', $map_ids_array);
                                $cvdata['CCCV_LINK_ID'] = $id1;
                                $cvdata['CCCV_LABEL'] = $k_temp->CCM_ID;
                                $cvdata['CCCV_VALUE'] = $category_values_string;
                                $cvdata['CCCV_CREATED_DT'] = Carbon::now();
                                $cvdata['CCCV_CREATED_BY'] = $file_name->CCU_RET_BIZ_ID;
                                $cvdata['CCCV_MODIFIED_DT'] = Carbon::now();
                                $cvdata['CCCV_MODIFIED_BY'] = $file_name->CCU_RET_BIZ_ID;
                                DB::table('CRM_CUST_CAT_VALUES')->insert($cvdata);
                            }
                        }

                        $tmp = array();
                        $index++;
                    }
                }
                 }
            }
        }

        $updata['CCU_STATUS'] = 1;

        DB::table('CRM_CUSTOMER_UPLOAD')->where('CCU_ID', $request->upld_id)->update($updata);
    }

    public function import(Request $request) {

        //validate the xls file
        $this->validate($request, array(
            'file' => 'required'
        ));

        if ($request->hasFile('file')) {
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

                $path = $request->file->getRealPath();

                //$path = $request->file('import_file')->getRealPath();

                $xlName = Auth::user()->biz_id . time() . '.' . request()->file->getClientOriginalExtension();

                request()->file->move(public_path('xls'), $xlName);

                $cudata['CCU_FILE_NAME'] = $xlName;
                $cudata['CCU_CREATED_DT'] = Carbon::now();
                $cudata['CCU_STATUS'] = 0;
                $cudata['CCU_RET_BIZ_ID'] = Auth::user()->biz_id;

                DB::table('CRM_CUSTOMER_UPLOAD')->insert($cudata);


                return back();
            } else {
                Session::flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }

    public function store(Request $request) {

        $mobile_no = $request->mobile;


        if($request->category_values_id!=null){

              $category_values_ids = explode(',', $request->category_values_id);


        foreach ($category_values_ids as $k => $category_values_id) {

            $getCatLabelId = DB::table('CRM_CAT_VALUES_MASTER')
                            ->where('CCVM_ID', $category_values_id)
                            ->first()
                    ->CCVM_CCM_ID;

            $category_labels_ids[$category_values_id] = $getCatLabelId;
        }

        $combine_label_values = $this->flipAndGroup($category_labels_ids);


        foreach ($combine_label_values as $key => $value) {

            foreach ($value as $k => $v) {

                $vkey[$key][] = $v;
            }

            $one_combine_label_values[$key] = implode(',', $vkey[$key]);

            $label_values = $one_combine_label_values;
        }



        }

      

        $customer = DB::table('CRM_CUSTOMER_MASTER')
                ->where('CCM_MOBILE_NO', $mobile_no)
                ->where('CRM_CUST_RET_LINK.CCRL_RET_BIZ_ID', Auth::user()->biz_id)
                ->join('CRM_CUST_RET_LINK', 'CRM_CUSTOMER_MASTER.CCM_CUST_ID', '=', 'CRM_CUST_RET_LINK.CCRL_CCM_CUST_ID')
                ->first();
        $existing_customer = DB::table('CRM_CUSTOMER_MASTER')
                ->where('CCM_MOBILE_NO', $mobile_no)
                ->first();


        if ($existing_customer == null) {

            \DB::beginTransaction();
            try {
                $data['ccm_first_name'] = $request->first_name;
                $data['ccm_last_name'] = $request->last_name;
                $data['ccm_email_id'] = $request->mail;
                $data['ccm_mobile_no'] = $request->mobile;
                $dob = date_create($request->dob);
                $doa = date_create($request->doa);
                $data['ccm_dob'] = date_format($dob, "Y-m-d H:i:s");
                $data['ccm_doa'] = date_format($doa, "Y-m-d H:i:s");
                $data['ccm_gender'] = $request->gender;
                $data['ccm_created_dt'] = Carbon::now();
                $data['ccm_created_by'] = Auth::user()->biz_id;
                $data['ccm_modified_dt'] = Carbon::now();
                $data['ccm_modified_by'] = Auth::user()->biz_id;
                $data['ccm_active_status'] = 1;
                $data['CCM_CUST_PROS_TYPE'] = $request->cust_pros;
                $id = DB::table('CRM_CUSTOMER_MASTER')->insertGetId($data);

                $ldata['ccrl_ccm_cust_id'] = $id;
                $ldata['ccrl_ret_biz_id'] = Auth::user()->biz_id;
                $ldata['ccrl_optout_status'] = 1;
                $ldata['ccrl_cust_pros_type'] = $request->cust_pros;
                $ldata['ccrl_created_dt'] = Carbon::now();
                $ldata['ccrl_created_by'] = Auth::user()->biz_id;
                $ldata['ccrl_modified_dt'] = Carbon::now();
                $ldata['ccrl_modified_by'] = Auth::user()->biz_id;
                $id1 = DB::table('CRM_CUST_RET_LINK')->insertGetId($ldata);


                if ($request->exp_dte != null || $request->arequest != null) {
                    $exp = date_create($request->exp_dte);
                    $rdata['car_ccrl_link_id'] = $id1;
                    $rdata['car_req_text_status'] = 0;
                    $rdata['car_request_dt'] = date_format($exp, "Y-m-d H:i:s");
                    $rdata['car_request_text'] = $request->arequest;
                    $rdata['car_created_dt'] = Carbon::now();
                    $rdata['car_created_by'] = Auth::user()->biz_id;
                    $rdata['car_modified_dt'] = Carbon::now();
                    $rdata['car_modified_by'] = Auth::user()->biz_id;
                    DB::table('CRM_ADD_REQUEST')->insert($rdata);
                }

                $vdata['ccvd_ccrl_link_id'] = $id1;
                $vdata['ccvd_visit_flag'] = 1;
                $vdata['ccvd_created_dt'] = Carbon::now();
                $vdata['ccvd_created_by'] = Auth::user()->biz_id;
                DB::table('CRM_CUST_VISIT_DETAILS')->insert($vdata);


                 if($request->category_values_id!=null){

                foreach ($label_values as $key => $value) {

                    $cvdata['CCCV_LINK_ID'] = $id1;
                    $cvdata['CCCV_LABEL'] = $key;
                    $cvdata['CCCV_VALUE'] = $value;
                    $cvdata['CCCV_CREATED_DT'] = Carbon::now();
                    $cvdata['CCCV_CREATED_BY'] = Auth::user()->biz_id;
                    $cvdata['CCCV_MODIFIED_DT'] = Carbon::now();
                    $cvdata['CCCV_MODIFIED_BY'] = Auth::user()->biz_id;
                    DB::table('CRM_CUST_CAT_VALUES')->insert($cvdata);
                }

            }

                \DB::commit();

                $success = true;
            } catch (\Exception $e) {
                $success = false;

                echo $e;

                print "Customer Not Saved.";

                \DB::rollback();
            }

            $data['success'] = 'Customer Saved Successfully';
            return response()->json($data);
        } else {

            $data['ccm_first_name'] = $request->first_name;
            $data['ccm_last_name'] = $request->last_name;
            $data['ccm_email_id'] = $request->mail;
            $data['ccm_mobile_no'] = $request->mobile;
            $dob = date_create($request->dob);
            $doa = date_create($request->doa);
            $data['ccm_dob'] = date_format($dob, "Y-m-d H:i:s");
            $data['ccm_doa'] = date_format($doa, "Y-m-d H:i:s");
            $data['ccm_gender'] = $request->gender;
            $data['ccm_created_dt'] = Carbon::now();
            $data['ccm_created_by'] = Auth::user()->biz_id;
            $data['ccm_modified_dt'] = Carbon::now();
            $data['ccm_modified_by'] = Auth::user()->biz_id;
            $data['ccm_active_status'] = 1;
            $data['CCM_CUST_PROS_TYPE'] = $request->cust_pros;

            DB::table('CRM_CUSTOMER_MASTER')
                    ->where('CCM_MOBILE_NO', $mobile_no)
                    ->update($data);

            if ($customer == null) {

                $ldata['ccrl_ccm_cust_id'] = $existing_customer->CCM_CUST_ID;
                $ldata['ccrl_ret_biz_id'] = Auth::user()->biz_id;
                $ldata['ccrl_optout_status'] = 1;
                $ldata['ccrl_cust_pros_type'] = $request->cust_pros;
                $ldata['ccrl_created_dt'] = Carbon::now();
                $ldata['ccrl_created_by'] = Auth::user()->biz_id;
                $ldata['ccrl_modified_dt'] = Carbon::now();
                $ldata['ccrl_modified_by'] = Auth::user()->biz_id;
                $id1 = DB::table('CRM_CUST_RET_LINK')->insertGetId($ldata);

                $vdata['ccvd_ccrl_link_id'] = $id1;
                $vdata['ccvd_visit_flag'] = 1;
                $vdata['ccvd_created_dt'] = Carbon::now();
                $vdata['ccvd_created_by'] = Auth::user()->biz_id;
                DB::table('CRM_CUST_VISIT_DETAILS')->insert($vdata);

                if ($request->exp_dte != null || $request->arequest != null) {
                    $exp = date_create($request->exp_dte);
                    $rdata['car_ccrl_link_id'] = $id1;
                    $rdata['car_req_text_status'] = 0;
                    $rdata['car_request_dt'] = date_format($exp, "Y-m-d H:i:s");
                    $rdata['car_request_text'] = $request->arequest;
                    $rdata['car_created_dt'] = Carbon::now();
                    $rdata['car_created_by'] = Auth::user()->biz_id;
                    $rdata['car_modified_dt'] = Carbon::now();
                    $rdata['car_modified_by'] = Auth::user()->biz_id;
                    DB::table('CRM_ADD_REQUEST')->insert($rdata);
                }

                if($request->category_values_id!=null){
                 DB::table('CRM_CUST_CAT_VALUES')->where('CCCV_LINK_ID', $id1)->delete();

                foreach ($label_values as $key => $value) {

                    $cvdata['CCCV_LINK_ID'] = $id1;
                    $cvdata['CCCV_LABEL'] = $key;
                    $cvdata['CCCV_VALUE'] = $value;
                    $cvdata['CCCV_CREATED_DT'] = Carbon::now();
                    $cvdata['CCCV_CREATED_BY'] = Auth::user()->biz_id;
                    $cvdata['CCCV_MODIFIED_DT'] = Carbon::now();
                    $cvdata['CCCV_MODIFIED_BY'] = Auth::user()->biz_id;
                    DB::table('CRM_CUST_CAT_VALUES')->insert($cvdata);
                }
            }
            } else {

                $visit = $request->visit;

                $customer_id = $customer->CCM_CUST_ID;

                $link_id = linkInfoFromMobileNo($mobile_no)->CCRL_LINK_ID;



                $ldata['ccrl_cust_pros_type'] = $request->cust_pros;
                $ldata['ccrl_modified_dt'] = Carbon::now();
                $ldata['ccrl_modified_by'] = Auth::user()->biz_id;
                DB::table('CRM_CUST_RET_LINK')->where('CCRL_LINK_ID', $link_id)->update($ldata);


                $vdata['CCVD_VISIT_FLAG'] = $visit + 1;
                $vdata['CCVD_UPDATED_DT'] = Carbon::now();
                $vdata['CCVD_UPDATED_BY'] = Auth::user()->biz_id;
                DB::table('CRM_CUST_VISIT_DETAILS')->where('CCVD_CCRL_LINK_ID', $link_id)->update($vdata);

                if ($request->exp_dte != null || $request->arequest != null) {
                    $exp = date_create($request->exp_dte);
                    $rdata['car_ccrl_link_id'] = $customer->CCRL_LINK_ID;
                    $rdata['car_req_text_status'] = 0;
                    $rdata['car_request_dt'] = date_format($exp, "Y-m-d H:i:s");
                    $rdata['car_request_text'] = $request->arequest;
                    $rdata['car_created_dt'] = Carbon::now();
                    $rdata['car_created_by'] = Auth::user()->biz_id;
                    $rdata['car_modified_dt'] = Carbon::now();
                    $rdata['car_modified_by'] = Auth::user()->biz_id;
                    DB::table('CRM_ADD_REQUEST')->insert($rdata);
                }

                 if($request->category_values_id!=null){

                DB::table('CRM_CUST_CAT_VALUES')->where('CCCV_LINK_ID', $link_id)->delete();

                foreach ($label_values as $key => $value) {

                    $cvdata['CCCV_LINK_ID'] = $link_id;
                    $cvdata['CCCV_LABEL'] = $key;
                    $cvdata['CCCV_VALUE'] = $value;
                    $cvdata['CCCV_CREATED_DT'] = Carbon::now();
                    $cvdata['CCCV_CREATED_BY'] = Auth::user()->biz_id;
                    $cvdata['CCCV_MODIFIED_DT'] = Carbon::now();
                    $cvdata['CCCV_MODIFIED_BY'] = Auth::user()->biz_id;
                    DB::table('CRM_CUST_CAT_VALUES')->insert($cvdata);
                }

            }
            
            }

            $data['success'] = 'Customer Updated Successfully';

            return response()->json($data);
        }
    }

}

<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Category;

class CategoryConfigController extends Controller {
    
    public function index(Request $request){
        
       if(isset($request->cid)) {
           $cid = $request->cid;
       }
       else{
           $cid = 8;
       }       
        
       $data['categories'] = DB::table('CRM_CATEGORIES_MASTER')->select('*')->where('CCM_RET_BIZ_ID',Auth::user()->biz_id)->get();      
       $data['values'] = (new Category)->categoryValues($cid);       
       // $data['values'] = DB::table('crm_cat_values_master')->get();
        //return view('category_config',$data);  
        return view('retailer.retailer_config',$data);     
    }
    
    
    public function cat_value(Request $request){
         if(isset($request->cid)) {
           $cid = $request->cid;
       }
       else{
           $cid = 8;
       }  
        
               $data['values'] = (new Category)->categoryValues($cid);    
               
               return response()->json($data);

    }

    public function store(Request $request) {

        \DB::beginTransaction();
        try {
            
            $data['CCM_RET_BIZ_ID'] = Auth::user()->biz_id;
            $data['CCM_LABEL_NAME'] = $request->category_label;           
            $data['CCM_CREATED_DT'] = Carbon::now();
            $data['CCM_CREATED_BY'] = Auth::user()->biz_id;
            $data['CCM_MODIFIED_DT'] = Carbon::now();
            $data['CCM_MODIFIED_BY'] = Auth::user()->biz_id;

            $id = DB::table('CRM_CATEGORIES_MASTER')->insertGetId($data);
          
             $categories = explode(',', $request->category_value);
             
             foreach($categories as $category){                         
                $cvdata['CCVM_CCM_ID'] = $id;
                $cvdata['CCVM_VALUE'] = $category;
                $cvdata['CCVM_CREATED_DT'] = Carbon::now();
                $cvdata['CCVM_CREATED_BY'] = Auth::user()->biz_id;
                $cvdata['CCVM_MODIFIED_DT'] = Carbon::now();
                $cvdata['CCVM_MODIFIED_BY'] = Auth::user()->biz_id;
                DB::table('CRM_CAT_VALUES_MASTER')->insert($cvdata);                
             }


            \DB::commit();

            $success = true;
        } catch (\Exception $e) {
            $success = false;

            echo $e;

            print "Categories Not Saved.";

            \DB::rollback();
        }
        
        
        if (isset($request->cid)) {
            $cid = $request->cid;
        } else {
            $cid = 0;
        }
        
        $data['categories_master'] = DB::table('CRM_CATEGORIES_MASTER')->select('*')->where('CCM_RET_BIZ_ID',Auth::user()->biz_id)->get();      
        $data['categories_master_values'] = (new Category)->categoryValues($cid);        
        return view('retailer.retailer_category',$data); 

    }

}

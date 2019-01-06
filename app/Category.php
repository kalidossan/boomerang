<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    //protected $fillable = ['title','start_date','end_date'];


    public function categoryValues($cid) {

        $data = DB::select(DB::raw(" select ccvm_value from CRM_CAT_VALUES_MASTER 
            
        where ccvm_ccm_id = ".$cid."
            
        "));
        return $data;
    }

}

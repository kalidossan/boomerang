<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $fillable = ['title', 'start_date', 'end_date'];

    public function msgModerator($cid) {
        $data = DB::select(DB::raw(" select ccvm_value from crm_cat_values_master 
        where ccvm_ccm_id = " . $cid . "
        "));
        return $data;
    }

}

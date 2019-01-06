<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="success"></div>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
               
               <div class="customer"></div> <div class="first_name"></div>
               <div class="mbl_no">Mobile </div>   <div class="mobile_no"></div>
               <div class="cgender">Gender </div>   <div class="customer_gender"></div>
               <div class="c_email">E-Mail </div>   <div class="customer_email"></div>
                
               
               
            </div>
           
        </div>

    </div>
</div>

<div id="custModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="success"></div>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
               
               <div class="customer"></div> Please Select Min one Category <div class="first_name"></div>
               
            </div>
           
        </div>

    </div>
</div>

<div id="msg_preview" class="modal fade msg_preview" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            

            <form id="preview_mc">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><p name ="message_type" class="preview_message_type"></p></h4>
                </div>
                <div class="modal-body">

                    
                    <div class="title">Message Title : </div> <p name="c_message_title" class="preview_message_title"></p>
                    <div class="title">Message Text  : </div> <p name="c_message_txt" class="preview_message_txt"></p>
                    <div class="title">Valid Date    : </div> <p name="c_valid_till" class="preview_valid_till"></p>
                    <div class="title">Valid Time    : </div> <p name="c_valid_till_time" class="preview_valid_till_time"></p>
                    <div class="title">Gender        : </div> <p name="c_gender_group" class="preview_gender"></p>
                    <div class="title">Customer Type : </div> <p name="c_cust_pros_target" class="preview_cust_pros_target"></p>

                    <input type="hidden" name="c_mc_category_name_id" id="preview_mc_category_name_id"/>
                    <input type="hidden" name="c_mc_category_values_id" id="p_mc_category_values_id"/>
                    <input type="hidden" name="preview_gend_type" id="preview_gend_type"/>
                    <input type="hidden" name="preview_cust_type" id="preview_cust_type"/>
                    <input type="hidden" name="preview_message_type" id="preview_message_type"/>


                    <div class="">Categories : </div>

                    <div class="preview_selected_categories"></div>

                                    <div id="msg_preview_msg"></div>
                                    <div id="msg_preview_error_msg"></div>



                </div>
                <div class="modal-footer">
                    <button id="create_message" type="button" class="btn btn-default" >Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>
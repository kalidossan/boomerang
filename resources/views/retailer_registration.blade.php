<div id="retailer_registration"> 

    <form method="GET" id="form_registration" ">

        <div class="col-sm-6 panel">


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" value="{{csrf_token()}}" id="token" name="_token" />

                        <div class="form-group">
                            <div class="title">Mobile No</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="reg_mobile" name="reg_mobile" value="{{ old('mobile') }}" maxlength="10" required="required"/>
                        </div>

                        <div class="form-group">
                            <div class="title">Business Category</div>

                            <select class="form-control select2 retailer_registration" name="biz_category" id="biz_category" required="required">
                                @foreach($business_categories as $business_category)
                                <option value="{{$business_category->CBM_ID}}">{{$business_category->CBM_BUSINESS_CATEGORY}}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group">
                            <div class="title">Business Name</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="reg_biz_name" name="reg_biz_name" value="{{ old('biz_name') }}" required="required"/>
                        </div>

                        <div class="form-group">
                            <div class="title">First Name</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="first_name" name="first_name" value="{{ old('first_name') }}" required="required"/>
                        </div>
                        <div class="form-group">
                            <div class="title">Last Name</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id= "last_name" name="last_name" value="{{ old('last_name') }}" required="required"/>
                        </div>
                        <div class="form-group">
                            <div class="title">E-Mail</div>
                            <input type="email" autocomplete="off" class="form-control retailer_registration" id="mail" name="mail" value="{{ old('mail') }}" />
                        </div>

                        <div class="form-group">
                            <div class="title">Sender ID</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="sender_id" name="sender_id" value="{{ old('sender_id') }}" required="required"/>
                        </div>



                        <div class="form-group">
                            <div class="title">Business Start Date</div>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input autocomplete="off" name="dos" type="text" value="{{ old('dos') }}" class="form-control pull-right " id="dos" autocomplete="off" required="required">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="title">GST No</div>
                            <input type="mobile" autocomplete="off" class="form-control retailer_registration" id="gst_no" name="gst_no" value="{{ old('gst_no') }}" required="required"/>
                        </div>

                        <div class="form-group">
                            <div class="title">Fb Address</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="fb_id" name="fb_id" value="{{ old('fb_id') }}"/>
                        </div>
                        <div class="form-group">
                            <div class="title">Instagram ID</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="instagram_id" name="instagram_id" value="{{ old('instagram_id') }}"/>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-sm-6 panel">

            <div class="form-group">
                <div class="title">Pin Code</div>
                <input type="text" autocomplete="off" class="form-control retailer_registration" id="pincode" name="pincode" value="{{ old('pincode') }}"/>
            </div>
            <div class="form-group">
                <div class="title">State</div>
                <input type="text" autocomplete="off" class="form-control retailer_registration" id="state" name="state" value="{{ old('state') }}"/>
            </div>
            <div class="form-group">
                <div class="title">City </div>
                <input type="text" autocomplete="off" class="form-control retailer_registration" id="city" name="city" value="{{ old('city') }}"/>
            </div>
            <div class="form-group">
                <div class="title">Area </div>
                <input type="text" autocomplete="off" class="form-control retailer_registration" id="area" name="area" value="{{ old('area') }}"/>
            </div>
            <div class="form-group">
                <div class="title">Street </div>
                <input type="text" autocomplete="off" class="form-control retailer_registration" id="street" name="street" value="{{ old('street') }}"/>
            </div>
            <div class="form-group">
                <div class="title">Plot/Flat No </div>
                <input type="text" autocomplete="off" class="form-control retailer_registration" id="flat_no" name="flat_no" value="{{ old('flat_no') }}"/>
            </div>
            <div class="form-group">
                <button id="retailer_registration_submit" type="submit" class="btn btn-primary">Create</button>

            </div>

        </div>
    </form>

</div>

<div id="regModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="success"></div>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">

                <div class="customer"></div> Retailers Updated Successfully <div class="first_name"></div>

            </div>

        </div>

    </div>
</div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>

<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({
headers: {'X-CSRF-TOKEN': $('#token').val()}
});
$(document).on('submit', '#form_registration', function(e){
var token = $('#token').val();
e.preventDefault();
$.ajax({
type:'GET',
        url:APP_URL + "/retailer/registration",
        data:$('#form_registration').serialize() + "&token=" + token,
        success:function(data){

        $('.success').text(data.success)

                $('#regModal').modal('show');
        $("#form_registration").trigger('reset');
        }
});
});
$("#reg_mobile").on('blur', function(e) {
e.preventDefault();
var mobile = $("#reg_mobile").val();
$.ajax({
type:'GET',
        url:APP_URL + "/get/retailer",
        data: "&token=" + token + "&mobile=" + mobile,
        success:function(data){


        if (data.is_new !== 'y'){

        $("#reg_mobile").val(data.retailer.RET_MOBILE_NO);
        $("#sender_id").val(data.sender_id);
        $("#biz_category").val(data.retailer.RET_BIZ_CATEGORY);
        $("#reg_biz_name").val(data.retailer.RET_BIZ_NAME);
        $("#first_name").val(data.retailer.RET_FIRST_NAME);
        $("#last_name").val(data.retailer.RET_LAST_NAME);
        $("#mail").val(data.retailer.RET_EMAIL_ID);
        d1 = new Date(Date.parse(data.retailer.RET_BIZ_START_DT));
        var dos = $.datepicker.formatDate('mm/dd/yy', d1);
        $("#dos").val(dos);
        $("#gst_no").val(data.retailer.RET_GST_NUMBER);
        $("#fb_id").val(data.retailer.RET_FB_ID);
        $("#instagram_id").val(data.retailer.RET_INSTA_ID);
        $("#pincode").val(data.retailer.RET_PINCODE);
        $("#state").val(data.retailer.RET_STATE_NAME);
        $("#city").val(data.retailer.RET_CITY_NAME);
        $("#area").val(data.retailer.RET_AREA_NAME);
        $("#street").val(data.retailer.RET_STREET_NAME);
        $("#flat_no").val(data.retailer.RET_FLAT_NO);
       }

        else{
        var cust_mob = $("#reg_mobile").val();
        $("#form_registration").trigger('reset');
        $("#reg_mobile").val(cust_mob);
        }




        }
});
});
$(document).ready(function() {

$('#plan_entry').on('change', function(){
//var optionValue = $(this).val();
//var optionText = $('#dropdownList option[value="'+optionValue+'"]').text();
var token = $('#token').val();
var plan_amount = $("#plan_entry option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/plan/amount",
        data: "&plan_amount=" + plan_amount + "&token=" + token,
        success:function(data){
        alert(data);
        
        console.log(data.plan_amount[0].CPE_AMOUNT);
        $("#plan_amount").val(data.plan_amount[0].CPE_AMOUNT);
        $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);
        $("#plan_name").val(data.plan_amount[0].CPE_PLAN_NAME);
        
        }
});
});
});
</script>













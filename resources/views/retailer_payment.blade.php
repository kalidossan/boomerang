<div id="form_payment_block">
<form id="form_payment" >

    <div class="col-sm-12 panel">

        <div class="row">
            <div class="form-group customer_type">
                <div class="title">Payment Type</div>
                <div class="radio">
                    <div class="title">
                        <input type="radio" name="payment_type" id="new_payment" value="0" >
                        New                                           </div>
                </div>
                <div class="radio">
                    <div class="title">
                        <input type="radio" name="payment_type" id="pending_payment" value="1">
                        Pending                                            </div>
                </div>

            </div>

            <select name="payment_verification" id="payment_verification" required="required" >
                <option value="1">Verified</option>
                <option value="2">Not Verified</option>
            </select>
            <div class="pending-block">
                Pending Amount <input type="text" id="workorder_pending_amount" disabled="disabled">
            </div>

        </div>

        <div class="col-sm-6 panel">

            <div class="form-group">
                <div class="title">Mobile No</div>
                <input type="text" autocomplete="off" class="form-control retailer_payment" id="mobile" name="mobile" required="required"/>
            </div>

            <div class="form-group">
                <div class="title">Business Name</div>
                <input type="text" autocomplete="off" class="form-control retailer_payment" id="biz_name" name="biz_name" value="{{ old('biz_name') }}" autocomplete="off"/>
            </div>

            <div class="form-group">
                <div class="title">Business ID</div>
                <input type="text" autocomplete="off" class="form-control retailer_payment" id="biz_id" name="biz_id" value="{{ old('biz_id') }}" autocomplete="off"/>
            </div>
            <div class="form-group">
                <div class="title">Contact Person</div>
                <input type="text" autocomplete="off" class="form-control retailer_payment" id= "contact_person" name="contact_person" value="{{ old('contact_person') }}" autocomplete="off"/>
            </div>
            
             <div class="form-group">
                <div class="title">Payment Mode</div> 
                <select class="form-control select2  payment_mode"   name="payment_mode" id="payment_mode"  >
                    @foreach($payment_mode as $pay_mode)
                    <option value="{{$pay_mode->CRPM_ID}}">{{$pay_mode->CRPM_MODE}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <div class="title">Reference No</div>
                <input type="text" autocomplete="off" class="form-control retailer_payment payment_reference_no" id= "payment_reference_no" name="payment_reference_no" value="{{ old('payment_reference_no') }}"/>
            </div>

            <div class="form-group">
                <div class="title">Bank </div>
                <input type="text" autocomplete="off" class="form-control retailer_payment bank" id= "bank" name="bank" value="{{ old('bank') }}"/>
            </div>




            <input type="hidden" id="plan_type" name="plan_type"/>
            <input type="hidden" id="plan_name" name="plan_name"/>
            <div class="form-group">
                <div class="title">Sales Person</div>
                <input type="text" autocomplete="off" class="form-control retailer_payment" id= "sales_person" name="sales_person" value="{{ old('sales_person') }}"/>
            </div>



        </div>
        <div class="col-sm-6 panel">
            
                    <div class="row cart">

            <div class="form-group sub_ren">
                <div class="">Payment For</div> 
                <select class="form-control   payment_for" name="payment_for" id="payment_for" >
                    <option value="0">None</option>
                    <option value="1">Subscription</option>
                    <option value="2">Renewal</option>
                    <option value="3">Work Order</option>
                </select>
                <input type="hidden" id="payment_for_values" name="payment_for_values"/>
            </div>

            <div id="subscription_block" class="form-group sub_ren">
                <div class="title">Subscription</div> 

                <select class="form-control  plan_subscription"  name="plan_subscription" id="plan_subscription"  disabled="disabled">
                    <option value="0">None </option>
                    @foreach($plan_subscription as $plan_entry)
                    <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                    @endforeach
                </select>
                  <input type="text" id="plan_amount_subscription" value="0" name="plan_amount_subscription" readonly="readonly" />
                   <input type="hidden" id="plan_name_subscription" value="0" name="plan_name_subscription" readonly="readonly" />
            </div>

            <div id="renewal_block" class="form-group sub_ren" style="display: none;">
                <div class="title">Renewal</div> 

                <select class="form-control  plan_renewal"  name="plan_renewal" id="plan_renewal" disabled="disabled" >
                    <option value="0">None</option>
                    @foreach($plan_renewal as $plan_entry)
                    <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                    @endforeach
                </select>

                <input type="text" id="plan_amount_renewal" value="0" name="plan_amount_renewal" readonly="readonly" />
                <input type="hidden" id="plan_name_renewal" value="0" name="plan_name_renewal" readonly="readonly" />
            </div>


            <div id="sms_block" class="form-group sub_ren">
                <div class="title">SMS PACK</div> 

                <select class="form-control  plan_sms"  name="plan_sms" id="plan_sms" disabled="disabled" >
                    <option value="0">None</option>
                    @foreach($plan_sms as $plan_entry)
                    <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                    @endforeach
                </select>
                  <input type="text" id="plan_amount_sms" value="0" name="plan_amount_sms" readonly="readonly" />
                  <input type="hidden" id="plan_name_sms" value="0" name="plan_name_sms" readonly="readonly" />
            </div>

            <div id="work_order" class="form-group sub_ren">
                <div class="title">Work Order</div> 

                <select id="work_order_select" class="form-control work_order_select" name="work_order_select" disabled="disabled">
                    <option value="0">None</option>
                </select>

                <input type="text" id="work_order_amount" value="0" name="work_order_amount" readonly="readonly" />
                  <input type="hidden" id="work_order_id" value="0" name="work_order_id" readonly="readonly" />
            </div>


            <div class="form-group">
                <div class="title">Amount</div> 
                <input type="text" id="plan_amount" name="plan_amount" value="0" />
                <input type="text" id="plan_amount_actual" name="plan_amount_actual" readonly="readonly"/>

            </div>




            <div class="form-group">
                <button id="retailer_payment_submit" type="submit" class="btn btn-primary">Create</button>
            </div>

        </div>
            
            
            
            
            
            


           

        </div>

        <div class="row"></div>



    </div>

</form>
</div>
<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.full.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.min.js')!!}"></script>

<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({
headers: {'X-CSRF-TOKEN': $('#token').val()}
});
$(document).on('submit', '#form_payment', function(e){
var token = $('#token').val();
e.preventDefault();
$.ajax({
type:'GET',
        url:APP_URL + "/retailer-payment-for",
        data:$('#form_payment').serialize() + "&token=" + token,
        success:function(data){        
        alert("WorkOrder Created Successfully")
                $('#form_payment_block').load(location.href + ' #form_payment_block');

        }
});
});


$(document).on('change','#payment_for', function (e) {
var payment_for = $('#payment_for option:selected').val();
$('#payment_for_values').val(payment_for);
if (payment_for == 0){
$('#plan_subscription').attr("disabled", true);
$('#plan_sms').attr("disabled", true);
$('#plan_renewal').attr("disabled", true);
$('#work_order_select').attr("disabled", true);
$("#plan_amount").val($("#plan_amount_sms").val());
$("#plan_amount_actual").val($("#plan_amount_sms").val());
}
else if (payment_for == 1){
$('#subscription_block').show();
$('#work_order_select').attr("disabled", true);

$('#plan_subscription').prop("disabled", false);
$('#renewal_block').hide();
$('#plan_sms').prop("disabled", false);
var total_amt = parseFloat($("#plan_amount_sms").val()) + parseFloat($("#plan_amount_subscription").val());
$("#plan_amount").val(total_amt);
$("#plan_amount_actual").val(total_amt);
}
else if (payment_for == 2){
$('#work_order_select').attr("disabled", true);
$('#subscription_block').hide();
$('#plan_renewal').prop("disabled", false);
$('#plan_sms').prop("disabled", false);
$('#renewal_block').show();
var total_amt = parseFloat($("#plan_amount_sms").val()) + parseFloat($("#plan_amount_renewal").val());
$("#plan_amount").val(total_amt);
$("#plan_amount_actual").val(total_amt);
}
else{
   $('#plan_subscription').attr("disabled", true);
$('#plan_renewal').attr("disabled", true);
$('#plan_sms').attr("disabled", true);
$('#work_order_select').prop("disabled", false);

}


});

$(document).on('blur','#mobile', function() {
var token = $('#token').val();
var mobile = $("#mobile").val();
$.ajax({
type:'get',
        url:APP_URL + "/get/retailer/payment",
        data: "&mobile=" + mobile + "&token=" + token,
        beforeSend: function() {
        $('body').css('opacity', '0.5');
        },
        success:function(data){

        $('body').css('opacity', '1');
        if (data.is_new == 'y'){
            
        alert("No Retailer");
        $('input:radio[name="payment_type"][value="0"]').attr('checked', true);
        $("#biz_name").val("");
        $("#biz_id").val("");
        $("#contact_person").val("");
        $("#workorder_pending_amount").val("");
        }
        else{
            
        for (var i = 0; i < data.work_order.length; i++) {
        $("#work_order select").append("<option  value=" + data.work_order[i].CWO_WO_ID + " >" + data.work_order[i].CWO_WO_ID + "</option>");
        }

        $('input:radio[name="payment_type"][value="1"]').attr('checked', true);
        $("#biz_name").val(data.retailer.RET_BIZ_NAME);
        $("#biz_id").val(data.retailer.RET_BIZ_ID);
        $("#contact_person").val(data.retailer.RET_FIRST_NAME);
        $("#workorder_pending_amount").val(data.pending_amount);
        }
        }

});
});


$(document).ready(function() {

$('#plan_subscription').on('change', function(){
var token = $('#token').val();
var plan_amount = $("#plan_subscription option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/plan/amount",
        data: "&plan_amount=" + plan_amount + "&token=" + token,
        success:function(data){

        if (plan_amount == 0){
        $("#plan_name_subscription").val('None');
        $("#plan_amount_subscription").val(0);
        var plan_amount_subscription = 0
        }
        else{
        $("#plan_name_subscription").val(data.plan_amount[0].CPE_PLAN_NAME);
        $("#plan_amount_subscription").val(data.plan_amount[0].CPE_AMOUNT);
        var plan_amount_subscription = data.plan_amount[0].CPE_AMOUNT;
        }

        var sub_ren = $("#payment_for_values").val();
        if (sub_ren == 0){
        var plan_amount_subscription = 0;
        }

        var plan_amount_renewal = 0;
        var plan_amount_sms = $("#plan_amount_sms").val();
        var cumulative = parseFloat(plan_amount_sms) + parseFloat(plan_amount_renewal) + parseFloat(plan_amount_subscription);
        $("#plan_amount").val(cumulative);
        $("#plan_amount_actual").val(cumulative);
        //$("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);


        }
});
});
$(document).on('change', '#work_order_select', function(){
var token = $('#token').val();
var work_order_select = $("#work_order_select option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/select/work_order",
        data: "&work_order_select=" + work_order_select + "&token=" + token,
        success:function(data){

        
        $("#work_order_amount").val(data.work_order.CWO_FINAL_PND_AMT);
        console.log(data);
        }


});
});
$(document).on('change', '#plan_sms', function(){
var token = $('#token').val();
var plan_amount = $("#plan_sms option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/plan/amount",
        data: "&plan_amount=" + plan_amount + "&token=" + token,
        success:function(data){

        if (plan_amount == 0){
        $("#plan_name_sms").val('None');
        $("#plan_amount_sms").val(0);
        var plan_amount_sms = 0;
        var sub_ren = $("#payment_for_values").val();
        if (sub_ren == 0){
        var plan_amount_renewal = 0;
        var plan_amount_subscription = 0;
        }
        else if (sub_ren == 1){
        var plan_amount_renewal = 0;
        var plan_amount_subscription = $("#plan_amount_subscription").val();
        }
        else{
        var plan_amount_renewal = $("#plan_amount_renewal").val();
        var plan_amount_subscription = 0;
        }

        var cumulative = parseFloat(plan_amount_sms) + parseFloat(plan_amount_renewal) + parseFloat(plan_amount_subscription);
        $("#plan_amount").val(cumulative);
        $("#plan_amount_actual").val(cumulative);
        $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);
        }
        else{

        $("#plan_amount_sms").val(data.plan_amount[0].CPE_AMOUNT);
        var plan_amount_sms = data.plan_amount[0].CPE_AMOUNT;
        var sub_ren = $("#payment_for_values").val();
        if (sub_ren == 0){
        var plan_amount_renewal = 0;
        var plan_amount_subscription = 0;
        }
        else if (sub_ren == 1){
        var plan_amount_renewal = 0;
        var plan_amount_subscription = $("#plan_amount_subscription").val();
        }
        else{
        var plan_amount_renewal = $("#plan_amount_renewal").val();
        var plan_amount_subscription = 0;
        }

        var cumulative = parseFloat(plan_amount_sms) + parseFloat(plan_amount_renewal) + parseFloat(plan_amount_subscription);
        $("#plan_amount").val(cumulative);
        $("#plan_amount_actual").val(cumulative);
        $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);
        $("#plan_name_sms").val(data.plan_amount[0].CPE_PLAN_NAME);
        }

        }


});
});
$('#plan_renewal').on('change', function(){
//var optionValue = $(this).val();
//var optionText = $('#dropdownList option[value="'+optionValue+'"]').text();
var token = $('#token').val();
var plan_amount = 0;
var plan_amount = $("#plan_renewal option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/plan/amount",
        data: "&plan_amount=" + plan_amount + "&token=" + token,
        success:function(data){

        var sub_ren = $("#payment_for_values").val();
        if (plan_amount == 0 || sub_ren == 0){
        $("#plan_name_renewal").val('None');
        $("#plan_amount_renewal").val(0);
        var plan_amount_renewal = 0;
        }
        else{
        $("#plan_name_renewal").val(data.plan_amount[0].CPE_PLAN_NAME);
        $("#plan_amount_renewal").val(data.plan_amount[0].CPE_AMOUNT);
        var plan_amount_renewal = data.plan_amount[0].CPE_AMOUNT;
        }

        var plan_amount_subscription = 0;
        var plan_amount_sms = $("#plan_amount_sms").val();
        var cumulative = parseFloat(plan_amount_sms) + parseFloat(plan_amount_renewal) + parseFloat(plan_amount_subscription);
        $("#plan_amount").val(cumulative);
        $("#plan_amount_actual").val(cumulative);
        // $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);

        }
});
});
var scntDiv = $('#p_scents');
var i = $('#p_scents p').length + 1;
$('#addScnt').on('click', function(e) {
e.preventDefault();
$('<p><label for="p_scnts"><input type="text" id="p_scnt_' + i + '" size="20" name="p_scnt_' + i + '" value="" placeholder="Input Value" /></label> \n\
<input class="remScnt" type="button" value="Remove" /></p>').appendTo(scntDiv);
i++;
return false;
});
$('#p_scents').on('click', '.remScnt', function(e) {
e.preventDefault();
if (i > 2) {
$(this).parents('p').remove();
i--;
}
return false;
});
$('.select2').select2({
    tags: true,
            createSearchChoice : function(term){
            return false;
            }
});
});


</script>












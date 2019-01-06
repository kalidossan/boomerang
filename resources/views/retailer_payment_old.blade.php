@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form method="GET" id="form_registration" action="{{ url('retailer-payment-for') }}">

            <div class="col-sm-4 panel">

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" value="{{csrf_token()}}" id="token" name="_token" />

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-sm-4 panel">

                <div class="pending-block">
                Pending Amount <input type="text" id="workorder_pending_amount" disabled="disabled">
                </div>

                <div class="form-group">
                    <div class="title">Mobile No</div>
                    <input type="text" autocomplete="off" class="form-control retailer_payment" id="mobile" name="mobile" value="{{ old('mobile') }}"/>
                </div>

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
                    <div class="title">Payment For</div> 
                    <select class="form-control select2  payment_for" multiple="multiple" name="payment_for" id="payment_for"  >
                        @foreach($payment_for as $pay_for)
                        <option value="{{$pay_for->CRPF_ID}}">{{$pay_for->CRPF_FOR}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="payment_for_values" name="payment_for_values"/>
                </div>
                
                
                 <div class="form-group sub_ren">
                    <div class="title">Subscription</div> 

                    <select class="form-control select2  plan_subscription"  name="plan_subscription" id="plan_subscription"  >
                        <option value="0">Select Subscription </option>
                        @foreach($plan_subscription as $plan_entry)
                        <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="plan_amount_subscription" value="0" name="plan_amount_subscription"/>
                    <input type="hidden" id="plan_name_subscription" value="0" name="plan_name_subscription"/>
                </div>
                
                 <div class="form-group sub_ren">
                    <div class="title">Renewal</div> 

                    <select class="form-control select2  plan_renewal"  name="plan_renewal" id="plan_renewal"  >
                        <option value="0">Select Renewal Plan </option>
                        @foreach($plan_renewal as $plan_entry)
                        <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                        @endforeach
                    </select>

                    <input type="hidden" id="plan_amount_renewal" value="0" name="plan_amount_renewal"/>
                    <input type="hidden" id="plan_name_renewal" value="0" name="plan_name_renewal"/>
                </div>
                
                
                <div class="form-group">
                    <div class="title">SMS PACK</div> 

                    <select class="form-control select2  plan_sms"  name="plan_sms" id="plan_sms"  >
                        <option value="0">Select SMS Pack </option>
                        @foreach($plan_sms as $plan_entry)
                        <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="plan_amount_sms" value="0" name="plan_amount_sms"/>
                    <input type="hidden" id="plan_name_sms" value="0" name="plan_name_sms"/>
                </div>
                <!--                <h2><a href="#" id="addScnt">Select Another Plan</a></h2>
                
                                <div id="p_scents">
                                    <p>
                                        <label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt" value="" placeholder="Input Value" /></label>
                                    </p>
                                </div>-->


               

                <div class="form-group">
                    <div class="title">Amount</div> 
                    <input type="text" id="plan_amount" name="plan_amount" value="0"/>
                    <input type="hidden" id="plan_amount_actual" name="plan_amount_actual"/>

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
                    <div class="title">Payment Reference No</div>
                    <input type="text" autocomplete="off" class="form-control payment_reference_no" id= "payment_reference_no" name="payment_reference_no" value="{{ old('payment_reference_no') }}"/>
                </div>

                <div class="form-group">
                    <div class="title">Bank </div>
                    <input type="text" autocomplete="off" class="form-control bank" id= "bank" name="bank" value="{{ old('bank') }}"/>
                </div>

                <div class="form-group">

                    <select name="payment_verification" id="payment_verification" required="required" >
                        <option value="1">Verified</option>
                        <option value="2">Not Verified</option>
                    </select>

                </div>


                <input type="hidden" id="plan_type" name="plan_type"/>
                <input type="hidden" id="plan_name" name="plan_name"/>
                <div class="form-group">
                    <div class="title">Sales Person</div>
                    <input type="text" autocomplete="off" class="form-control retailer_payment" id= "sales_person" name="sales_person" value="{{ old('sales_person') }}"/>
                </div>
                <div class="form-group">
                    <button id="retailer_registration_submit" type="submit" class="btn btn-primary">Create</button>
                </div>

            </div>




        </form>

    </section>

</div>


<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>

<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({
headers: {'X-CSRF-TOKEN': $('#token').val()}
});
$("#retailer_registration_submit1").click(function(e){
var token = $('#token').val();
e.preventDefault();
$.ajax({
type:'POST',
        url:APP_URL + "/retailer/registration",
        data:$('#form_registration').serialize() + "&token=" + token,
        success:function(data){

        }
});
});
//var plan_amount= [];
// $('#plan_entry option:selected').map(function() {    
//        plan_amount.push($(this).val());
//        
//        alert(plan_amount);
//        
//  });
$(document).ready(function() {

$('#payment_for').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data);
    var payment_for_values = [];
$('#payment_for option:selected').map(function() {
payment_for_values.push($(this).val());
$('#payment_for_values').val(payment_for_values);
});    
alert(payment_for_values);
});

$('#payment_for').on('select2:unselect', function (e) {
    var data = e.params.data;
    console.log(data);
    var payment_for_values = [];
$('#payment_for option:selected').map(function() {
payment_for_values.push($(this).val());
$('#payment_for_values').val(payment_for_values);
});    
});






$("#mobile").on('blur', function() {
var token = $('#token').val();
var mobile = $("#mobile").val();
$.ajax({
type:'get',
        url:APP_URL + "/get/retailer",
        data: "&mobile=" + mobile + "&token=" + token,
        beforeSend: function() {
        $('body').css('opacity', '0.5');
        },
        success:function(data){
        $('body').css('opacity', '1');
        if (data.is_new == 'y'){
        $('input:radio[name="payment_type"][value="0"]').attr('checked', true);
        $("#biz_name").val("");
        $("#biz_id").val("");
        $("#contact_person").val("");
        $("#workorder_pending_amount").val("");
        }
        else{
        $('input:radio[name="payment_type"][value="1"]').attr('checked', true);
        $("#biz_name").val(data.retailer.RET_BIZ_NAME);
        $("#biz_id").val(data.retailer.RET_BIZ_ID);
        $("#contact_person").val(data.retailer.RET_FIRST_NAME);
        $("#workorder_pending_amount").val(data.pending_amount);
        }
        }

});
});


$('#plan_subscription').on('change', function(){
var token = $('#token').val();
var plan_amount = $("#plan_subscription option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/plan/amount",
        data: "&plan_amount=" + plan_amount + "&token=" + token,
        success:function(data){

        $("#plan_amount_subscription").val(data.plan_amount[0].CPE_AMOUNT);
        $("#plan_amount").val(data.plan_amount[0].CPE_AMOUNT);
        $("#plan_amount_actual").val(data.plan_amount[0].CPE_AMOUNT);
        $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);
        $("#plan_name_subscription").val(data.plan_amount[0].CPE_PLAN_NAME);
        }
});
});


$('#plan_sms').on('change', function(){
var token = $('#token').val();
var plan_amount = $("#plan_sms option:selected").val();
$.ajax({
type:'get',
        url:APP_URL + "/plan/amount",
        data: "&plan_amount=" + plan_amount + "&token=" + token,
        success:function(data){

        $("#plan_amount_sms").val(data.plan_amount[0].CPE_AMOUNT);
        var plan_amount_sms = data.plan_amount[0].CPE_AMOUNT;
        var plan_renewal_amount = $("#plan_amount_renewal").val();
        var cumulative = parseFloat(plan_amount_sms) + parseFloat(plan_renewal_amount);
        $("#plan_amount").val(cumulative);
        $("#plan_amount_actual").val(cumulative);
        $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);
        $("#plan_name_sms").val(data.plan_amount[0].CPE_PLAN_NAME);
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
        console.log(data.plan_amount[0].CPE_AMOUNT);
        $("#plan_amount_renewal").val(data.plan_amount[0].CPE_AMOUNT);
        var plan_amount_renewal = data.plan_amount[0].CPE_AMOUNT;
        var plan_amount_sms = $("#plan_amount_sms").val();
        var cumulative = parseFloat(plan_amount_sms) + parseFloat(plan_amount_renewal);
        $("#plan_amount").val(cumulative);
        $("#plan_amount_actual").val(cumulative);
        $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE);
        $("#plan_name_renewal").val(data.plan_amount[0].CPE_PLAN_NAME);
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

@endsection












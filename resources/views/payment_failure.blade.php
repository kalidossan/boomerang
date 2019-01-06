@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <h2>Transaction Fail</h2>
        <div>Transaction id is {{@$CWOP_PAY_REF}}</div> <br/>
        <div>Work Order id is {{@$CWOP_CWO_WO_ID}} </div> 
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
    
    $('#plan_entry').on('change',function(){
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
           $("#plan_amount").val(data.plan_amount[0].CPE_AMOUNT) ;
           $("#plan_type").val(data.plan_amount[0].CPE_PLAN_TYPE) ;
           $("#plan_name").val(data.plan_amount[0].CPE_PLAN_NAME) ;

        }
});
        
    });

});
</script>

@endsection












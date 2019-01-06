@extends('layouts.master')

@section('content')

<div class="slide_container">
          <div class="view">
        <img class="d-block w-100" src="banner.jpg" alt="First slide">
        <div class="mask rgba-black-light">Registration Sign Up</div>
      </div>
</div>
<div class="container">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form method="GET" id="form_registration_sign_up" action="{{ url('/retailer/registration') }}">

            <div class="col-sm-5 panel">


                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" value="{{csrf_token()}}" id="token" name="_token" />

                            <div class="form-group">
                                <div class="title">Business Category</div>
                                <input type="text" autocomplete="off" class="form-control retailer_registration" id="biz_category" name="biz_category" value="{{ old('biz_category') }}"/>
                            </div>

                            <div class="form-group">
                                <div class="title">Business Name</div>
                                <input type="text" autocomplete="off" class="form-control retailer_registration" id="biz_name" name="biz_name" value="{{ old('biz_name') }}"/>
                            </div>

                            <div class="form-group">
                                <div class="title">First Name</div>
                                <input type="text" autocomplete="off" class="form-control retailer_registration" id="first_name" name="first_name" value="{{ old('first_name') }}"/>
                            </div>
                            <div class="form-group">
                                <div class="title">Last Name</div>
                                <input type="text" autocomplete="off" class="form-control retailer_registration" id= "last_name" name="last_name" value="{{ old('last_name') }}"/>
                            </div>
                            <div class="form-group">
                                <div class="title">E-Mail</div>
                                <input type="email" autocomplete="off" class="form-control retailer_registration" id="mail" name="mail" value="{{ old('mail') }}"/>
                            </div>
                            <div class="form-group">
                                <div class="title">Mobile No</div>
                                <input type="mobile" autocomplete="off" class="form-control retailer_registration" id="mobile" name="mobile" value="{{ old('mobile') }}"/>
                            </div>
                               <div class="form-group">
                                <div class="title">GST No</div>
                                <input type="mobile" autocomplete="off" class="form-control retailer_registration" id="gst_no" name="gst_no" value="{{ old('gst_no') }}"/>
                            </div>

                            <div class="form-group">
                                <div class="title">Business Starting Date</div>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input autocomplete="off" name="dos" type="text" value="{{ old('dos') }}" class="form-control pull-right " id="dos" autocomplete="off">
                                </div>

                            </div>

                         

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-sm-5 panel">
                <div class="form-group">
                    <div class="title">Fb Address</div>
                    <input type="text" autocomplete="off" class="form-control retailer_registration" id="fb_id" name="fb_id" value="{{ old('fb_id') }}"/>
                </div>
                <div class="form-group">
                    <div class="title">Instagram ID</div>
                    <input type="text" autocomplete="off" class="form-control retailer_registration" id="instagram_id" name="instagram_id" value="{{ old('instagram_id') }}"/>
                </div>
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
                    <input type="text" autocomplete="off" class="form-control retailer_registration" id="area" name="arae" value="{{ old('area') }}"/>
                </div>
                <div class="form-group">
                    <div class="title">Street </div>
                    <input type="text" autocomplete="off" class="form-control retailer_registration" id="street" name="street" value="{{ old('street') }}"/>
                </div>
                <div class="form-group">
                    <div class="title">Plot/Flat No </div>
                    <input type="text" autocomplete="off" class="form-control retailer_registration" id="flat_no" name="flat_no" value="{{ old('flat_no') }}"/>
                </div>

            </div>
            <div class="col-sm-2 panel">
                <div class="plan_entry_wrapper pull-left">

                    <select class="form-control select2  plan_entry"  name="plan_entry" id="plan_entry"  >
                        @foreach($plan as $plan_entry)
                        <option value="{{$plan_entry->CPE_PLAN_ID}}">{{$plan_entry->CPE_PLAN_NAME}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" id="plan_amount" name="plan_amount"/>
                <input type="hidden" id="plan_type" name="plan_type"/>
                <input type="hidden" id="plan_name" name="plan_name"/>
                <div class="form-group">
                    <button id="retailer_registration_submit" type="submit" class="btn btn-primary">Sign Up</button>
                </div>
            </div>



        </form>

    </section>

</div>
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
        data:$('#form_registration_sign_up').serialize() + "&token=" + token,
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












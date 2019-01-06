@extends('layouts.master')
@section('content')
<div class="content-wrapper">
                 

    <section class="content">
        <div class="box box-default center">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <br/>
            @endif
            @if(Session::has('success'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
            @endif
            
            <div class="col-sm-3 panel">
                @include('customer')
            </div>
            <div class="col-sm-6 panel" >
                <div id="scheduler_message_reports" class="scheduler">	
                    <ul  class="nav nav-pills tab" id="tabMenu">
                        <li class="active">
                            <a  href="#scheduler" data-toggle="tab">Scheduler</a>
                        </li>
                        <li><a href="#message" data-toggle="tab">Message Center</a>
                        </li>
                        <li><a href="#reports" data-toggle="tab">Reports</a>
                        </li>
                    </ul>

                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="scheduler">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Scheduler </div>
                                        <div class="panel-body">
                                            {!! $calendar->calendar() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="message">
                            @include('message_center')
                        </div>
                        <div class="tab-pane" id="reports">
                            @include('retailer_report')
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-3 panel">
                @include('recent_update')
            </div>
        </div>
        <!-- /.box -->
    </section>
</div>
@include('retailer_modals')
<!-- /.content -->

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.full.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.min.js')!!}"></script>

{!! $calendar->script() !!}

<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#token').val()

        }

});
$("#mc_submit").click(function(e){
e.preventDefault();
var msg_type = $("#message_type option:selected").val();
var msg_typ = $("#message_type option:selected").text();
$(".preview_message_type").text(msg_typ);
$("#preview_message_type").val(msg_type);
var msg_title = $("#message_title").val();
$(".preview_message_title").html(msg_title);
var msg_txt = $.trim($("#msg_txt").val());
$(".preview_message_txt").text(msg_txt);
var p_valid_till_time = $("#valid_till_time").val();
$(".preview_valid_till_time").html(p_valid_till_time);
var preview_valid_till = $("#valid_till").val();
$(".preview_valid_till").html(preview_valid_till);
var preview_gender = $("input[name='gender_group']:checked").val();
$("#preview_gend_type").val(preview_gender);
if (preview_gender == 0){
$(".preview_gender").text("Male");
}
else if (preview_gender == 1)
{
$(".preview_gender").text("Female");
}
else{
$(".preview_gender").text("Both");
}
var preview_cust_pros_target = $("input[name='cust_pros_target']:checked").val();
$("#preview_cust_type").val(preview_cust_pros_target);
if (preview_cust_pros_target == 0){
$(".preview_cust_pros_target").text("Customer");
}
else if (preview_cust_pros_target == 1)
{
$(".preview_cust_pros_target").text("Prospect");
}
else{
$(".preview_cust_pros_target").text("Both");
}

var mc_category_name = [];
var mc_category_name_id = [];
var mc_category_values = [];
var mc_category_values_id = [];
$('.category_wrapper  div.title').map(function() {
mc_category_name.push($(this).text());
var name = $(this).attr('name');
mc_category_name_id.push(name);
});
$('.mc_category_values option:selected').map(function() {
mc_category_values.push($(this).text());
mc_category_values_id.push($(this).val());
});
$("#p_mc_category_values_id").val(mc_category_values_id);
$(".p_mc_category_values").text(mc_category_values);
$("#preview_mc_category_name_id").val(mc_category_name_id);
$(".preview_mc_category_name").text(mc_category_name);
//$('[class^="mc_category_values"]')

$('.msg_preview').modal('show');
});
$("#create_message").click(function(e){

var token = $('#token2').val();
var c_valid_till = $('.preview_valid_till').text();
var c_valid_till_time = $('.preview_valid_till_time').text();
var c_message_type = $('#preview_message_type').val();
var c_msg_txt = $('.preview_message_txt').text();
var c_message_title = $('.preview_message_title').text();
var c_gender_group = $('#preview_gend_type').val();
var c_mc_category_name_id = $('#preview_mc_category_name_id').val();
var c_cust_pros_target = $('#preview_cust_type').val();
var c_mc_category_values_id = $('#p_mc_category_values_id').val();
$.ajax({

type:'GET',
        url:APP_URL + "/create/message",
        data:{
        c_valid_till:c_valid_till,
                c_valid_till_time:c_valid_till_time,
                c_message_type:c_message_type,
                c_msg_txt:c_msg_txt,
                c_message_title:c_message_title,
                c_gender_group:c_gender_group,
                c_mc_category_name_id:c_mc_category_name_id,
                c_cust_pros_target:c_cust_pros_target,
                c_mc_category_values_id:c_mc_category_values_id

        },
        success:function(data){
        }
});
});
$("#submit").click(function(e){

var gender = $("input[name='gender']:checked").val();
var customer = $("input[name='customer']:checked").val();
e.preventDefault();
$.ajax({

type:'POST',
        url:APP_URL + "/create/customer",
        data:$('#form').serialize() + "&gender=" + gender + "&customer=" + customer,
        success:function(data){
        //$('.first_name').text(data.errors.first_name);
        //  $('.first_name').text(data.errors.first_name);
        $('#myModal').modal('show');
        }
});
});
$(document).on('click', '#message_history', function (event){
event.preventDefault();
$.ajax({
type:'GET',
        url:APP_URL + "/message_history",
        success:function(data){
        $("#message").html(data);
        $('.select2').select2({  tags: true,
            createSearchChoice : function(term){
            return false;
            }
            
        });
        }
});
});
$(document).on('click', '#message_center', function (event) {
event.preventDefault();
$.ajax({
type:'GET',
        url:APP_URL + "/message_center",
        success:function(data){
        $("#message").html(data);
        $('.select2').select2({  tags: true,
            createSearchChoice : function(term){
            return false;
            }
        });
        }
});
});
function countChar(val) {
var len = val.value.length;
if (len >= 320) {
val.value = val.value.substring(0, 500);
} else {
$('#charNum').text(320 - len);
}
};
$(document).ready(function() {

$("#mobile").on('blur', function() {
var token = $('#token').val();
var mobile = $("#mobile").val();
$.ajax({
type:'get',
        url:APP_URL + "/get/customer",
        data: "&mobile=" + mobile + "&token=" + token,
        beforeSend: function() {
        $('body').css('opacity', '0.5');
        },
        success:function(data){

        console.log(JSON.stringify(data));
        $('body').css('opacity', '1');
        if (data.is_new == 'y'){
        $("#first_name").val('');
        }
        else{

        $("#first_name").val(data.customer.CCM_FIRST_NAME);
        $("#last_name").val(data.customer.CCM_LAST_NAME);
        $("#mail").val(data.customer.CCM_EMAIL_ID);
        d1 = new Date(Date.parse(data.customer.CCM_DOB));
        var dob = $.datepicker.formatDate('mm/dd/yy', d1);
        d2 = new Date(Date.parse(data.customer.CCM_DOA));
        var doa = $.datepicker.formatDate('mm/dd/yy', d2);
        $("#dob").val(dob);
        $("#doa").val(doa);
        if (data.customer.CCM_GENDER == 0){
        $('input:radio[name="gender"][value="0"]').attr('checked', true);
        }
        else{
        $('input:radio[name="gender"][value="1"]').attr('checked', true);
        }

        if (data.cust_type == 0){
        $('#cust_pros option[value="0"]').prop('selected', true);
        }
        else if (data.cust_type == 1){
        $('#cust_pros option[value="1"]').prop('selected', true);
        }
        else{
        $('#cust_pros option[value="2"]').prop('selected', true);
        }

        }
        }

});
});
$('.select2').select2({  tags: true,
            createSearchChoice : function(term){
            return false;
            }
});
});
</script>



@endsection








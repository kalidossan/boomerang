<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.full.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.min.js')!!}"></script>

{!! $calendar->script() !!}

<script type="text/javascript">
    /*** select style ***/

    function EventMessages(el){
    var x, i, j, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName(el);
    for (i = 0; i < x.length; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 0; j < selElmnt.length; j++) {
    /*for each option in the original select element,
     create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
    /*when an item is clicked, update the original select box,
     and the selected item:*/
    var y, i, k, s, h;
    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
    h = this.parentNode.previousSibling;
    for (i = 0; i < s.length; i++) {
    if (s.options[i].innerHTML == this.innerHTML) {
    s.selectedIndex = i;
    h.innerHTML = this.innerHTML;
    if (el == "custom-select"){
    y = this.parentNode.getElementsByClassName("same-as-selected");
    }
    else{
    y = this.parentNode.getElementsByClassName("selected-report");
    }



    for (k = 0; k < y.length; k++) {
    y[k].removeAttribute("class");
    }
    this.setAttribute("class", "same-as-selected");
    this.setAttribute("id", i);
    break;
    }
    }
    h.click();
    });
    b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
    /*when the select box is clicked, close any other select boxes,
     and open/close the current select box:*/
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
    });
    }
    }


    function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
     except the current select box:*/
    var x, y, i, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
    arrNo.push(i)
    } else {
    y[i].classList.remove("select-arrow-active");
    }
    }
    for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
    x[i].classList.add("select-hide");
    }
    }
    }
    /*if the user clicks anywhere outside the select box,
     then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
    var APP_URL = {!! json_encode(url('/')) !!};
    $.ajaxSetup({

    headers: {

    'X-CSRF-TOKEN': $('#token').val()

    }

    });
    $(document).on('submit', '#mc_form', function (e){
    e.preventDefault();
    var msg_type = $("#message_type option:selected").val();
    var msg_typ = $("#message_type option:selected").text();
    $(".preview_message_type").text(msg_typ);
    $("#preview_message_type").val(msg_type);
    var msg_title = $("#message_title").val();
    if (msg_title != ''){
    $(".preview_message_title").html(msg_title);
    }
    else{
    $(".preview_message_title").html('<div class="error">Enter Message Title</div>');
    }
    var msg_txt = $.trim($("#msg_txt").val());
    if (msg_txt != ''){
    $(".preview_message_txt").text(msg_txt);
    }
    else{

    $(".preview_message_txt").html('<div class="error">Enter Text Message</div>');
    }

    var p_valid_till_time = $("#valid_till_time").val();
    $(".preview_valid_till_time").html(p_valid_till_time);
    var preview_valid_till = $("#valid_till").val();
    if (preview_valid_till != '')
    {
    $(".preview_valid_till").html(preview_valid_till);
    }
    else{
    $(".preview_valid_till").html('<div class="error">Enter valid till date</div>');
    }

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


    var values = new Array();
    $('.wrapper_category').map(function() {

    var label = $(this).find('.title').text();
    values[label] = new Array();
    $(this).find('option:selected').map(function() {

    if ($(this).text() !== null){
    values[label].push($(this).text());
    }

    });
    });
    var result = "";
    for (var p in values) {
    if (values.hasOwnProperty(p)) {
    if (values[p] != ''){
    result += p + " : " + values[p] + "<br/>";
    }
    }
    }

    if (result != ''){
    $('.preview_selected_categories').html(result);
    }
    else{
    $('.preview_selected_categories').html("<h3>No Category selected</h3>");
    }
    console.log(result);
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

    if ($("#msg_txt").val() == '' || $("#message_title").val() == ''){
    $('#msg_preview_error_msg').html('Please Check above and submit');
    return false;
    }
    e.preventDefault();
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
            beforeSend: function() {
            $('body').css('opacity', '0.3');
            $('.loader-wrapper').show();
            },

            success:function(data){
            $('body').css('opacity', '1');
            $('.loader-wrapper').hide();
            $('#msg_preview_msg').html('Successfully Saved');
            setTimeout(function(){
            $('.msg_preview').modal('hide');
            }, 2000);
            $("#mc_form").trigger('reset');
            $("#mc_form [id*='mc_category_']").select2().val([""]).trigger('change.select2');
            $("#charNum").text("");
            }
    });
    });
    $(document).on('click', '#message_history', function (event){
    event.preventDefault();
    $.ajax({
    type:'GET',
            url:APP_URL + "/message_history",
            success:function(data){
            $("#msg-cntr").html(data);
            $('.select2').select2({
            tags: true,
                    createSearchChoice : function(term){
                    return false;
                    }
            });
            }
    });
    });
    $(document).on('submit', '#password_reset_update', function (event){
    event.preventDefault();
    $.ajax({
    type:'GET',
            url:APP_URL + "/password_reset",
            data:$('#password_reset_update').serialize(),
             beforeSend: function() {
            $('body').css('opacity', '0.3');
            $('.loader-wrapper').show();
            },
            success:function(data){
                 $('body').css('opacity', '1');
            $('.loader-wrapper').hide();
                alert("Password Saved Successfully");

            }
    });
    });
     $(document).on('submit', '#sender_id_block', function (event){
    event.preventDefault();
    $.ajax({
    type:'GET',
            url:APP_URL + "/sender_id",
            data:$('#sender_id_block').serialize(),
             beforeSend: function() {
            $('body').css('opacity', '0.3');
            $('.loader-wrapper').show();
            },
            success:function(data){
                 $('body').css('opacity', '1');
            $('.loader-wrapper').hide();
                alert("SenderID Request Sent Successfully ");

            }
    });
    });
    
    $(document).on('click', '#message_center', function (event) {
    event.preventDefault();
    $.ajax({
    type:'GET',
            url:APP_URL + "/message_center",
            success:function(data){
            $("#msg-cntr").html(data);
            $('#valid_till').datepicker({
            autoclose:true,
            });
            $('#valid_till_time').timepicker({
            autoclose:true,
            });
            $('.select2').select2({  tags: true,
                    createSearchChoice : function(term){
                    return false;
                    }
            });
            }
    });
    });
    $(document).on('click', '#bulk_upload_submit1', function (event) {
    event.preventDefault();
    var file_data = document.getElementById('bulk_upload_file').files[0]; //$('#bulk_upload_file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    alert(form_data);
    $.ajax({
    url:APP_URL + "/import", // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response){
            $('#bulk_upload_customer').load(location.href + ' #bulk_upload_customer');
            }
    });
    });
    $(document).on('click','.retailer_response',function(e){
    e.preventDefault();
    var $tr = $(this).closest('tr');
    var token = $('#retailer_response_token').val();
    var retailer_response_id = $(this).parents('tr').find('.retailer_response_id').val();
    var retailer_response_text = $(this).parents('tr').find('.retailer_response_text').val();
    $.ajax({
    type:'GET',
            url:APP_URL + "/retailer_reponse",
            data:{retailer_response_text:retailer_response_text,retailer_response_id:retailer_response_id, token:token},
            success:function(data){
            $tr.find('td').fadeOut(1000, function(){
            $tr.remove();
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
    /* Customer Form Registration */

    $(document).on('submit', '#form', function(e){

    var gender = $("input[name='gender']:checked").val();
    var customer = $("input[name='customer']:checked").val();
    var visit = $('#visit_count').text();
    var token = $('#form_token').val();
    var cust_category_name = [];
    var cust_category_name_id = [];
    var cust_category_values = [];
    var cust_category_values_id = [];
    $('.reg_category_wrapper  div.title').map(function() {
    cust_category_name.push($(this).text());
    var name = $(this).attr('name');
    cust_category_name_id.push(name);
    });
    $('.reg_category_values option:selected').map(function() {
    cust_category_values.push($(this).text());
    cust_category_values_id.push($(this).val());
    });
    var _token = $("input[name='form_token']").val();
    var category_values_id = cust_category_values_id.toString();
    // if (category_values_id.length == 0)
    // {
    // $('#custModal').modal('show');
    // return false;
    // }

    e.preventDefault();
    $.ajax({

    type:'get',
            url:APP_URL + "/create/customer",
            data: $('#form').serialize() + "&visit=" + visit + "&gender=" + gender + "&customer=" + customer + "&category_values_id=" + category_values_id +
            "&_token=" + _token,
            success:function(data){


            console.log(JSON.stringify(data));
            $('.success').html(data.success).prepend(' <i class="fa fa-check"></i>');
            if (data.CCM_CUST_PROS_TYPE == '1'){
            $('.customer').html('Customer');
            }
            else{
            $('.customer').html('Prospect');
            }


            if (data.ccm_gender == '0'){
            $('.customer_gender').html('Male').prepend(':  ');
            }
            else{
            $('.customer_gender').html('Female').prepend(':  ');
            }

            $('.first_name').html(data.ccm_first_name).prepend(':  ');
            $('.mobile_no').html(data.ccm_mobile_no).prepend(':  ');
            $('.customer_email').html(data.ccm_email_id).prepend(':  ');
            $('#myModal').modal('show');
            $("#form").trigger('reset');
            $("[id*='reg_category_']").select2().val([""]).trigger('change.select2');
            $('#retailer_response_block').load(location.href + ' #retailer_response_block');
            },
            error: function (data) {
            alert("Customer Not Saved successfully");
            },
    });
    });
    $(document).on('click', '.send-again', function(e){
    e.preventDefault();
    var _token = $('#msg_history_token').val();
    var msg_history_id = $(this).parents('tr').find('.msg_history_id').val();
    $.ajax({
    type:'GET',
            url:APP_URL + "/message_center",
            data:{msg_history_id:msg_history_id, _token:_token},
            success:function(data){
            $("#msg-cntr").html(data);
            $('#valid_till').datepicker({
            autoclose:true,
            });
            $('#valid_till_time').timepicker({
            autoclose:true,
            });
            $('.select2').select2({  tags: true,
                    createSearchChoice : function(term){
                    return false;
                    }
            });
            },
            complete:function(data){
            $.ajax({
            type:'GET',
                    url:APP_URL + "/mc_category_values",
                    data:{msg_history_id:msg_history_id, _token:_token},
                    success:function(data){
                    var mc_category_values = data.mc_category_values;
                    mc_category_values.forEach(function(obj) {
                    var clabel = obj.CMCV_CCM_LABEL_NAME;
                    var cvalue = obj.CMCV_CCVM_VALUE;
                    var array = cvalue.split(",").map(Number);
                    $("#mc_category_" + clabel).select2("val", [array]);
                    });
                    }
            });
            }
    });
    });
    $(document).on('blur', '#mobile', function(e) {
    var token = $('#token').val();
    var mobile = $("#mobile").val();
    if (mobile.length != 10 || isNaN(mobile))
    {
    $("#mobile").css("border-color", "red");
    $(this).attr("placeholder", "Please Enter Valid 10 digit Mobile No");

    setTimeout(function () {
        $("#mobile").css("border-color", "#ccc");
    }, 5000);
    }
    else{
    $("#mobile").css("border-color", "#ccc");
    }
    e.preventDefault();
    $.ajax({
    type:'get',
            url:APP_URL + "/get/customer",
            data: "&mobile=" + mobile + "&token=" + token,
            beforeSend: function() {
            $("[id*='reg_category_']").select2().val([""]).trigger('change.select2');
            $('input:radio[name="gender"][value="0"]').attr('checked', false);
            $('input:radio[name="gender"][value="1"]').attr('checked', false);
            $('body').css('opacity', '0.3');
            $('.loader-wrapper').show();
            },
            success:function(data){

            console.log(JSON.stringify(data));
            $('.loader-wrapper').hide();
            $('body').css('opacity', '1');
            if (data.is_new == 'y'){
            var cust_mob = $("#mobile").val();
            $("#form").trigger('reset');
            $("#mobile").val(cust_mob);
            $("[id*='reg_category_']").select2().val([""]).trigger('change.select2');
            $('input:radio[name="gender"][value="0"]').attr('checked', false);
            $('input:radio[name="gender"][value="1"]').attr('checked', false);
            }
            else{

            $("#first_name").val(data.existing_customer.CCM_FIRST_NAME);
            $("#last_name").val(data.existing_customer.CCM_LAST_NAME);
            $("#mail").val(data.existing_customer.CCM_EMAIL_ID);
            d1 = new Date(Date.parse(data.existing_customer.CCM_DOB));
            var dob = $.datepicker.formatDate('mm/dd/yy', d1);
            d2 = new Date(Date.parse(data.existing_customer.CCM_DOA));
            var doa = $.datepicker.formatDate('mm/dd/yy', d2);
            $("#dob").val(dob);
            $("#doa").val(doa);
            if (data.existing_customer.CCM_GENDER == 0){
            $('input:radio[name="gender"][value="0"]').attr('checked', true);
            }
            else{
            $('input:radio[name="gender"][value="1"]').attr('checked', true);
            }

            if (data.others == 'n'){

            if ($('.visit_count').val() == '1') {
            $("#visit_count").text(data.visit);
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

            //console.log(data.cust_category_values);

            var category_values = data.cust_category_values;
            
            category_values.forEach(function(obj) {
            var clabel = obj.CCCV_LABEL;
            var cvalue = obj.CCCV_VALUE;
            var array = cvalue.split(",").map(Number);
            $("#reg_category_" + clabel).select2("val", [array]);
            });
            }
            else{

            }
            }
            $('#retailer_response_block').load(location.href + ' #retailer_response_block');

            }

    });
    });
//$('.events_festival').on('change',function(e){

    $(document).on('click', '.custom-select', function (e){

    //var is_event  = $('.events_festival option:selected').val();

    var is_event = $('.same-as-selected').attr('id');
    if (is_event != 0){

    $('.valid-till .valid-date').html('Valid Till');
    }
    else{
    $('.valid-till .valid-date').html('Valid From');
    }

    });
    $(document).ready(function() {


    $('.visit_count').click(function(){
    if ($(this).prop("checked") == true){
    $(this).val(1);
    }
    else if ($(this).prop("checked") == false){
    $(this).val(0);
    }
    });
    $('.select2').select2({ tags: true,
            createSearchChoice : function(term){
            return false;
            } });
    });
    function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.select = this.dd.children('#select_index');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = - 1;
    this.initEvents();
    }
    DropDown.prototype = {
    initEvents : function() {
    var obj = this;
    obj.dd.on('click', function(event){
    $(this).toggleClass('active');
    return false;
    });
    obj.opts.on('click', function(){

    var opt = $(this);
    $(this).addClass('active-report');
    obj.val = opt.text();
    obj.index = opt.index();
    obj.placeholder.text(obj.val);
    obj.select.text(obj.index);
    $(this).attr('id', obj.val);
    if (obj.index == 0){
    $.ajax({
    type:'GET',
            url:APP_URL + "/sms_retailer_report",
            success:function(data){
            $("#customer_report").html(data);
            $('.select2').select2({  tags: true,
                    createSearchChoice : function(term){
                    return false;
                    }
            });
            }
    });
    }
    else if (obj.index == 1){
    $.ajax({
    type:'GET',
            url:APP_URL + "/payment_retailer_report",
            success:function(data){
            $("#customer_report").html(data);
            $('#customer_report_grid').DataTable();
            $('.select2').select2({  tags: true,
                    createSearchChoice : function(term){
                    return false;
                    } });
            }

    });
    }
    else{
    $.ajax({
    type:'GET',
            url:APP_URL + "/customer_retailer_report",
            success:function(data){
            $("#customer_report").html(data);
            $('#customer_report_grid').DataTable();
            $('.select2').select2({  tags: true,
                    createSearchChoice : function(term){
                    return false;
                    } });
            }

    });
    }


    });
    },
            getValue : function() {
            return this.val;
            },
            getIndex : function() {
            return this.index;
            }
    }

    $(function() {

    var dd = new DropDown($('#dd'));
    var eventMessage = new EventMessages('custom-select');
    // var selectReport = new EventMessages('select-report');

    $(document).click(function() {
    // all dropdowns
    $('.wrapper-dropdown-3').removeClass('active');
    });
    });

</script>
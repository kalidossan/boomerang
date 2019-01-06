<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Boomerang') }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.css')}}">
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">

        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue.min.css')}}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css')}}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css')}}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{  asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

        <link rel="stylesheet" href="{{  asset('plugins/timepicker/bootstrap-timepicker.css')}}">

        <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <div style="display: none" class="loader-wrapper">
                <div class="loader"> </div>
            </div>

            @include('header')
            <!-- Left side column. contains the logo and sidebar -->

            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                @include('footer')
            </footer>
        </div>

        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- Morris.js charts -->
        <script src="{{ asset('bower_components/raphael/raphael.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
        <!-- jvectormap -->
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <!-- datepicker -->
        <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.js')}}"></script>

        <!-- Slimscroll -->
        <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{ asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('dist/js/demo.js')}}"></script>


        <script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

        <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
        <script src="{{ asset('bower_components/select2/dist/js/select2.min.js')}}"></script>


        <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')}}"> 

        <script type="text/javascript">
$('#reset').click(function () {
    $(':input', '#myform')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
});

$('#dob').datepicker({
    autoclose: true,
});
$('#doa').datepicker({
    autoclose: true,
});
$('#dos').datepicker({
    autoclose: true,
});
$('#exp_dte, #datepicker1, #datepicker2').datepicker({
    autoclose: true,
});

$(document).ready(function() {
    $('#customer_report_grid').DataTable();
    
       $('.select2').select2({ 
                    createSearchChoice : function(term){
                    return false;
                    }
            });
});


  $(document).on('submit', '#customer-report-filter', function (event){
    event.preventDefault();
    alert($('#customer-report-filter').serialize());
     $.ajax({
    type:'GET',
    data: $('#customer-report-filter').serialize(),
            url:APP_URL + "/customer_retailer_report",
            success:function(data){
            $("#customer_report").html(data);
            $('.select2').select2({  tags: true,
                    createSearchChoice : function(term){
                    return false;
                    }
            });
            }
    });
    });


$(document).on('click', '.configuration-panel', function (event) {
    event.preventDefault();
    $.ajax({
        type: 'GET',
        url: APP_URL + "/configuration/panel",
        success: function (data) {
            $("#main-panel").html(data);
        }
    });
});
$(document).on('click', '.messge-center-panel1', function (event) {
    event.preventDefault();
    $.ajax({
        type: 'GET',
        url: APP_URL + "/mc/panel",
        success: function (data) {
            $("#main-panel").html(data);
        }
    });
});
$(document).on('change', '#retailers_list', function (event) {

    var retailer = $("#retailers_list option:selected").val();
    event.preventDefault();
    $.ajax({
        type: 'GET',
        url: APP_URL + "/set/biz",
        data: {retailer: retailer},
        success: function (data) {
            $('#retailers_list option[value="' + data.biz_id + '"]').prop('selected', true);
            location.replace(APP_URL + "/retailer");
        }
    });
});
$(document).on('change', '#pro_reg_mobile', function (e) {

    e.preventDefault();
    var token = $('#profile_token').val();
    var mobile = $("#pro_reg_mobile option:selected").val();
    $.ajax({
        type: 'GET',
        url: APP_URL + "/get/retailer",
        data: "&token=" + token + "&mobile=" + mobile,
        success: function (data) {


            if (data.is_new !== 'y') {


                if (data.sender_id == null) {
                    $("#pro_sender_id").text('----');
                } else {
                    $("#pro_sender_id").text(data.sender_id);
                }


                if (data.retailer.RET_BIZ_CATEGORY == null) {
                    $("#pro_biz_category").text('----');
                } else {
                    $("#pro_biz_category").text(data.retailer.RET_BIZ_CATEGORY);
                }

                if (data.retailer.RET_BIZ_NAME == null) {
                    $("#pro_reg_biz_name").text('----');
                } else {

                    $(".biz-name").text(data.retailer.RET_BIZ_NAME);
                    $("#pro_reg_biz_name").text(data.retailer.RET_BIZ_NAME);
                }

                if (data.retailer.RET_FIRST_NAME == null) {

                    $("#pro_first_name").text('----');
                } else {

                    $("#pro_first_name").text(data.retailer.RET_FIRST_NAME);
                }


                if (data.retailer.RET_LAST_NAME == null) {
                    $("#pro_last_name").text('----');
                } else {
                    $("#pro_last_name").text(data.retailer.RET_LAST_NAME);
                }


                if (data.retailer.RET_EMAIL_ID == null) {
                    $("#pro_mail").text('----');
                } else {
                    $("#pro_mail").text(data.retailer.RET_EMAIL_ID);
                }


                if (data.retailer.RET_BIZ_START_DT == null) {
                    $("#pro_dos").text('----');
                } else {
                    d1 = new Date(Date.parse(data.retailer.RET_BIZ_START_DT));
                    var dos = $.datepicker.formatDate('mm/dd/yy', d1);
                    $("#pro_dos").text(dos);
                }


                if (data.retailer.RET_CREATED_DT == null) {
                    $("#pro_registration").text('----');
                } else {


                    d2 = new Date(Date.parse(data.retailer.RET_CREATED_DT));
                    var dor = $.datepicker.formatDate('mm/dd/yy', d2);
                    $("#pro_registration").text(dor);
                }


                if (data.retailer.RET_GST_NUMBER == null) {
                    $("#pro_gst_no").text('----');
                } else {
                    $("#pro_gst_no").text(data.retailer.RET_GST_NUMBER);
                }

                if (data.retailer.RET_FB_ID == null) {
                    $("#pro_fb_id").text('----');
                } else {
                    $("#pro_fb_id").text(data.retailer.RET_FB_ID);
                }

                if (data.retailer.RET_INSTA_ID == null) {
                    $("#pro_instagram_id").text('----');
                } else {
                    $("#pro_instagram_id").text(data.retailer.RET_INSTA_ID);
                }

                if (data.retailer.RET_PINCODE == null) {
                    $("#pro_pincode").text('----');
                } else {
                    $("#pro_pincode").text(data.retailer.RET_PINCODE);
                }


                if (data.retailer.RET_STATE_NAME == null) {
                    $("#pro_state").text('----');
                } else {
                    $("#pro_state").text(data.retailer.RET_STATE_NAME);
                }

                if (data.retailer.RET_CITY_NAME == null) {
                    $("#pro_city").text('----');
                } else {
                    $("#pro_city").text(data.retailer.RET_CITY_NAME);
                }


                if (data.retailer.RET_AREA_NAME == null) {
                    $("#pro_area").text('----');
                } else {
                    $("#pro_area").text(data.retailer.RET_AREA_NAME);
                }


                if (data.retailer.RET_STREET_NAME == null) {
                    $("#pro_street").text('----');
                } else {
                    $("#pro_street").text(data.retailer.RET_STREET_NAME);
                }

                if (data.retailer.RET_FLAT_NO == null) {
                    $("#pro_flat_no").text('----');
                } else {
                    $("#pro_flat_no").text(data.retailer.RET_FLAT_NO);
                }



            }

        }
    });

});

$(document).ready(function () {
    $('#grid').DataTable();
    $('#valid_till').datepicker({
        autoclose: true,
    });
    $('.valid-till-date').datepicker({
        autoclose: true,
    });

    $('#valid_till_time').timepicker({
        autoclose: true,
    });
});



        </script>


    </body>
</html>
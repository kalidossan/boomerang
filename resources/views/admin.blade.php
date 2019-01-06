@extends('layouts.master')
@section('content')
@include('admin_css')
<div class="content-wrapper">
    <section class="content">
           
            <div class="col-sm-12 panel"> 

<div class="">
    <div class="row">
        <div class="col-lg-12 col-md-5 col-sm-8 col-xs-12 bhoechie-tab-container">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
                <div class="list-group">
                <a href="#" class="list-group-item active text-center">
                  <h4 class="glyphicon glyphicon-home"></h4><br/>Registration
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="glyphicon glyphicon-credit-card"></h4><br/>Payment
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="glyphicon glyphicon-envelope"></h4><br/>Message Moderator
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="glyphicon glyphicon-pencil"></h4><br/>Plan Entry
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="glyphicon glyphicon-credit-card"></h4><br/>Customers Verification
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="glyphicon glyphicon-picture"></h4><br/>Content Panel
                </a>
               
                <a href="#" class="list-group-item text-center">
                    
                  <h4 class="glyphicon glyphicon-user"></h4><br/>Profile
                </a>
                <a href="#" class="list-group-item text-center">
                    
                  <h4 class="glyphicon glyphicon-signal"></h4><br/>Reports
                </a>
              </div>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-9 col-xs-10 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">
                     <center>
                      <h3 style="margin-top: 0;color:#337ab7">Retailer Registration</h3>
                       @include('retailer_registration')
                    </center>
                    
                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#337ab7">Payment</h3>
                       <div class="admin_pay_form">@include('retailer_payment')</div>
                    </center>
                </div>
    
                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#337ab7">Message Moderator</h3>
                       @include('message_moderator')
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#337ab7">Our Plans</h3>
                      <div class="our-plans">@include('plan_entry')</div>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#337ab7">Customer Verification</h3>
                    </center>
                    @include('customer_verification')

                </div>
                  <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#337ab7">Slide Show</h3>
                      @include('front_view')
                    </center>
                     <center>
                      <h3 style="margin-top: 0;color:#337ab7">Alerts & Recent Updates</h3>
                      @include('admin_recent_update')
                    </center>
                </div>
             
                <div class="bhoechie-tab-content">
                    <center>
                      @include('profile')
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h3 style="margin-top: 0;color:#337ab7">Reports</h3>
                       @include('retailer_grid')
                    </center>
                </div>
            </div>
        </div>
  </div>
</div>
            </div>
        <!-- /.box -->
    </section>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
@endsection








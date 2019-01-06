@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="box box-default center">   
            <div class="col-sm-3 panel">
                @include('retailer.customer')
            </div>
            <div id="main-panel" class="col-sm-9 panel"  >

                <!-- Bootstrap Styles -->
                <link rel="stylesheet" href="dist/css/bootstrap-responsive-tabs.css">

                <div id="scheduler_message_reports" class="scheduler responsive-tabs-container accordion-xs accordion-sm">	
                    <ul  class="nav nav-tabs responsive-tabs" id="tabMenu">
                        <li class="active">
                            <a  href="#scheduler" data-toggle="tab">Scheduler</a>
                        </li>
                        <li><a href="#message" data-toggle="tab">Message Center</a>
                        </li>
                        <li><a href="#buy-plan" data-toggle="tab">Buy Plan</a>
                        </li>

                        <li ><a href="#my-profile" data-toggle="tab" aria-expanded="true" >Profile Update</a>
                        </li>

                        <li><a href="#category" data-toggle="tab">Categories</a>
                        </li>                      

                        <li>
                            <a href="#bulk-upload" data-toggle="tab">Customer Upload</a>
                        </li>  

                        <li>
                            <a href="#request" data-toggle="tab"> My Response</a>
                        </li> 
                        <li><a href="#reports" data-toggle="tab">Reports</a>
                        </li> 


                    </ul>

                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="scheduler">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            {!! $calendar->calendar() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="message">
                            <div class="row">
                                <div class="col-md-1 col-md-offset-4">
                                    <div class="events_festival custom-select ">
                                        <select name="message_type" id="message_type" required="required" >
                                            <option value="0">Events And Festival</option>
                                            <option value="1">Birthday Wishes</option>
                                            <option value="2">Marriage Anniversary Wishes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="msg-cntr">
                                @include('retailer.message_center')
                            </div>
                            
                        </div>
                        <div class="tab-pane" id="buy-plan">
<h2>Coming Soon</h2>
<!--                            @include('retailer.buy-plan')-->
                        </div>
                        <div class="tab-pane" id="reports">
                            <h2>Coming Soon</h2>
<!--                            @include('retailer.retailer_report')-->
                        </div>

                        <div class="tab-pane"  id="my-profile">

                            @include('retailer.profile')

                        </div>




                        <div class="tab-pane" id="category">

                            @include('retailer.retailer_category')

                        </div>


                        <div class="tab-pane" id="bulk-upload">

                            @include('retailer.bulk_upload')

                        </div>

                        <div class="tab-pane" id="request"> @include('retailer.request') </div>


                    </div>
                </div>
            </div>
            <!--  <div class="col-sm-3 panel">
                 @include('retailer.recent_update')
             </div> -->
        </div>
        <!-- /.box -->
    </section>




</div>

<!-- jQuery & Bootstrap JS -->
<script src="dist/js/jquery.bootstrap-responsive-tabs.min.js"></script>

<script>
    $('.responsive-tabs').responsiveTabs({
        accordionOn: ['xs', 'sm']
    });
</script>
@include('retailer.retailer_modals')
@include('retailer.retailer_js')
@endsection








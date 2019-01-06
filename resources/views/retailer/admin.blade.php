@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="box box-default center">   
            <div class="col-sm-3 panel">
                @include('retailer.customer')
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
                                <div class="col-md-12 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Scheduler</div>
                                        <div class="panel-body">
                                            {!! $calendar->calendar() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="message">
                            @include('retailer.message_center')
                        </div>
                        <div class="tab-pane" id="reports">
                            @include('retailer.retailer_report')
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-3 panel">
                @include('retailer.recent_update')
            </div>
        </div>
        <!-- /.box -->
    </section>
</div>
@include('retailer.retailer_modals')
@include('retailer.retailer_js')
@endsection








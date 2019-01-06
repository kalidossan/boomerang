<section class="main">
    <div class="wrapper-demo">
        <div id="dd" class="wrapper-dropdown-3" tabindex="1">
            <span>Report</span>
            <input id="select_index" type="hidden"/>
            <ul class="dropdown">
                <li><a href="#"><i class="icon-envelope icon-large"></i>SMS</a></li>
                <li><a href="#"><i class="icon-truck icon-large"></i>Payment</a></li>
                <li><a href="#"><i class="icon-plane icon-large"></i>Customer</a></li>
            </ul>
        </div>
        ​</div>
</section>

<form class="form-horizontal" id="customer-report-filter" method="POST" >
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group" style="margin-right: 5px">
                    <label for="from">From</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input autocomplete="off" class="form-control datetimepicker" id="datepicker1" type="text" name="date_between1" placeholder="Select Date" value="" required>
                    </div>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="form-group" class="margin-right: 5px">
                    <label for="to">To</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input autocomplete="off" class="form-control datetimepicker" id="datepicker2" type="text" name="date_between2" placeholder="Select Date" value="" required>
                    </div>
                </div>
            </div>  

            <div class="col-md-1">
                <div class="form-group">
                    <div class="input-group">
                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                        <button  type="submit" name="btn" class="btn-date-filter btn btn-primary btn-flat"><i class="fa fa-filter"></i>Filter</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>




<div id="customer_report">
    
    <table id="customer_report_grid" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>E-mail</th>
            <th>Date Of Birth</th>
            <th>Anniverasry Date</th>
            <th>Gender</th>
        </tr>
        </tr>
    </thead>
    <tbody> 
        <?php $i = 1; ?>
        @foreach($customer as $p)
        <tr>
            <td>{{$i}}</td>
            <td>{{$p->CCM_FIRST_NAME}}</td>
            <td>{{$p->CCM_MOBILE_NO}}</td>                        
            <td>{{$p->CCM_EMAIL_ID}}</td>
            <td>
                @php
                $date = new DateTime($p->CCM_DOB);
                echo $date->format('m-d-Y');
                @endphp
            </td> 
            <td>
                @php
                $date = new DateTime($p->CCM_DOA);
                echo $date->format('m-d-Y');
                @endphp
            </td>
            <td>
                @if($p->CCM_GENDER=='0')
                {{"Male"}}
                @else
                {{"Female"}}
                @endif
            </td>
        </tr>
        <?php $i = $i + 1; ?>
        @endforeach
    </tbody>
</table>
</div>

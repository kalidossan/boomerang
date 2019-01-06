<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default buy_plan_panel">
                <div class="panel-heading">Buy Plan</div>
                
                <div class="form-group">
                    <div class="title">Plan Type</div>
                <select name="buy_plan" id="buy_plan" required="required" >
                    <option value="1">SMS Pack</option>
                    <option value="2">Renewal</option>
                </select>
                </div>
                <div class="form-group">
                <div class="title">Plan Option</div> 
                <select name="plan_option" id="plan_option" required="required" >
                    <option value="1">SMS Pack</option>
                    <option value="2">Renewal</option>
                </select>
                </div>

                <div class="panel-body">
                    <table id="buy-plan-grid" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Plan Name</th>
            <th>Plan Type</th>
            <th>SMS Count</th>
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
        </tr>
        <?php $i = $i + 1; ?>
        @endforeach
    </tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</div>
smsa
<table id="sms_report_grid" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Opening Balance</th>
            <th>Transaction Type</th>
            <th>TXN Reference ID</th>
            <th>SMS Purchased</th>
            <th>SMS Sent</th>
            <th>Closing Balance</th>
        </tr>
        </tr>
    </thead>
    <tbody> 
        <?php $i = 1; ?>
        @foreach($sms_log as $sms)
        <tr>
            <td>{{$i}}</td>
            <td>{{$sms->CSL_OpeningBalance}}</td>
            <td>{{$sms->CSL_Transaction_Type}}</td>                        
            <td>{{$sms->CSL_Transaction_Ref_ID}}</td>

            <td>{{$sms->CSL_SMS_Purchased}}</td>
            <td>{{$sms->CSL_SMS_Sent}}</td>
            <td>{{$sms->CSL_Closing_Balance}}</td>
           
        </tr>
        <?php $i = $i + 1; ?>
        @endforeach
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#sms_report_grid').DataTable();
    
});

</script>


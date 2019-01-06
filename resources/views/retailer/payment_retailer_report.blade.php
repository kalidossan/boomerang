payment's
<table id="payment_report_grid" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Work Order ID</th>
            <th>Amount Paid</th>
            <th>Payment Mode</th>
            
            
            <th>Reference</th>
            <th>Bank Name</th>
            <th>Pay Date </th>
            
            <th>Pending Amount</th>
            <th>Internal Verification</th>
            <th>Sales Person</th>
        </tr>
        </tr>
    </thead>
    <tbody> 
        <?php $i = 1; ?>
        @foreach($payment_log as $p)
        <tr>
            <td>{{$i}}</td>
            <td>{{$p->CWOPL_CWO_WO_ID}}</td>
            <td>{{$p->CWOPL_AMOUNT_PAID}}</td>                        
            <td>{{$p->CWOPL_PAYMENT_MODE}}</td>
            
             <td>{{$p->CWOPL_PAY_REF}}</td>
            <td>{{$p->CWOPL_BANK_NAME}}</td>                        
            <td>{{$p->CWOPL_PAY_DATE}}</td>
            
                <td>{{$p->CWOPL_PND_AMOUNT}}</td>
            <td>{{$p->CWOPL_INT_VER}}</td>                        
            <td>{{$p->CWOPL_SALES_PERSON}}</td>
          
        </tr>
        <?php $i = $i + 1; ?>
        @endforeach
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#payment_report_grid').DataTable();
    
});

</script>


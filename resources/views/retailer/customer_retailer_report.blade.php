customer's
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

<script>
$(document).ready(function() {
    $('#customer_report_grid').DataTable();
    
});

</script>


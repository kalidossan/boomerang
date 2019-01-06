<div id="retailer_response_block">
<input type="hidden" id="retailer_response_token" name="retailer_response_token"/>
<table id="grid" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Request</th>
            <th>Reponse</th>
            <th>Request Date</th>
            <th>Response Date</th>
            <th>Customer No</th>
            <th>Response</th>
        </tr>
        </tr>
    </thead>
    <tbody> 
        <?php $i = 1; ?>
        @foreach($retailer_request as $p)
        <tr>
            <td>{{$i}}</td>
            <td>{{$p->CAR_REQUEST_TEXT}}</td>
            <td><input value="{{$p->CAR_RESPONSE_TEXT}}" class="retailer_response_text"/></td>                        
            <td>{{$p->CAR_REQUEST_DT}}</td>
            <td>{{$p->CAR_RESPONSE_DT}}</td>
            <td>{{$p->CCM_MOBILE_NO}}</td>
            <td><input type="button" class="btn btn-primary retailer_response" value="Response"/>
                <input type="hidden" class="retailer_response_id" value="{{$p->CAR_REQUEST_ID}}" name="retailer_response_id"/>
            </td>
        </tr>
        <?php $i = $i + 1; ?>
        @endforeach
    </tbody>
</table>
</div>
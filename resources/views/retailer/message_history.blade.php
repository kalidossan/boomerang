<div class="message_history_header">
    <a href="#" id="message_center">Message Center</a>
</div>

<table id="message_history_grid" class="table table-bordered table-striped">
 <input type="hidden" value="{{csrf_token()}}" id="msg_history_token" />
    <thead>
        <tr>
            <th>
                Title  
                
            <th>
                Message Content
            </th>
            <th>
                Send Again
            </th>
        </tr>
    </thead>
    <tbody> 
        @foreach($message_history as $message)

        <tr>
            <td>
                {{$message->CMH_TITLE}}  
                <input type="hidden" value="{{$message->CMH_ID}}" class="msg_history_id" />
            </td>
            <td>
                {{$message->CMH_CONTENT}}
            </td>
            <td>
                <input type="submit" class="send-again btn btn-primary" value="Send Again" name="message_history_submit" /> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#message_history_grid').DataTable();

    });

</script>



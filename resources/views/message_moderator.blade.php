 <div class="col-sm-12 panel">
        <section class="content">
          <input type="hidden" value="{{csrf_token()}}" id="token_moderator" name="token_moderator" />
            <div class="retailers_list">
                <table id="message_moderator_grid" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Biz ID</th>
                            <th>Title</th>
                            <th>Message </th>
                            <th>SMS Balance</th>
                            <th>SMS Count</th>
                            <th>Valid Till Date</th>
                            <th>Valid Till Time</th>
                            <th>Approval</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php $i = 1; ?>
                        @foreach($message_sheduling as $p)
                        <tr>
                            <td>{{$p->CME_CREATED_BY}}</td>
                            <td>{{$p->CME_TITLE}}</td>
                            <td>
<textarea class="moderator-msg-txt" name="content-{{$p->CME_ID}}" rows="4" cols="50">{{$p->CME_MSG_TXT}}</textarea> 

                            </td>

                             <th>{{$p->sms_balance}}</th>
                             <th>{{$p->CME_SMS_COUNT}}</th>

                            <?php $date=date_create($p->CME_SCHD_DATE);?>

                            <td><input type="text" class="valid-till-date" name="till-date-{{$p->CME_ID}}" value="<?php echo date_format($date,"m/d/Y");?>" /></td>
                            <th><input type="text" class="valid-till-time" name="till-time-{{$p->CME_ID}}" value="{{$p->CME_SCHD_TIME}}" /></th>
                             
                            <td><input class='message_approval btn 
                                       
                     <?php echo ($p->CME_SMS_COUNT>$p->sms_balance)?"btn-warning":"btn-primary"?>
                                       
                                       
                                       ' type="button" value="Approve"/>
                            
                            
                            </td>
                    <input class="msg_id" value="{{$p->CME_ID}}" type="hidden" />
                        </tr>
                        <?php $i = $i + 1; ?>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </section>
    </div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>



<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#plan_token').val()

        }

});
$(".message_approval").click(function(e){

e.preventDefault();

var $tr = $(this).closest('tr');
var token = $('#token_moderator').val();
var msg_id =   $(this).parents('tr').find('.msg_id').val();
var till_date =   $(this).parents('tr').find('.valid-till-date').val();
var till_time =   $(this).parents('tr').find('.valid-till-time').val();
var msg_content =   $(this).parents('tr').find('.moderator-msg-txt').val();

$.ajax({
type:'GET',
        //url:APP_URL + "/message/approval",
        url:APP_URL + "/isendSms",
        data:{msg_id:msg_id,till_date:till_date,till_time:till_time,msg_content:msg_content,token:token},
        success:function(data){
            
             $tr.find('td').fadeOut(1000,function(){ 
                            $tr.remove();                    
                        }); 

        }
});
});

 $(function () {

    $('#message_moderator_grid').DataTable();

})


</script>
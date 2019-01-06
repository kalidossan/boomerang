<div class="col-sm-12 panel">

    <section class="content">

        <form  id="plan_entry_form">

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" value="{{csrf_token()}}" id="plan_token" name="plan_token" />
                        <div class="plan">
                            <select name="plan_entry_master" id="plan_entry_master" required="required" >
                                <option value="0">Subscription</option>
                                <option value="1">Renewal</option>
                                <option value="2">SMS Pack</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="title">Plan</div>
                            <input type="text" autocomplete="off" class="form-control plan_entry_control" id="plan_name_master" name="plan_name_master" value="{{ old('plan_name_master') }}"/>
                        </div>



                        <div class="form-group">
                            <div class="title">Amount</div>
                            <input type="text" autocomplete="off" class="form-control plan_entry_control" id="plan_entry_amount" name="plan_entry_amount" value="{{ old('plan_entry_amount') }}"/>
                        </div>

                        <div class="form-group">
                            <div class="title">SMS Count</div>
                            <input type="text" autocomplete="off" class="form-control plan_entry_control" id="sms_count" name="sms_count" value="{{ old('sms_count') }}"/>
                        </div>



                    </div>
                    <div class="col-md-6">

                        <div class="form-group tennure-group">

                            <div class="title">Tennure</div>

                            <input placeholder="In Months" name="tennure" type="text" value="{{ old('tennure') }}" class="form-control  plan_entry_control " id="tennure" autocomplete="off">

                            <input placeholder="In Days" name="tennure_in_days" type="text" value="{{ old('tennure_in_days') }}" class="form-control  plan_entry_control" id="tennure_in_days" autocomplete="off">

                        </div>



                        <div class="pub_prv">
                            <div class="title ">Display Type</div>
                            <select name="pub_prv_access" id="pub_prv_access" required="required" >
                                <option value="0">public</option>
                                <option value="1">private</option>
                            </select>
                        </div>




                        <div class="submit_wrapper form-group">
                            <button id="plan_entry_submit" type="submit" class="btn btn-primary plan_submit">Save</button>
                        </div>

                    </div>

                </div>

            </div>
        </form>

        <div class="plan_list">


            <table id="plan_grid" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Plan Name</th>
                        <th>Plan Type</th>
                        <th>SMS Count</th>
                        <th>Tennure</th>
                        <th>Amount</th>
                        <th>Display Type </th>
                        <th>Edit Existing Plan</th>
                        <th>Status</th>
                    </tr>
                    </tr>
                </thead>
                <tbody> 
                    <?php $i = 1; ?>
                    @foreach($plan as $p)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$p->CPE_PLAN_NAME}}</td>
                        <td>{{$p->CPE_PLAN_TYPE}}</td>
                        <td>{{$p->CPE_SMS_ALLOTED}}</td> 
                        <td>{{$p->CPE_TENURE_MONTHS}}</td>
                        <td>{{$p->CPE_AMOUNT}}</td>
                        <td>{{$p->CPE_DISPLAY_TYPE}}</td> 
                        <td><input type="button" value="Edit"/></td>
                        <td>{{$p->CPE_ACTIVE_STATUS}}</td>
                    </tr>
                    <?php $i = $i + 1; ?>
                    @endforeach
                </tbody>
            </table>

        </div>

    </section>
</div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>
<script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>


<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#plan_token').val()

        }

});
$("#plan_entry_form").submit(function(e){
e.preventDefault();
$.ajax({

type:'GET',
        url:APP_URL + "/create/plan",
        data:$('#plan_entry_form').serialize(),
        success:function(data){
        $('.our-plans').html(data);
        $('#form_payment_block').load(location.href + ' #form_payment_block');
        }
});
});
$(document).ready(function(){
$('#plan_grid').DataTable({
"lengthMenu": [[5, 10, 50, - 1], [5, 10, 50, "All"]]
        });
});

</script>
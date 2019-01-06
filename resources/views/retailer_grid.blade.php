 <div class="col-sm-12 panel">

        <section class="content">


            <div class="retailers_list">


                <table id="retailers_grid" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Business Name</th>
                            <th>Location</th>
                            <th>Edit Existing Plan</th>
                            <th>Status</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php $i = 1; ?>
                        @foreach($retailers as $p)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$p->RET_FIRST_NAME}}</td>
                            <td>{{$p->RET_MOBILE_NO}}</td>
                            <td>{{$p->RET_EMAIL_ID}}</td> 
                            <td>{{$p->RET_BIZ_NAME}}</td>
                            <td>{{$p->RET_CITY_NAME}}</td>
                            <td><input type="button" value="Edit"/></td>
                            <td>{{$p->RET_ACTIVE_STATUS}}</td>
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


 $(function () {

    $('#retailers_grid').DataTable();
    

})


</script>
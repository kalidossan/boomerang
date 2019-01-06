 <div class="col-sm-12 panel">
        <section class="content">
            <div class="customer_xls_list">
                <table id="customer_xls_list_grid" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Retailer ID</th>
                            <th>Download Xl Sheet</th>
                            <th>Verify</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php $i = 1; ?>
                        @foreach($xl_customer_upload as $c)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$c->CCU_RET_BIZ_ID}}</td> 
                            <td>
                        <i class="fa fa-file-excel-o download_xls btn btn-primary" aria-hidden="true"></i>

                                <input type="hidden" value="{{csrf_token()}}" id="ver_token" name="ver_token" /></td>
                            <td><input class='verify_xls btn btn-primary' type="button" value="Approve"/></td>
                            <input class="verify_xls_id" value="{{$c->CCU_ID}}" type="hidden" />
                            <input type="hidden" class="file_name" value="{{$c->CCU_FILE_NAME}}"/>
                            
                            
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

'X-CSRF-TOKEN': $('#ver_token').val()

        }

});
$(".verify_xls").click(function(e){

e.preventDefault();

var $tr = $(this).closest('tr');
var upld_id =   $(this).parents('tr').find('.verify_xls_id').val();
var token = $('input[name="ver_token"]').val();
$.ajax({

type:'GET',
        url:APP_URL + "/customer/approval",
        data:{upld_id:upld_id,token:token},
        success:function(data){

                console.log(data);

        },
        complete:function(data){
               $tr.find('td').fadeOut(1000,function(){ 
                            $tr.remove();                    
                        }); 
        }
});
});


$(".download_xls").click(function(e){

e.preventDefault();

var $tr = $(this).closest('tr');
var dwld_id =   $(this).parents('tr').find('.verify_xls_id').val();
var file_name =   $(this).parents('tr').find('.file_name').val();
var token = $('input[name="_token"]').val();
$.ajax({

type:'GET',
        url:APP_URL + "/download-xls",
        xhrFields: {
            responseType: 'blob'
        },

        data:{dwld_id:dwld_id},
        success:function(data){
            console.log(data);
             var a = document.createElement('a');
             var url = window.URL.createObjectURL(data);
             a.href = url;
             a.download = file_name;
             a.click();
             window.URL.revokeObjectURL(url);
        }
});
});



 $(function () {

    $('#customer_xls_list_grid').DataTable();

})


</script>
<div class="content-wrapper">
    <div class="col-sm-6 panel">
        <div class="col-xs-12">
            <div class="col-md-12" >

                <form id="recent_updates_form">

                    <input type="hidden" value="{{csrf_token()}}" id="alert_token" name="alert_token" />
                    <div class="form-group">
                        <div class="title">Title</div>
                        <div class="col-md-5">
                            <input id="recent_updates_title" name="recent_updates_title" type="text" placeholder="" class="form-control input-md">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="title"></div>
                        <textarea cols="5" rows="5" id="recent_updates_text" class="form-control" name="recent_updates_text"> <?php if (old('recent_updates_text')) { ?>{{ old('category_value') }}<?php } ?></textarea>
                    </div>

                    <div class="form-group">
                        <button id="recent_updates_submit" type="submit" class="btn btn-primary">Create Updates</button>
                    </div>

                </form>


            </div>
        </div>

    </div>  


</div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>


<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#alert_token').val()

}

});
$("#recent_updates_submit").click(function(e){
e.preventDefault();
$.ajax({

type:'GET',
        url:APP_URL + "/create/recent-updates",
        data:$('#recent_updates_form').serialize(),
        success:function(data){
        alert("cat");
        //$('#myModal').modal('show');
        }
});
});
$('li').click(function()
        {
        var _token = $("input[name='_token']").val();
        var cid = $(this).attr("id");
        var cat_value = "<ul>";
        $.ajax({
        type:'POST',
                url:APP_URL + "/category/config",
                data:{cid:cid, _token:_token},
                success:function(data){
                   
                
                 for (var i = 0; i < data.values.length; i++) {


           cat_value += "<li>"+ data.values[i].ccvm_value+"</li>";
          }


                 cat_value += "</ul>";
                
                $('.cat_value').html(cat_value);
                
                }
        });
        });


</script>









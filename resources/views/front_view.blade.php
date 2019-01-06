
<div class="container">


             <form id="front_view_form" action="" method="post" enctype="multipart/form-data">

                    <input type="hidden" value="{{csrf_token()}}" id="front_token" name="front_token" />
                    <div class="form-group">
                        <div class="title">Title</div>
                        <div class="col-md-5">
                            <input id="front_view_title" name="front_view_title" type="text" placeholder="" class="form-control input-md">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="title"></div>
                        <textarea cols="5" rows="5" id="front_view_text" class="form-control" name="front_view_text"> <?php if (old('recent_updates_text')) { ?>{{ old('front_view_text') }}<?php } ?></textarea>
                    </div>

                  

          <!-- Standar Form -->
          <h4>Select Images</h4>
            <div class="form-inline">
              <div class="form-group">
                <input type="file" name="files[]" id="js-upload-files" multiple>
              </div>
              <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Upload files</button>
            </div>

                    <div class="form-group">
                        <button id="front_view_submit" type="submit" class="btn btn-primary">Create View</button>
                    </div>

                </form>

  </div>      


<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>


<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#alert_token').val()

}

});
$("#front_view_submit").click(function(e){
e.preventDefault();
$.ajax({

type:'GET',
        url:APP_URL + "/create/slideshow",
        data:$('#front_view_form').serialize(),
        success:function(data){
        alert("cat");
        //$('#myModal').modal('show');
        }
});
});





</script>









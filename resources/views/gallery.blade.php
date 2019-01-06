<div class="container">
      <div class="panel panel-default">
        <div class="panel-heading"><strong>Upload Files</strong> <small>Bootstrap files upload</small></div>
        <div class="panel-body">

          <!-- Standar Form -->
          <h4>Select files from your computer</h4>
          <form action="" method="post" enctype="multipart/form-data" id="js-upload-form">
            <div class="form-inline">
              <div class="form-group">
                <input type="file" name="files[]" id="js-upload-files" multiple>
              </div>
              <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Upload files</button>
            </div>
          </form>

          <!-- Drop Zone -->
          <h4>Or drag and drop files below</h4>
          <div class="upload-drop-zone" id="drop-zone">
            Just drag and drop files here
          </div>

          <!-- Progress Bar -->
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>

          <!-- Upload Finished -->
          <div class="js-upload-finished">
            <h3>Processed files</h3>
            <div class="list-group">
              <a href="#" class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">Success</span>image-01.jpg</a>
              <a href="#" class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">Success</span>image-02.jpg</a>
            </div>
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









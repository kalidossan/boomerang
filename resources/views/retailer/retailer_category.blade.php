<div class="content-wrapper">
    <div class="col-md-6">
        <div class="panel panel-default ">
            <div class="panel-heading"><i class="fa fa-pencil-square-o"></i>Create Category</div>

            <div class="panel-body">
                <form id="category_form">

                    <input type="hidden" value="{{csrf_token()}}" id="token" name="_token" />
                    <div class="form-group">
                        <div class="title">Category Label</div>
                        <input id="category_label" name="category_label" type="text" class="form-control input-md">
                    </div>
                    <div class="form-group">
                        <div class="title">Category Values</div>
                        <textarea cols="5" rows="5" id="category_value" placeholder="Category Value" class="form-control" name="category_value"> <?php if (old('category_value')) { ?>{{ old('category_value') }}<?php } ?></textarea>
                    </div>

                    <div class="form-group">
                        <button id="category_submit" type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </div>

    </div>  

    <div class="col-md-6">
        <div class="panel panel-default ">
            <div class="panel-heading"><i class="fa fa-pencil-square-o"></i>Create Category</div>
            <div class="panel-body">
                <div class="col-sm-6 panel">
                    <ol>
                    @foreach($categories_master as $category)
                    <li id="{{$category->CCM_ID}}">{{$category->CCM_LABEL_NAME}}</li>
                    @endforeach
                    </ol>
                </div>
                <div class="col-sm-6 panel">
                    <div class="cat_value">
                        @foreach($categories_master_values as $value)

                        <li >{{$value->ccvm_value}}</li>

                        @endforeach
                    </div>     
                </div>
            </div>
        </div>
    </div>  

</div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.full.min.js')!!}"></script>
<script src="{!!url('bower_components/select2/dist/js/select2.min.js')!!}"></script>

<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#token').val()

}

});
$(document).on('submit', '#category_form', function(e){
e.preventDefault();
$.ajax({
type:'GET',
        url:APP_URL + "/create/categories",
        data:$(this).serialize(),
        success:function(data){
        $('#category').load(location.href + ' #category');
        $('#message_center_categories').load(location.href + ' #message_center_categories', function(){
        $('.mc_category_values').select2({  tags: true,
                createSearchChoice : function(term){
                return false;
                }
        });
        });
        $('#registration').load(location.href + ' #registration', function(){
            $('#dob').datepicker({
    autoclose: true,
});
$('#doa').datepicker({
    autoclose: true,
});
$('#dos').datepicker({
    autoclose: true,
});
$('#exp_dte, #datepicker1, #datepicker2').datepicker({
    autoclose: true,
});
        $('.reg_category_values').select2({  tags: true,
                createSearchChoice : function(term){
                return false;
                }
        });
        });
        }

});
});
$(document).on('click', 'li', function()
        {
        $(this).addClass('current');
        $( "li" ).not( this ).removeClass('current');
        var _token = $("input[name='_token']").val();
        var cid = $(this).attr("id");
        var cat_value = "<ul>";
        $.ajax({
        type:'POST',
                url:APP_URL + "/category/config",
                data:{cid:cid, _token:_token},
                success:function(data){
                for (var i = 0; i < data.values.length; i++) {
                cat_value += "<li>" + data.values[i].ccvm_value + "</li>";
                }
                cat_value += "</ul>";
                $('.cat_value').html(cat_value);
                }
        });
        });
$(document).ready(function () {
$('.reg_category_values').select2({tags: true,
        createSearchChoice : function(term){
        return false;
        }});
});

</script>












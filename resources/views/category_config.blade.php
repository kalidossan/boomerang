@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="col-sm-6 panel">
        <div class="col-xs-12">
            <div class="col-md-12" >
                
                   {{$pass}}
                <h3> Add Category</h3>

                <form id="category_form">

                    <input type="hidden" value="{{csrf_token()}}" id="token" name="_token" />
                    <div class="form-group">
                        <div class="title">Category Name</div>
                        <div class="col-md-5">
                            <input id="category_label" name="category_label" type="text" placeholder="" class="form-control input-md">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="title"></div>
                        <textarea cols="5" rows="5" id="category_value" class="form-control" name="category_value"> <?php if (old('category_value')) { ?>{{ old('category_value') }}<?php } ?></textarea>
                    </div>

                    <div class="form-group">
                        <button id="category_submit" type="submit" class="btn btn-primary">Create Category</button>
                    </div>

                </form>


            </div>
        </div>

    </div>  

    <div class="col-sm-6 panel">
        <div class="col-sm-6 panel">

            @foreach($categories as $category)

            <li id="{{$category->CCM_ID}}">{{$category->CCM_LABEL_NAME}}</li>

            @endforeach


        </div>


        <div class="col-sm-6 panel">

            <div class="cat_value">
                @foreach($values as $value)

                <li >{{$value->ccvm_value}}</li>

                @endforeach
            </div>     


        </div>




    </div>  
</div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>


<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('#token').val()

}

});
$("#category_submit").click(function(e){
e.preventDefault();
$.ajax({

type:'GET',
        url:APP_URL + "/create/categories",
        data:$('#category_form').serialize(),
        success:function(data){
        alert("cat");
        //$('#myModal').modal('show');
        }
});
});
$('#category li').click(function()
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




@endsection








<div id="retailer_registration"> 

    <div class="col-sm-8 panel">
        <form method="GET" id="profile_update" ">
            <div class="panel panel-default">
                <div class="panel-heading">Profile Update</div>

                <div class="panel-body">
                    <div class="col-sm-6 panel">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" value="{{csrf_token()}}" id="profile_token" name="profile_token" />

                                    <div class="form-group">
                                        <div class="title">E-Mail</div>
                                        <input type="email" autocomplete="off" class="form-control profile_registration" id="profile_mail" name="profile_mail" value="{{ $retailer->RET_EMAIL_ID }}"/>
                                    </div>


                                    <div class="form-group">
                                        <div class="title">Fb Address</div>
                                        <input type="text" autocomplete="off" class="form-control retailer_registration" id="fb_id" name="fb_id" value="{{ $retailer->RET_FB_ID }}"/>
                                    </div>

                                    <div class="form-group">
                                        <div class="title">Instagram ID</div>
                                        <input type="text" autocomplete="off" class="form-control retailer_registration" id="instagram_id" name="instagram_id" value="{{ $retailer->RET_INSTA_ID }}"/>
                                    </div> 

                                    <div class="form-group">
                                        <div class="title">Plot/Flat No </div>
                                        <input type="text" autocomplete="off" class="form-control retailer_registration" id="flat_no" name="flat_no" value="{{ $retailer->RET_FLAT_NO }}"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="title">Street </div>
                                        <input type="text" autocomplete="off" class="form-control retailer_registration" id="street" name="street" value="{{ $retailer->RET_STREET_NAME }}"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="title">Area </div>
                                        <input type="text" autocomplete="off" class="form-control retailer_registration" id="area" name="area" value="{{ $retailer->RET_AREA_NAME }}"/>
                                    </div>      
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6 panel"> 

                        <div class="form-group">
                            <div class="title">State</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="state" name="state" value="{{ $retailer->RET_STATE_NAME }}"/>
                        </div>
                        <div class="form-group">
                            <div class="title">City </div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="city" name="city" value="{{ $retailer->RET_CITY_NAME }}"/>
                        </div>

                        <div class="form-group">
                            <div class="title">Pin Code</div>
                            <input type="text" autocomplete="off" class="form-control retailer_registration" id="pincode" name="pincode" value="{{ $retailer->RET_PINCODE }}"/>
                        </div>


                        <div class="form-group">
                            <button id="retailer_registration_submit" type="submit" class="btn btn-primary">Update</button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-sm-4 panel">

        @include('retailer.retailer_reset')
        @include('retailer.sender_id')

    </div>


</div>

<div id="regModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="success"></div>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">

                <div class="customer"></div> Retailers Updated Successfully <div class="first_name"></div>

            </div>

        </div>

    </div>
</div>

<script src="{!!url('bower_components/jquery/dist/jquery.min.js')!!}"></script>

<script type="text/javascript">

var APP_URL = {!! json_encode(url('/')) !!};
$.ajaxSetup({
headers: {'X-CSRF-TOKEN': $('#token').val()}
});
$("#profile_update").submit(function(e){
var token = $('#profile_token').val();
e.preventDefault();
$.ajax({
type:'GET',
        url:APP_URL + "/retailer/registration",
        data:$('#form_registration').serialize() + "&token=" + token,
        success:function(data){

        $('.success').text(data.success)


        }
});
});

</script>













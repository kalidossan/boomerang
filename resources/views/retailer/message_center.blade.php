<div class="events_festival_header">
    <div class="pull-left">
        <a href="#" id="message_history">Message History</a>    
    </div>
    <div class="pull-right language-select">
        <select name="language_type" id="language_type" required="required" >
            <option value="0">English</option>
            <option value="1">Tamil</option>
        </select>

    </div>
</div>




<form  id="mc_form">

    <div class="box-body">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mc-wrapper">
                    <input type="hidden" value="{{csrf_token()}}" id="token2" name="_token2" />


                    <div class="form-group">
                        <div class="title">Message Title</div>
                        <input type="text" autocomplete="off" class="form-control customer_registration" id="message_title" name="message_title" value="@isset($msg_send_again->CMH_TITLE){{$msg_send_again->CMH_TITLE }}@endisset" required="required" />
                    </div>

                    <div class="form-group">
                        <div class="title">Message Text</div>
                        <textarea cols="5" rows="5" onkeyup="countChar(this)" id="msg_txt" class="form-control" name="msg_txt">@isset($msg_send_again->CMH_CONTENT){{$msg_send_again->CMH_CONTENT}}@endisset</textarea> <span id="charNum"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 events_festival_only">

                <div class="mc-wrapper">
                    <div class="form-group valid-till">
                        <div class="title valid-date">Valid From</div>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input autocomplete="off" name="valid_till" type="text" value="" class="form-control pull-right " id="valid_till" autocomplete="off" required="required">
                        </div>



                    </div>
                    <div class="form-group valid-till">
                        <div class="title">Time</div>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input autocomplete="off" name="valid_till_time" type="text" value="" class="form-control pull-right " id="valid_till_time" autocomplete="off" >
                        </div>
                    </div>

                    <div >Target Audience</div>
                    <div >
                        <div class="radio">
                            <div class="title">
                                <input type="radio" name="gender_group" id="tar_male" value="0" >
                                Male                                            </div>
                        </div>
                        <div class="radio">
                            <div class="title">
                                <input type="radio" name="gender_group" id="tar_female" value="1">
                                Female                                            </div>
                        </div>
                        <div class="radio">
                            <div class="title">
                                <input type="radio" name="gender_group" id="both" value="2" checked="">
                                Both                                            </div>
                        </div>

                    </div>

                    <div >
                        <div class="radio">
                            <div class="title">
                                <input type="radio" name="cust_pros_target" id="customer" value="1" >
                                Customer                                            </div>
                        </div>
                        <div class="radio">
                            <div class="title">
                                <input type="radio" name="cust_pros_target" id="prospect" value="2">
                                Prospect                                            </div>
                        </div>
                        <div class="radio">
                            <div class="title">
                                <input type="radio" name="cust_pros_target" id="cust_pros_target" value="3" checked="">
                                Both                                            </div>
                        </div>

                    </div>



                </div>

            </div>


        </div>

        <div class="row category-wrapper">

            <div class="events_festival_only mc-category-wrapper">
                <div id="message_center_categories" class=" category_wrapper pull-left">
                    @foreach($categories_label as $category_label)
                    <div  class="wrapper_category">
                        <div class="title" name="{{$category_label->CCM_ID}}">{{$category_label->CCM_LABEL_NAME}}</div>

                        <select class="form-control select2 select2-hidden-accessible mc_category_values" multiple="multiple"  name="mc_category_{{$category_label->CCM_ID}}" id="mc_category_{{$category_label->CCM_ID}}"  >
                            @foreach($categories as $category)
                            @if($category->CCVM_CCM_ID == $category_label->CCM_ID)
                            <option value="{{$category->CCVM_ID}}">{{$category->CCVM_VALUE}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @endforeach
                </div>

            </div>

            <div class="submit_wrapper form-group">
                <button id="mc_submit" type="submit" class="btn btn-primary mc_submit">Preview & Save</button>
            </div>

        </div>

    </div>
</form>




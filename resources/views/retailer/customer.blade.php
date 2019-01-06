 <div id="registration">
    <form method="post" id="form">
     <div class="panel panel-default">
        
                <div class="panel-heading"><i class="fa fa-pencil-square-o"></i>New Customer Registration<input class="visit_count" type="checkbox" name="customer" value="1" checked /> Visit <span id="visit_count"></span>
<div class="new_cust_reg_mob">
                                        <div class="title">Mobile No<span class="mand">*</span></div>
                            <input type="text" autocomplete="off" class="form-control customer_registration " id="mobile" name="mobile" value="{{ old('mobile') }}"  maxlength="10" required="required"/>
                                    </div>

                </div>
                
                    <div id="success"></div>
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" value="{{csrf_token()}}" id="form_token" name="form_token" />
                                    <select name="cust_pros" id="cust_pros" required="required" >
                                        <option value="">Select customer/prospect</option>
                                        <option value="1">Customer</option>
                                        <option value="2">Prospect</option>
                                    </select>
                                   
                                      
                                     
                                    <div class="form-group">
                                        <div class="title">First Name<span class="mand">*</span></div>
                                        <input type="text" autocomplete="off" class="form-control customer_registration" id="first_name" name="first_name" value="{{ old('first_name') }}" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="title">Last Name</div>
                                        <input type="text" autocomplete="off" class="form-control customer_registration" id= "last_name" name="last_name" value="{{ old('last_name') }}"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="title">E-Mail<span class="mand">*</span></div>
                                        <input type="email" autocomplete="off" class="form-control customer_registration" id="mail" name="mail" value="{{ old('mail') }}" required="required"/>
                                    </div>
                                  

                                    <div class="form-group date-control">
                                        <div class="title">Date Of Birth<span class="mand">*</span></div>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" name="dob" type="text" value="{{ old('dob') }}" class="form-control pull-right " id="dob" autocomplete="off" required="required">
                                        </div>

                                    </div>
                                    <div class="form-group date-control">
                                        <div class="title">Anniversay Date</div>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" name="doa" type="text" value="{{ old('doa') }}" class="form-control pull-right " id="doa" autocomplete="off">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="title">Gender<span class="mand">*</span></div>
                                        <div class="radio">
                                            <div >
                                                <input type="radio" name="gender" id="male" value="0" required="">
                                                Male                                            </div>
                                        </div>
                                        <div class="radio">
                                            <div >
                                                <input type="radio" name="gender" id="female" value="1">
                                                Female                                            </div>
                                        </div>

                                    </div>
                                    

                                 

                                    <div  class="reg_category_wrapper pull-left">
                                                     @foreach($categories_label as $category_label)
                                                    <div class="wrapper_category">
                                                    <div class="title" name="{{$category_label->CCM_ID}}">{{$category_label->CCM_LABEL_NAME}}</div>

                                                    <select class="form-control select2 select2-hidden-accessible reg_category_values" multiple="multiple"  name="reg_category_{{$category_label->CCM_ID}}" id="reg_category_{{$category_label->CCM_ID}}"  >
                                                        @foreach($categories as $category)
                                                        @if($category->CCVM_CCM_ID == $category_label->CCM_ID)
                                                        <option value="{{$category->CCVM_ID}}">{{$category->CCVM_VALUE}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                     </div>
                                                    @endforeach
                                               
                                        </div>


                                    <div class="form-group">
                                        <div class="ad_req"><i class="fa fa-pencil-square-o"></i>Add a Request</div>
                                        <div class="title">Expected Date</div>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" name="exp_dte" type="text" value="{{ old('exp_dte') }}" class="form-control pull-right " id="exp_dte" autocomplete="off">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="title"></div>
                                        <textarea cols="5" rows="5" value="" id="arequest" class="form-control" name="arequest"> <?php if (old('arequest')) { ?>{{ old('arequest') }}<?php } ?></textarea>
                                    </div>


                                    <div class="form-group">
                                        <button id="submit" type="submit" class="btn btn-primary">Create</button>
                          
                                    </div>
                                </div>

                            </div>
  </div>
                        </div>
                    </form>

 </div>




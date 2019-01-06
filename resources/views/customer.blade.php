 <div id="registration">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="top-bar-title padding-bottom"><i class="fa fa-pencil-square-o"></i>New Customer Registration</div>
                            </div> 
                        </div>            
                    </div>
                    <div id="success"></div>

                    <form method="post" id="form">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" value="{{csrf_token()}}" id="token" name="_token" />
                                    <input type="checkbox" name="customer" value="1" checked /> Visit {{@$visit_count}}

                                   
                                      <div class="form-group">
                                        <div class="title">Mobile No</div>
                                        <input type="mobile" autocomplete="off" class="form-control customer_registration" id="mobile" name="mobile" value="{{ old('mobile') }}"/>
                                    </div>
                                     <select name="cust_pros" id="cust_pros" required="required" >
                                        <option value="0" >Select customer/prospect</option>
                                        <option value="1">Customer</option>
                                        <option value="2">Prospect</option>
                                    </select>
                                    <div class="form-group">
                                        <div class="title">First Name</div>
                                        <input type="text" autocomplete="off" class="form-control customer_registration" id="first_name" name="first_name" value="{{ old('first_name') }}"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="title">Last Name</div>
                                        <input type="text" autocomplete="off" class="form-control customer_registration" id= "last_name" name="last_name" value="{{ old('last_name') }}"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="title">E-Mail</div>
                                        <input type="email" autocomplete="off" class="form-control customer_registration" id="mail" name="mail" value="{{ old('mail') }}"/>
                                    </div>
                                  

                                    <div class="form-group">
                                        <div class="title">Date Of Birth</div>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" name="dob" type="text" value="{{ old('dob') }}" class="form-control pull-right " id="dob" autocomplete="off">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="title">Anniversay Date</div>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" name="doa" type="text" value="{{ old('doa') }}" class="form-control pull-right " id="doa" autocomplete="off">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="title">Gender</div>
                                        <div class="radio">
                                            <div class="title">
                                                <input type="radio" name="gender" id="male" value="0" checked="">
                                                Male                                            </div>
                                        </div>
                                        <div class="radio">
                                            <div class="title">
                                                <input type="radio" name="gender" id="female" value="1">
                                                Female                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div >Add a Request</div>
                                    <hr>
                                    <div class="form-group">
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

                                    <div class="category_wrapper pull-left">
                                                     @foreach($categories_label as $category_label)
                                                    <div class="wrapper_category">
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


                                    <div class="form-group">
                                        <button id="submit" type="submit" class="btn btn-primary">Create</button>
                          
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
  </div>

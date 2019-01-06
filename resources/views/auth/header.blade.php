<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>C</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"> Boomerang</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->

        <div class="navbar-custom-menu">


@guest
<!--            <ul class="nav navbar-nav">
                  <li>
                     <a href="{{ url('home') }}"class="text-center">Home</a>

                </li>

                  <li>
                     <a href="{{ url('about') }}" class="text-center">About Us</a>

                </li>

                <li>
                     <a href="{{ url('products') }}" class="text-center">Products </a>

                </li>
                <li>
                     <a href="{{ url('contact') }}" class="text-center">Contact Us </a>
         </li>
     </ul>-->
@endguest
            <ul class="nav navbar-nav pull-right">
                <!-- Messages: style can be found in dropdown.less-->

                </li>

                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    @if (!(Auth::check())) 
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        LOGIN
                    </a>
                    @endif
                    
                </li>

                <!-- User Account: style can be found in dropdown.less -->

                @guest
                <li><a href="{{ url('registration-sign-up') }}">REGISTER</a></li>

                @else
                

                  <ul class="nav navbar-nav retailer-menu">
                   
                 @if(Auth::user()->biz_id !== 0)
                  
                <li class="yellow">
                    SMS Balance : <span>{{sms_balance()}}</span>
                </li>
                @endif

                @if(Auth::user()->role_id == 1)
                <li>

                    @php $retailers_list = retailerList(); @endphp
             
                        <select class="form-control select2 retailers_list" name="retailers_list" id="retailers_list">
                                <option value="0">Admin Panel</option>
                                @foreach($retailers_list as $retailer)
                                <option value="{{$retailer->RET_BIZ_ID}}" 

                            <?php echo (Auth::user()->biz_id == $retailer->RET_BIZ_ID)?  "selected" : "" ?>
                                    
                                    >{{$retailer->RET_MOBILE_NO}}</option>

                                @endforeach
                        </select>


                 </li>
                 @endif
     </ul>
                
                <li><a class="my_mobile_no">{{ Auth::user()->email }}</a></li> 
                
                <li><a href="{{ route('logout') }}" class="btn  btn-flat"
                                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Sign out</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                
                </li>
                
<!--                
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">{{ Auth::user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu">
                         User image 
                        <li class="user-header">

                            <p>
                                {{ Auth::user()->name }}
                                <small>Member since Nov. 2017</small>
                            </p>
                        </li>
                         Menu Body 
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                             /.row 
                        </li>
                         Menu Footer
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Sign out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>-->
                @endguest
            </ul>
        </div>
    </nav>
</header>

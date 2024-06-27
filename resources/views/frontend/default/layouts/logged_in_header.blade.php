
<section class="menu-area">
    <div class="container-xl">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    
                    <a href="{{ url('/') }}" class="navbar-brand" href="#">
                        <img src="{{ url('/').get_frontend_settings('w_logo'))}}" alt="" height="35">
                    </a>
                    
                    <ul class="mobile-header-buttons">
                        <li class="burger-menu-li"><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>
                        <li class="search-li"><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>
                    </ul>
                    @include('frontend.default.layouts.menu')

                    <form action="{{ route('search') }}" method="get" style="width: 100%;">
                        <div class="input-group search-box mobile-search">
                            <input type="text" name = 'query' class="form-control" placeholder="{{__('search_for_courses')}}">
                            <div class="input-group-append">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    @if(get_settings('allow_instructor') == 1)
                        <div class="instructor-box menu-icon-box">
                            <div class="icon">
                                <a href="#" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;">{{__('instructor')}}<a>
                            </div>
                        </div>
                    @endif


                    <div class="user-box menu-icon-box">
                        <div class="icon">
                            <a href="javascript::">
                                <img src="{{get_user_image_url(auth()->user()->id)}}" alt="" class="img-fluid">
                            </a>
                        </div>
                        <div class="dropdown user-dropdown corner-triangle {{ auth()->user()->language == 'english' ? 'top-right' : 'top-left' ?>">
                            <ul class="user-dropdown-menu">

                                <li class="dropdown-user-info">
                                    <a class="user-submenu-home-dropdown">
                                        <div class="clearfix">
                                            <div class="user-image  {{ auth()->user()->language == 'english' ? 'float-left' : '' }}">
                                                <img src="{{get_user_image_url(auth()->user()->id)}}" alt="" >
                                            </div>
                                            <div class="user-details {{ auth()->user()->language == 'english' ? '' : 'float-left' }}">
                                                <div class="user-name">
                                                    <span class="hi">{{__('hi')}},</span>
                                                    {{ auth()->user()->language == 'english' ? auth()->user()->name_english :  auth()->user()->name_arabic}}
                                                </div>
                                                <div class="user-email">
                                                    <span class="email">{{auth()->user()->email}}</span>
                                                    <span class="welcome">{{__('welcome_back')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="user-dropdown-menu-item"><a href="{{route('check-certificate')}}"><i class="far fa-gem"></i>{{__('check_certificate')}}</a></li>
                                <li class="user-dropdown-menu-item"><a href="{{route('my-messages')}}"><i class="far fa-envelope"></i>{{__('my_messages')}}</a></li>
                                <li class="user-dropdown-menu-item"><a href="{{route('user-profile')}}"><i class="fas fa-user"></i>{{__('user_profile')}}</a></li>
                                <li class="dropdown-user-logout user-dropdown-menu-item"><a href="{{route('logout')}}">{{__('log_out')}}</a></li>
                            </ul>
                        </div>
                    </div>



                    <span class="signin-box-move-desktop-helper"></span>
                    <div class="sign-in-box btn-group d-none">

                        <button type="button" class="btn btn-sign-in" data-toggle="modal" data-target="#signInModal">Log In</button>

                        <button type="button" class="btn btn-sign-up" data-toggle="modal" data-target="#signUpModal">Sign Up</button>

                    </div> <!--  sign-in-box end -->


                </nav>
            </div>
        </div>
    </div>
</section>

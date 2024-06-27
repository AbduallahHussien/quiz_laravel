<section class="menu-area">
    <div class="container-xl">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    <ul class="mobile-header-buttons">
                        <li class="burger-menu-li"><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>
                        <li class="search-li"><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>
                    </ul>

                    <a href="{{ url('/') }}" class="navbar-brand" href="#"><img src="{{ url('/').get_frontend_settings('w_logo')}}" alt="" height="35"></a>

                    @include('frontend.default.layouts.menu')

                    <form action="{{ route('search') }}" method="get" style="width: 100%;">
                        <div class="input-group search-box mobile-search">
                            <input type="text" name = 'query' class="form-control" placeholder="{{__('search_for_courses')}}">
                            <div class="input-group-append">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    @if (session('admin_login'))
                        <div class="instructor-box menu-icon-box">
                            <div class="icon">
                                <a href="{{route('admin')}}" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;">{{__('administrator')}}</a>
                            </div>
                        </div>
                    @endif

                    <div class="cart-box menu-icon-box" id = "cart_items">
                        @include('frontend.default.layouts.cart_items')
                    </div>

                    <span class="signin-box-move-desktop-helper"></span>
                    <div class="sign-in-box btn-group">

                        <a href="{{route('login')}}" class="btn btn-sign-in">{{__('log_in')}}</a>
                        @php
                            $setting = setting();
                        @endphp
                        @if($setting->register_open == 1)
                            
                            <a href="{{route('sign-up')}}" class="btn btn-sign-up">{{__('sign_up')}}</a>
                        @endif
                    </div> <!--  sign-in-box end -->
                </nav>
            </div>
        </div>
    </div>
</section>

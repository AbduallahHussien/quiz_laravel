<div class="main-nav-wrap">
    <div class="mobile-overlay"></div>

    <ul class="mobile-main-nav">
        <div class="mobile-menu-helper-top"></div>

        <li class="has-children bars-menu-container">
            <a href="" class="bars-menu">
                <i class="fa fa-align-justify d-inline icon"></i>
                <span class="has-sub-category"><i class="fas fa-angle-right"></i></span>
            </a>

            <ul class="category corner-triangle {{ session('language') == 'arabic' ? 'top-left' : 'top-right'}} is-hidden pb-0">
                <li class="go-back"><a href=""><i class="fas fa-angle-left"></i>Menu</a></li>

                <li class="mb-0 p-0">
                    <a href="{{ url('/') }}" class="py-3">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span>{{__('home')}}</span>
                    </a>
                </li>
                <li class=" mb-0 p-0"> <!-- all-category-devided -->
                    <a href="{{route('courses.index')}}" class="py-3">
                        <span class="icon"><i class="fa fa-th"></i></span>
                        <span>{{__('courses')}}</span>
                    </a>
                </li>
                @if (Auth::check())
                    <li class="mb-0 p-0"> <!-- all-category-devided -->
                        <a href="{{route('my-courses')}}" class="py-3">
                            <span class="icon"><i class="fas fa-chalkboard"></i></span>
                            <span>{{__('my_educational_board')}}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        <div class="mobile-menu-helper-bottom"></div>
    </ul>


    <nav class="mobile-nav ">
        <a href="{{ url('/') }}" class="bloc-icon">
            <span class="d-block text-center"><i class="fas fa-home"></i></br>{{__('home')}}</span>
        </a>
        <a href="{{route('courses.index')}}" class="bloc-icon">
            <span class="d-block text-center"><i class="fa fa-th"></i></br>{{__('courses')}}</span>
        </a>
        @if (Auth::check())
        <a href="{{route('my-courses')}}" class="bloc-icon">
            <span class="d-block text-center"><i class="fas fa-chalkboard"></i></br>{{__('my_board')}}</span>
        </a>
        @endif
        <a href="#mobile-primary-nav" class="bloc-icon mobile-nav-trigger">
            <p class="d-block text-center mb-0"><i class="fas fa-align-justify"></i></br>{{__('menu')}}</p>
        </a>
    </nav>


</div>

<!DOCTYPE html>
  <html lang="en">
      
       
       
    <head>
        <title> @yield('title','')</title>
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="author" content="{{get_settings('author')}}" />
        @php
            $seo_pages = array('course_page');
        @endphp
        
        @if (in_array($page_name, $seo_pages))
            @php $course_details = $this->crud_model->get_course_by_id($course_id)->row_array(); @endphp

            @if ($course_details)
                <meta name="keywords" content="{{$course_details['meta_keyword']}}"/>
                <meta name="description" content="{{$course_details['meta_description']}}" />
            @endif
        @else
            @php $setting = setting(); @endphp
            <meta name="keywords" content="{{$setting->meta_keyword}}"/>
            <meta name="description" content="{{$setting->meta_description}}" />
        @endif
        <link name="favicon" rel="shortcut icon" type="image/x-icon" href="{{ config('app.url') }} {{setting()->company_fav}}" />

        @include('frontend.default.layouts.header') {{-- Include header file --}}
        @yield("page_css")
    </head>


   
  <body class="gray-bg {{ session('language') == 'arabic' ? 'rtl' : ''}}">
        @if (Auth::check())
          @include('frontend.default.layouts.logged_in_header') 
        @else
          @include('frontend.default.layouts.logged_out_header') 
        @endif

        @if(get_frontend_settings('cookie_status') == 'active')
            @include('frontend.default.layouts.eu-cookie') 
        @endif

        @if($page_name === null)
            <!-- include $path; -->
        @else
          @include('frontend.default.layouts.'.$page_name ) 
        @endif

        @include('frontend.default.layouts.footer')
        @include('frontend.default.layouts.includes_bottom')
        @include('frontend.default.layouts.modal')
        @include('frontend.default.layouts.common_scripts')
         
        @yield("page_js")


    </body>
</html>

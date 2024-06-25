<!doctype html>
<html lang="{{settings()['language']}}" class="light-style layout-navbar-fixed {{ (Cookie::get('sidebar-status') == 'close' )? 'layout-menu-collapsed':'' }} ">
        <?php 
       
        if( auth()->user()){
            $settings =  settings();
            $permissions =  get_user_permission();
            if($permissions[0]){
              $modules_ids = $permissions[0]['modules_ids'];
            }else{
              $modules_ids = array();
            }
           

          }
         
          ?>
    <head>
        <title> @yield('title','')</title>
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        @include('dashboard.header') {{-- Include header file --}}
        @yield("page_css")
        <script type="text/javascript">
                var APP_URL = {!! json_encode(url('/')) !!}
                var contactUsForAssistance ="{{__('An unspecified error occurred please contact us for assistance')}}";
                var error ="{{__('Error')}}"; 
        </script>
    </head>


   
  <body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
     <!-- Layout wrapper -->
     <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

            @include('dashboard.sidebar') {{-- Include sidebar file --}}
            @include('dashboard.navbar')
   
            @yield("middle_content")


            <?php 
              $locale = App::getlocale();
              if($locale == ''){
                $locale = 'en';
              }
              $jsonString = file_get_contents(base_path('lang/'.$locale.'.json'));
              $details = json_decode($jsonString, true);
            ?>
            <script>
                var trans =  @json($details);
            </script>

            @include('dashboard.footer') {{-- Include footer file --}}
            @yield("page_js")


    </body>
</html>

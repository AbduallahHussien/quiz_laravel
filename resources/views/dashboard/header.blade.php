
<meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Site Title')}}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('resources/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Font Awesome Icons -->

    <link rel="stylesheet" href="{{ URL::asset('resources/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/core.css') }}" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/pages/core2.css') }}" class="template-customizer-core-css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/theme-default.css') }}" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/css/demo.css?v=1') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ URL::asset('resources/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('resources/js/config.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('resources/plugins/ekko-lightbox/ekko-lightbox.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">


  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->

  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/noty/lib/noty.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/noty/lib/themes/mint.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('resources/plugins/waitme/waitMe.min.css')}}">
  <script src="{{ URL::asset('resources/js/underscore-js.js') }}"></script>

  @if(App::isLocale('ar'))
    <link rel="stylesheet" href="{{ URL::asset('resources/dist/css/rtl.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/core_ar.css') }}" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/pages/core2_ar.css') }}" class="template-customizer-core-css') }}" />
  @endif
 
  <script>  var data = 
  { "routes": [ 
        { "users":"{{route('users.index')}}"},
        { "user create":"{{route('users.create')}}"} ,
        { "roles":"{{route('roles.index')}}"} ,
        { "permissions":"{{route('permissions')}}"},
        { "customers":"{{route('customers.index')}}"},
        { "artists":"{{route('artists.index')}}"},
        { "categories":"{{route('categories.index')}}"},
        { "slides":"{{route('slides.index')}}"},
        { "coupons":"{{route('coupons.index')}}"},
        { "posts":"{{route('posts.index')}}"},
        { "pages":"{{route('pages.index')}}"},
        { "vendors":"{{route('vendors.index')}}"},
        { "assets":"{{route('asset-categories.index')}}"},
        { "vendors":"{{route('vendors.index')}}"},
        { "themes":"{{route('themes.index')}}"},
        { "styles":"{{route('styles.index')}}"},
        { "colors":"{{route('colors.index')}}"},
        { "locations":"{{route('locations.index')}}"},
        { "paintings":"{{route('paintings.index')}}"},
        { "addons":"{{route('addons.index')}}"},
        { "rooms":"{{route('rooms.index')}}"},
        { "courses":"{{route('course-categories.index')}}"},
        { "purchase orders":"{{route('purchase-orders.index')}}"},
        { "sales orders":"{{route('sales-orders.index')}}"},
        { "configurations":"{{route('settings.index')}}"},
      





     
      

    ] };
  </script>
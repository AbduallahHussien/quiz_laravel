<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{__('Forgot Password')}}</title>

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

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/core.css') }}" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/theme-default.css') }}" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />


      <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ URL::asset('resources/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('resources/js/config.js') }}"></script>
  </head>

  <body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
  <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Forgot Password -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <img src="{{ URL::asset('resources/img/admin-logo-dark.png')}}" alt=""> 
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">{{__('Forgot Password')}}? 🔒</h4>
              <p class="mb-4">{{__('Enter your email and we will send you instructions to reset your password')}}</p>
              @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
              <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.email') }}">
              @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">{{__('Email')}}</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                  placeholder="{{__('Enter Your Email')}}" />
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
                <button type="submit"  class="btn btn-primary d-grid w-100">{{__('Send Reset Link')}}</button>
              </form>
              <div class="text-center">
                <a href="{{route('home')}}" class="d-flex align-items-center justify-content-center">
                  <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                  {{__('Back To Login')}}
                </a>
              </div>
            </div>
          </div>
          <!-- /Forgot Password -->
        </div>
      </div>
    </div>


<script src="{{ URL::asset('resources/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/js/bootstrap.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ URL::asset('resources/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ URL::asset('resources/js/main.js') }}"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>

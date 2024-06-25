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
            <div class="card">
                <!-- <div class="card-header">{{ __('Reset Password') }}</div> -->

                        <div class="card-body">
                        <div class="app-brand justify-content-center">
                        <a href="javascript:void(0)" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                        <img src="{{ URL::asset('resources/img/admin-logo-dark.png')}}" alt=""> 
                        </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">{{__('Reset Password')}}? 🔒</h4>
                    <form id="formAuthentication" method="POST" class="mb-3" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <label for="email" class="form-label">{{__('Email')}}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                            placeholder="{{__('Enter Your Email')}}" />
                        </div>

                        <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">{{__('Password')}}</label>
                            <div class="input-group input-group-merge">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password-confirm">{{__('Forgot Password')}}</label>
                            <div class="input-group input-group-merge">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">{{__('Reset Password')}}</button>
                        </div>
                        
                    </form>
                </div>
            </div>
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


<!DOCTYPE html>
<?php $settings =  settings();?>
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

    <title>{{__('login')}}</title>

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
    @if(App::isLocale('ar'))
    <link rel="stylesheet" href="{{ URL::asset('resources/dist/css/rtl.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/core_ar.css') }}" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('resources/vendor/css/pages/core2_ar.css') }}" class="template-customizer-core-css') }}" />
    @endif
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
    <!-- Content -->
<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y"> 
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                  <img style="height: 30%;width: 30%;-webkit-mask-size: cover;margin: 0 auto;"src="{{file_exists(public_path('images/'.$settings['logo'])) ?URL::to('/').'/images/'.$settings['logo']:URL::to('/').'/resources/img/no-img-icon.png'}}" alt=""> 
                  </span>
                </a>
              </div>
              @if (Session::has('success'))
                  <div class="alert alert-success">
                      {{ Session::get('success') }}
                  </div>
              @elseif(Session::has('warning'))
                  <div class="alert alert-warning">
                      {{ Session::get('warning') }}
                  </div>
              @elseif(Session::has('danger'))
                  <div class="alert alert-danger">
                      {{ Session::get('danger') }}
                  </div>
              @else
              <p class="mb-4 text-center">{{__('Sign-in to your account')}}</p>
              @endif
                <form id="formAuthentication" class="mb-3"method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{__('email')}}</label>
                            <input
                               
                                class="form-control @error('email') is-invalid @enderror"
                                id="email" type="email"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            />
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{__('Password')}}</label>
                                <a href="{{ route('password.request') }}">
                                <small>{{__('Forgot Password')}}?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"
                                name="password" required autocomplete="current-password"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label" for="remember-me">{{__('Remember Me') }}</label>
                            </div>
                        </div>

                       
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">{{__('Login')}}</button>
                        </div>
                    </form>
            </div>
          </div>
          <div class="divider divider-primary">
              <div class="divider-text "><span class="h6">{{__("Don't have account ?")}}</span></div>
          </div> 
          <div class="row">
            <a class="btn btn-light" href="{{route('register')}}">{{__('Create an account now')}}</a>
          </div> 
          <!-- /Register -->
        </div>
      </div>
    </div>
<!-- Core JS -->
    <!-- build:js resources/vendor/js/core.js -->
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

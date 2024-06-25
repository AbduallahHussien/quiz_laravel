<!DOCTYPE html>
<?php $settings =  settings();
?>
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

    <title>{{__('Register')}}</title>

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
              <!-- /Logo -->
             
              <p class="mb-4 text-center">{{__('Create new account')}}</p>
                <form id="formAuthentication" class="mb-3"method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label">{{__('Full Name')}}</label>
                            <input
                               
                                class="form-control @error('full_name') is-invalid @enderror"
                                id="full_name" type="full_name"
                                name="full_name" required  autofocus
                            />
                            @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{__('Phone')}}</label>
                            <input
                               
                                class="form-control @error('phone') is-invalid @enderror"
                                id="phone" type="phone"
                                name="phone"  required 
                            />
                            @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{__('Email')}}</label>
                            <input
                               
                                class="form-control @error('email') is-invalid @enderror"
                                id="email" type="email"
                                name="email"  required 
                            />
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">{{__('Gender')}}</label>
                            <select id="gender" class="form-select text-uppercase" name="gender" required >
                                <option value="male" class="text-uppercase" >{{__('Male')}}</option>
                                <option value="female" class="text-uppercase" >{{__('Female')}}</option>
                            </select>
                            @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">{{__('Birth Date')}}</label>
                            <input
                               
                                class="form-control @error('birth_date') is-invalid @enderror"
                                id="birth_date" type="date"
                                name="birth_date" 
                                max="{{ \Carbon\Carbon::now()->subYears(10)->format('Y-m-d') }}"
                                 required 
                            />
                            @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="country_id" class="form-label">{{__('Country')}}</label>
                                <select id="country_id" class="form-select text-uppercase" name="country_id" required >
                                  <option value="" selected >{{__('Select Country')}}</option>
                                  @foreach($countries as $country)
                                  <option value="{{$country->id}}" class="text-uppercase" >{{$country->name}}</option>
                                  @endforeach
                                </select>   
                            @error('country_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">{{__('Area')}}</label>
                            <input
                               
                                class="form-control @error('area') is-invalid @enderror"
                                id="area" type="text"
                                name="area"  required 
                            />
                            @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-password-toggle">
                            <label for="password" class="form-label">{{__('Password')}}</label>

                            <div class="input-group input-group-merge">

                                <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"
                                 name="password" required autocomplete="new-password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label for="password-confirm" class="form-label">{{__('Confirm Password')}}</label>
                            <div class="input-group input-group-merge">
                            <input id="password-confirm" type="password" 
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                class="form-control" name="password_confirmation"
                                aria-describedby="password"
                                 required autocomplete="new-password">
                             <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                             </div>
                        </div>
                       
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"  id="is_vendor" name="is_vendor">
                                <label class="form-check-label" for="is_vendor">{{__('Register as a vendor')}}</label>
                            </div>
                        </div>
                         <!-- Terms & Conditions Checkbox -->
                         <div class="mb-3">
                            <input type="checkbox" class="form-check-input" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>
                            
                            <label for="terms">
                                I agree to the <a target="_blank" href="{{$settings['terms_page']}}">Terms & Conditions</a>
                            </label>
                            @error('terms')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" disabled id="submitButton" type="submit">{{__('Register')}}</button>
                        </div>
                    </form>
            </div>
          </div>
          <div class="divider divider-primary">
              <div class="divider-text "><span class="h6">{{__("Already have account ?")}}</span></div>
          </div> 
          <div class="row">
            <a class="btn btn-light" href="{{route('login')}}">{{__('Sign-in to your account')}}</a>
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
    <script>
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('password-confirm');
      const submitButton = document.getElementById('submitButton');
      const termsCheckbox = document.getElementById('terms');
      function toggleSubmitButton() {
             submitButton.disabled = !termsCheckbox.checked;
        }

      termsCheckbox.addEventListener('change', toggleSubmitButton);
      const checkPasswordMatch = () => {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
       
        termsCheckbox.addEventListener('change', toggleSubmitButton);

        if (password === confirmPassword) {
          submitButton.disabled = false;
          submitButton.disabled = !termsCheckbox.checked;

        } else {
          submitButton.disabled = true;
        }
      };

      passwordInput.addEventListener('input', checkPasswordMatch);
      confirmPasswordInput.addEventListener('input', checkPasswordMatch);

      // email validation 
      const emailInput = document.getElementById('email');
      const validationFeedback = document.getElementById('validationServer05Feedback');

      const validateEmailInput = () => {
        const email = emailInput.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
          emailInput.classList.add('is-invalid');
          validationFeedback.style.display = 'block';
          submitButton.disabled = true;
        } else {
          emailInput.classList.remove('is-invalid');
          validationFeedback.style.display = 'none';
          submitButton.disabled = false;
        }
      };

      emailInput.addEventListener('input', validateEmailInput);

 

    // Add event listener to toggle the submit button when the checkbox state changes
   

    </script>
  </body>
</html>

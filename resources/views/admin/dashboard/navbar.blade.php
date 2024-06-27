     <!-- Navbar -->
<div class="layout-page">
     <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                <img src="{{ URL::asset('resources/img/avatars/search.png')}}" alt class="w-px-20 h-auto rounded-circle" />

                       
                        <input id="search" list="allresult"  autocomplete="off"  class="form-control border-0 shadow-none"/>
                          <datalist id="allresult">
                              <option value="{{route('users.index')}}">{{__('Users')}}</option> 
                          </datalist>
                </div>
              </div>
              <!-- /Search -->
              
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
            
              <li class="nav-item navbar-dropdown dropdown-alerts dropdown">
                  <a id="alerts" class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar" id="notify-counter">
                    <img src="{{ URL::asset('resources/img/avatars/notify.png')}}" alt class="w-px-20 pt-2 h-auto rounded-circle" />
                    <span class="counter">0</span>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      
                      <li class='single-alert text-center'  > <a class='dropdown-item ' href='#' > <span class='fw-semibold d-block'>{{__('Your inbox is empty!')}}</span> </a></li> 
                  </ul>
              
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ URL::asset('resources/img/avatars/profile.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ URL::asset('resources/img/avatars/profile.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block text-capitalize"><?php echo auth()->user()->username ?></span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('edit-profile',auth()->user()->id)}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">{{__('My Profile')}}</span>
                      </a>
                    </li>
                  
                    
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ url('/logout') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">{{__('Log Out')}}</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
     </nav>
    
    <!-- / Navbar -->
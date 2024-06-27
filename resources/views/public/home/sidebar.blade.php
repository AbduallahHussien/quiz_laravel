      <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme rounded-2">
            <span class="app-brand-logo demo">
                <img src="{{file_exists(public_path('images/'.$settings['logo'])) ?URL::to('/').'/images/'.$settings['logo']:URL::to('/').'/resources/img/no-img-icon.png'}}" alt="" style="height: auto; width:100%;margin:0 auto">
            </span>  
            <div class="app-brand demo">
        
                <a href="{{route('admin')}}" class="menu-link">
                  <i class='menu-icon tf-icons bx bxs-dashboard' ></i>
                  <div data-i18n="Analytics" class="dash">{{__('Dashboard')}}</div>
                </a>
              
                <a href="javascript:void(0);" id="sidebar-arrow" class="layout-menu-toggle menu-link text-large ms-auto">
                  <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <ul class="menu-inner py-1">
                        <!-- users -->
                          
                            <li class="menu-item {{Request::segment(1) ==='permissions' || Request::segment(1) ==='users'|| Request::segment(1) ==='roles'? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-user' ></i>
                                  <div data-i18n="Layouts">{{__('Users')}}</div>
                                </a>
                            
                              <ul class="menu-sub "> 
                              @if(in_array("1/view", $modules_ids))
                                  <li class="menu-item {{Request::segment(1) === 'users' ? 'open active' : '' }}">
                                    <a href="{{route('users.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Users')}}</div>
                                    </a>
                                  </li>  
                             
                                  <li class="menu-item {{Request::segment(1) === 'roles' ? 'open active' : '' }}">
                                    <a href="{{route('roles.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Roles')}}</div>
                                    </a>
                                  </li> 
                              @endif 
                              @if(in_array("2/view", $modules_ids))     
                                  <li class="menu-item {{Request::segment(1) === 'permissions' ? 'open active' : '' }}">
                                    <a href="{{route('permissions')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Permissions')}}</div>
                                    </a>
                                  </li>
                              @endif
                              </ul>
          
                            </li>
                          
                          @if(in_array("4/view", $modules_ids))
                            <li class="menu-item {{Request::segment(1) ==='customers' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-group' ></i>
                                  <div data-i18n="Layouts">{{__('Customers')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'customers' ? 'open active' : '' }}">
                                    <a href="{{route('customers.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Customers')}}</div>
                                    </a>
                                  </li>  
                                
                              </ul>
          
                            </li>
                          @endif

                          @if(in_array("13/view", $modules_ids))
                            <li class="menu-item {{(Request::segment(1) === 'categories' && request()->query('type') === 'artists') || Request::segment(1) ==='artists' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-game' ></i>
                                  <div data-i18n="Layouts">{{__('Artists')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'artists' ? 'open active' : '' }}">
                                    <a href="{{route('artists.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Artists')}}</div>
                                    </a>
                                  </li>  

                                  <li class="menu-item {{Request::segment(1) === 'categories' && request()->query('type') === 'artists' ? 'open active' : '' }}">
                                    <a href="{{route('categories.index')}}?type=artists" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Categories')}}</div>
                                    </a>
                                  </li>  
                                
                              </ul>
          
                            </li>
                          @endif

                          @if(in_array("23/view", $modules_ids))
                            <li class="menu-item {{Request::segment(1) ==='slides' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-images' ></i>
                                  <div data-i18n="Layouts">{{__('Slides')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'slides' ? 'open active' : '' }}">
                                    <a href="{{route('slides.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Slides')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif                          
                          
                          @if(in_array("24/view", $modules_ids))
                            <li class="menu-item {{Request::segment(1) ==='coupons' ? 'open active' : '' }}">
                                
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class='menu-icon tf-icons bx bx-qr' ></i>
                                <div data-i18n="Layouts">{{__('Coupons')}}</div>
                              </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'coupons' ? 'open active' : '' }}">
                                    <a href="{{route('coupons.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Coupons')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif


                          @if(in_array("21/view", $modules_ids))
                            <li class="menu-item {{(Request::segment(1) === 'categories' && request()->query('type') === 'posts') || Request::segment(1) ==='posts' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-book-open' ></i>
                                  <div data-i18n="Layouts">{{__('Posts')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'posts' ? 'open active' : '' }}">
                                    <a href="{{route('posts.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Posts')}}</div>
                                    </a>
                                  </li>  

                                  <li class="menu-item {{Request::segment(1) === 'categories' && request()->query('type') === 'posts' ? 'open active' : '' }}">
                                    <a href="{{route('categories.index')}}?type=posts" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Categories')}}</div>
                                    </a>
                                  </li>  
                                
                              </ul>
          
                            </li>
                          @endif


                          @if(in_array("22/view", $modules_ids))
                            <li class="menu-item {{ Request::segment(1) ==='pages' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-message-square-edit' ></i>
                                  <div data-i18n="Layouts">{{__('Pages')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'pages' ? 'open active' : '' }}">
                                    <a href="{{route('pages.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Pages')}}</div>
                                    </a>
                                  </li>  
                                
                              </ul>
          
                            </li>
                          @endif

                          @if(in_array("14/view", $modules_ids))
                            <li class="menu-item {{ Request::segment(1) ==='vendors' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-planet' ></i>
                                  <div data-i18n="Layouts">{{__('Vendors')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'vendors' ? 'open active' : '' }}">
                                    <a href="{{route('vendors.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Vendors')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif                          
                          
                          @if(in_array("25/view", $modules_ids))
                            <li class="menu-item {{ Request::segment(1) ==='suppliers' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-package' ></i>
                                  <div data-i18n="Layouts">{{__('Suppliers')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'suppliers' ? 'open active' : '' }}">
                                    <a href="{{route('suppliers.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Suppliers')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif

                          @if(in_array("20/view", $modules_ids))
                            <li class="menu-item {{ Request::segment(1) ==='assets' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-building-house' ></i>
                                  <div data-i18n="Layouts">{{__('Assets')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'assets' ? 'open active' : '' }}">
                                    <a href="{{route('asset-categories.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('All Assets')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif
                         
                            <li class="menu-item {{( Request::segment(1) ==='categories' && request()->query('type') == '') || Request::segment(1) ==='locations'|| Request::segment(1) === 'addonsItems'  ||  Request::segment(1) === 'addonsItems-form'  || Request::segment(1) ==='addons' ||  Request::segment(1) ==='addonsItems' || Request::segment(1) ==='themes' || Request::segment(1) ==='styles' || Request::segment(1) === 'colors' || Request::segment(1) === 'paintings' || Request::segment(1) === 'certificates'  ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                               
                                  <i class='menu-icon tf-icons bx bx-map' ></i>
                                  <div data-i18n="Layouts">{{__('Stock')}}</div>
                                </a>

                              <ul class="menu-sub "> 
                              @if(in_array("5/view", $modules_ids)) 
                                  <li class="menu-item {{ ( Request::segment(1) ==='categories' && request()->query('type') == '') ? 'open active' : '' }}">
                                    <a href="{{route('categories.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Categories')}}</div>
                                    </a>
                                  </li>  
                              @endif  
                              @if(in_array("6/view", $modules_ids)) 
                                  <li class="menu-item {{Request::segment(1) === 'themes' ? 'open active' : '' }}">
                                    <a href="{{route('themes.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Themes')}}</div>
                                    </a>
                                  </li>
                              @endif
                              @if(in_array("7/view", $modules_ids))
                                  <li class="menu-item {{Request::segment(1) === 'styles' ? 'open active' : '' }}">
                                    <a href="{{route('styles.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Styles')}}</div>
                                    </a>
                                  </li>
                              @endif
                              @if(in_array("8/view", $modules_ids))
                                  <li class="menu-item {{Request::segment(1) === 'colors' ? 'open active' : '' }}">
                                    <a href="{{route('colors.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Colors')}}</div>
                                    </a>
                                  </li>
                              @endif
                              @if(in_array("9/view", $modules_ids))
                                  <li class="menu-item {{Request::segment(1) === 'locations' ? 'open active' : '' }}">
                                    <a href="{{route('locations.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Locations')}}</div>
                                    </a>
                                  </li>
                              @endif
                              @if(in_array("10/view", $modules_ids))
                                  <li class="menu-item {{Request::segment(1) === 'paintings'  || Request::segment(1) === 'certificates'? 'open active' : '' }}">
                                    <a href="{{route('paintings.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Paintings')}}</div>
                                    </a>
                                  </li>
                              @endif
                              @if(in_array("11/view", $modules_ids))
                                <li class="menu-item {{Request::segment(1) === 'addons' || Request::segment(1) === 'addonsItems'  ||  Request::segment(1) === 'addonsItems-form'  ? 'open active' : '' }}">
                                  <a href="{{route('addons.index')}}" class="menu-link ">
                                    <div data-i18n="Layouts">{{__('Material')}}</div>
                                  </a>
                                </li>
                                 
                              @endif
                              </ul>
          
                            </li>


                            <li class="menu-item {{ Request::segment(1) === 'rooms'  ? 'open active' : '' }}">
                                  
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                              
                                <i class='menu-icon tf-icons bx bx-network-chart' ></i>
                                <div data-i18n="Layouts">{{__('Services')}}</div>
                              </a>

                              <ul class="menu-sub "> 
                                @if(in_array("17/view", $modules_ids)) 
                                    <li class="menu-item {{ Request::segment(1) ==='rooms' ? 'open active' : '' }}">
                                      <a href="{{route('rooms.index')}}" class="menu-link ">
                                        <div data-i18n="Layouts">{{__('Rooms')}}</div>
                                      </a>
                                    </li>  
                                @endif  
                              </ul>

                              <ul class="menu-sub "> 
                                @if(in_array("18/view", $modules_ids)) 
                                    <li class="menu-item {{ Request::segment(1) ==='courses' || Request::segment(1) ==='course-categories' ? 'open active' : '' }}">
                                      <a href="{{route('course-categories.index')}}" class="menu-link ">
                                        <div data-i18n="Layouts">{{__('Courses')}}</div>
                                      </a>
                                    </li>  
                                @endif  
                              </ul>
            
                            </li>
                       
                       
              

                          @if(in_array("15/view", $modules_ids))
                            <li class="menu-item {{ Request::segment(1) ==='purchase-orders' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-archive-in' ></i>
                                  <div data-i18n="Layouts">{{__('Purchase Orders')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'purchase-orders' ? 'open active' : '' }}">
                                    <a href="{{route('purchase-orders.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Purchase Orders')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif

                          @if(in_array("16/view", $modules_ids))
                            <li class="menu-item {{ Request::segment(1) ==='sales-orders' ? 'open active' : '' }}">
                                
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class='menu-icon tf-icons bx bx-archive-out' ></i>
                                  <div data-i18n="Layouts">{{__('Sales Orders')}}</div>
                                </a>

                              <ul class="menu-sub ">  
                                  <li class="menu-item {{Request::segment(1) === 'sales-orders' ? 'open active' : '' }}">
                                    <a href="{{route('sales-orders.index')}}" class="menu-link ">
                                      <div data-i18n="Layouts">{{__('Sales Orders')}}</div>
                                    </a>
                                  </li>  
                              </ul>
          
                            </li>
                          @endif
            
            
              <!-- Settings -->
              @if(in_array("3/view", $modules_ids))  
              <li class="menu-item {{ Request::segment(1) === 'settings'   ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class='menu-icon tf-icons bx bx-cog'></i>
                  <div data-i18n="Settings">{{__('Settings')}}</div>
                </a>
                <ul class="menu-sub">

                    <li class="menu-item {{Request::segment(1) === 'settings' ? 'open active' : '' }}">
                          <a href="{{route('settings.index')}}" class="menu-link">
                                <i class='menu-icon tf-icons bx bxs-coupon' ></i>
                                <div data-i18n="Authentications">{{__('Configurations')}}</div>
                          </a>     
                    </li>


                 
                </ul>
              </li>
            @endif
              <!--End Settings -->
              
            
            

            
              

            </ul>
        </aside>
        <!-- / Menu -->
        

        
        
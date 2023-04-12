<div class="main-menu menu-fixed menu-accordion menu-shadow menu-dark" data-scroll-to-active="true">
    <div class="navbar-header" style="height: unset !important;">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto" style="margin: 0 auto;">
                <a class="navbar-brand" href="{{ url('admin') }}">
                            <span class="brand-logo"><img alt="logo" src="{{ asset('dashboard/app-assets/images/logo/Group 16027.png') }}"
                                                          style="max-width: 34% !important; margin: 0 auto; display: flex;" />
                        </span>

                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @can('admin.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('admins')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('admin.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('admins')</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('role.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('role.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('roles')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('car.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('cars')</span></a>
                    <ul class="menu-content">
                        @can('brand.view')
                            <li class="nav-item {{ request()->routeIs('brand.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('brand.index') }}">
                                    <i data-feather="file-text"></i><span
                                        class="menu-title text-truncate">@lang('Brand Cars')</span>
                                </a>
                            </li>
                        @endcan
                        @can('model.view')
                            <li class="nav-item {{ request()->routeIs('model.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('model.index') }}">
                                    <i data-feather="file-text"></i><span
                                        class="menu-title text-truncate">@lang('Model Cars')</span>
                                </a>
                            </li>
                        @endcan
                        @can('color.view')
                            <li class="nav-item  {{ request()->routeIs('color.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('color.index') }}">
                                    <i data-feather="file-text"></i><span
                                        class="menu-title text-truncate">@lang('Color Cars')</span>
                                </a>
                            </li>
                        @endcan
                        @can('engine.view')
                            <li class="nav-item {{ request()->routeIs('engines.index') ? 'active' : '' }} ">
                                <a class="d-flex align-items-center" href="{{ route('engines.index') }}">
                                    <i data-feather="file-text"></i><span
                                        class="menu-title text-truncate">@lang('Engine Cars')</span>
                                </a>
                            </li>
                        @endcan
                        @can('fuelType.view')
                            <li class="nav-item {{ request()->routeIs('fuelType.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('fuelType.index') }}">
                                    <i data-feather="file-text"></i><span
                                        class="menu-title text-truncate">@lang('Fuel Type Cars')</span>
                                </a>
                            </li>
                        @endcan
                        @can('transmission.view')
                            <li class="nav-item {{ request()->routeIs('transmission.index') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('transmission.index') }}">
                                    <i data-feather="file-text"></i><span
                                        class="menu-title text-truncate">@lang('Transmission')</span>
                                </a>
                            </li>
                        @endcan
                    </ul>

                </li>
            @endcan
            @can('place.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate"
                              data-i18n="Charts">@lang('country'),@lang('city')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('country.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('country.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('country')</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('city.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('city.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('city')</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('area.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('area.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('area')</span>
                            </a>
                        </li>

                    </ul>

                </li>
            @endcan
            @can('deal.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('deals')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('deals.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('deals.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('deals')</span>
                            </a>
                        </li>



                    </ul>

                </li>
            @endcan
            @can('user.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('users')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('usertype.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('usertype.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('users')</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('usertype.type.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('usertype.type.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('type')</span>
                            </a>
                        </li>

                    </ul>

                </li>
            @endcan
            @can('ads.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('Car ads')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('ads.car.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('ads.car.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('ads')</span>
                            </a>
                        </li>


                    </ul>

                </li>
            @endcan
            @can('setting.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('settings')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('setting.getyear') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('setting.getyear') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('year')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('order.view')
                <li class="nav-item has-sub " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        @php
                            $count = \App\Models\UserOrder::where('status', \App\Models\UserOrder::pending)->count();
                        @endphp
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('user_order')</span>
                        <h5 class="text-danger">
                            <span id="count">{{ @$count }}</span>
                        </h5>
                    </a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('orders.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('orders.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('user_order')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('Appointment.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('Order Appointment')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('OrderAppointment.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('OrderAppointment.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('Order Appointment')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('Plate.view')
                <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('Plates')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('Plates.index') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('Plates.index') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('Plates')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
    </div>
</div>

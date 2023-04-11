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
            <li class="nav-item has-sub  " style="">
                    <a class="d-flex align-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-pie-chart">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title text-truncate" data-i18n="Charts">@lang('profile')</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{ request()->routeIs('user.profile') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('user.profile') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('profile')</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @can('PHOTOGRAPHER')
            <li class="nav-item has-sub  " style="">
                <a class="d-flex align-items-center" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-pie-chart">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                        <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                    </svg>
                    @php
                        $count = \App\Models\OrderAppointment::where(function ($query){
            $query->where('photographer_uuid', auth('user')->user()->uuid)->orWhere('status', 1)->where('area_uuid', auth('user')->user()->area_uuid);
        })->where('status', \App\Models\OrderAppointment::pending)->count();
                    @endphp
                    <span class="menu-title text-truncate" data-i18n="Charts">@lang('user_order')</span>
                    <h5 class="text-danger">
                        <span id="countappointment">{{ @$count }}</span>
                    </h5>
                <ul class="menu-content">
                    <li class="nav-item {{ request()->routeIs('user.appointment') ? 'active' : '' }} ">
                        <a class="d-flex align-items-center" href="{{ route('user.appointment') }}">
                            <i data-feather="file-text"></i><span
                                class="menu-title text-truncate">@lang('Order Appointment')</span>
                        </a>
                    </li>

                </ul>
            </li>
            @endcan
            @can('DISCOUNT_STORE')
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
                        <li class="nav-item {{ request()->routeIs('user.deal') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('user.deal') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('deals')</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan
            @can('SHOWROOM')
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
                        <li class="nav-item {{ request()->routeIs('user.ads') ? 'active' : '' }} ">
                            <a class="d-flex align-items-center" href="{{ route('user.ads') }}">
                                <i data-feather="file-text"></i><span
                                    class="menu-title text-truncate">@lang('Car ads')</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan


        </ul>
    </div>
</div>

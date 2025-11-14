<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo flex-shrink-0 d-none d-md-flex align-items-center px-8" id="kt_app_sidebar_logo">
        <!--begin::Logo-->
        <a href="{{ route('admin.buyer.index') }}" class="d-flex align-items-center">
            <img alt="Logo" src="assets/media/logos/ticketify_logo.png"
                class="h-60px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
            <img alt="Logo" src="assets/media/logos/ticketify_logo.png" class="h-60px theme-dark-show" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-1"></i>
            </div>
        </div>
        <!--end::Aside toggle-->
    </div>
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5 mx-3"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold px-1" id="kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <!--begin:Menu item - Dashboard-->
                {{-- <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div> --}}
                <!--end:Menu item-->

                <!--begin:Menu item - Event-->
                <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.event.*') || Request::routeIs('admin.products.*') ? 'active' : '' }}"
                        href="{{ route('admin.event.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-calendar fs-2"></i>
                        </span>
                        <span class="menu-title">Event</span>
                    </a>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item - Tiket-->
                <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.tickets.*') ? 'active' : '' }}"
                        href="{{ route('admin.tickets.index') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-document fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Tiket</span>
                    </a>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item - Diskon-->
                {{-- <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.discounts.*') ? 'active' : '' }}"
                        href="{{ route('admin.discounts.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-discount fs-2"></i>
                        </span>
                        <span class="menu-title">Diskon</span>
                    </a>
                </div> --}}
                <!--end:Menu item-->

                <!--begin:Menu item - Pembeli-->
                <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.buyer.*') ? 'active' : '' }}"
                        href="{{ route('admin.buyer.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-people fs-2"></i>
                        </span>
                        <span class="menu-title">Pembeli</span>
                    </a>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item - Check-In-->
                {{-- <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.checkin.*') ? 'active' : '' }}"
                        href="{{ route('admin.checkin.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-entrance-right fs-2"></i>
                        </span>
                        <span class="menu-title">Check-In</span>
                    </a>
                </div> --}}
                <!--end:Menu item-->

                <!--begin:Menu item - OTS (On The Spot Sales)-->
                {{-- <div class="menu-item">
                    <a class="menu-link {{ Request::routeIs('admin.ots-sales.*') ? 'active' : '' }}"
                        href="{{ route('admin.ots-sales.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-shop fs-2"></i>
                        </span>
                        <span class="menu-title">OTS</span>
                    </a>
                </div> --}}
                <!--end:Menu item-->

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer d-flex align-items-center px-8 pb-10" id="kt_app_sidebar_footer">
        <!--begin::User-->
        <div class="">
            <!--begin::User info-->
            <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
                <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                    <img src="assets/media/avatars/300-1.jpg" alt="image" />
                </div>
                <!--begin::Name-->
                <div class="d-flex flex-column align-items-start justify-content-center ms-3">
                    <span class="text-gray-500 fs-8 fw-semibold">Hello</span>
                    <a href="#"
                        class="text-gray-800 fs-7 fw-bold text-hover-primary">{{ Auth::user()->name ?? 'Admin' }}</a>
                </div>
                <!--end::Name-->
            </div>
            <!--end::User info-->
            <!--begin::User account menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px me-5">
                            <img alt="Logo" src="assets/media/avatars/300-1.jpg" />
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                            <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name ?? 'Admin' }}
                                {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span> --}}
                            </div>
                            <a href="#"
                                class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email ?? 'admin@admin.com' }}</a>
                        </div>
                        <!--end::Username-->
                    </div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                        <span class="menu-title position-relative">Mode
                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                            </span></span>
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-night-day fs-2"></i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-moon fs-2"></i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="menu-link px-5 w-100 text-start d-flex align-items-center"
                            style="border: none; background: none; color: inherit;">
                            <span class="menu-icon">
                                <i class="ki-outline ki-exit-right fs-2"></i>
                            </span>
                            <span class="menu-title">Sign Out</span>
                        </button>
                    </form>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::User account menu-->
        </div>
        <!--end::User-->
    </div>
    <!--end::Footer-->
</div>
<!--end::Sidebar-->

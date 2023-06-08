<!--begin::Header-->
<div id="kt_header" class="header">
    <!--begin::Header top-->
    <div class="header-top d-flex align-items-stretch flex-grow-1">
        <!--begin::Container-->
        <div class="d-flex  container-fluid  align-items-stretch">
            <!--begin::Brand-->
            <div class="d-flex align-items-center align-items-lg-stretch me-5 flex-row-fluid">
                <!--begin::Heaeder navs toggle-->
                <button
                    class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n3 me-2"
                    id="kt_header_navs_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-2"><span class="path1"></span><span class="path2"></span></i>
                </button>
                <!--end::Heaeder navs toggle-->
                <!--begin::Logo-->
                <a href="/" class="d-flex align-items-center">
                    <img alt="Logo" src="{{ asset('assets/media/logos/demo20.svg') }}" class="h-25px h-lg-30px" />
                </a>
                <!--end::Logo-->
                <!--begin::Tabs wrapper-->
                <div class="align-self-end overflow-auto" id="kt_brand_tabs">
                    <!--begin::Header tabs wrapper-->
                    <div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs"
                        data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
                        <!--begin::Header tabs-->
                        <ul class="nav flex-nowrap text-nowrap">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('organization') ? 'active' : '' }}" href="/organization">Organization</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('issue') || request()->is('issue/*') ? 'active' : '' }}"
                                    data-bs-toggle="tab" href="#kt_header_navs_tab_context">Context Of The Organization</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('document') || request()->is('document/*') ? 'active' : '' }}"
                                    data-bs-toggle="tab" href="#kt_header_navs_tab_support">Support</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('internal-audit') || request()->is('internal-audit/*') || request()->is('meeting') || request()->is('meeting/*') || request()->is('schedule') || request()->is('schedule/*') || request()->is('instrument') || request()->is('instrument/*') || request()->is('finding') || request()->is('finding/*') ? 'active' : '' }}"
                                    data-bs-toggle="tab" href="#kt_header_navs_tab_peformance_evaluation">Performance
                                    Evaluation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('user') || request()->is('user/*') || request()->is('role') || request()->is('role/*') || request()->is('department') || request()->is('department/*') || request()->is('standard') || request()->is('standard/*') || request()->is('document-type') || request()->is('document-type/*') || request()->is('document-archive') || request()->is('document-archive/*') || request()->is('recycle') || request()->is('recycle/*') || request()->is('meeting-type') || request()->is('meeting-type/*') ? 'active' : '' }}"
                                    data-bs-toggle="tab" href="#kt_header_navs_tab_setting">Settings</a>
                            </li>
                        </ul>
                        <!--begin::Header tabs-->
                    </div>
                    <!--end::Header tabs wrapper-->
                </div>
                <!--end::Tabs wrapper-->
            </div>
            <!--end::Brand-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-center flex-row-auto">
                <!--begin::User-->
                <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">
                    <!--begin::User info-->
                    <div class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 ps-2 pe-2 me-n2"
                        data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <!--begin::Name-->
                        <div class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
                            <span
                                class="text-white opacity-75 fs-8 fw-semibold lh-1 mb-1">{{ auth()->user()->name }}</span>
                            <span class="text-white fs-8 fw-bold lh-1">
                                {{ auth()->user()->roles->pluck('name')->implode(',') }}</span>
                        </div>
                        <!--end::Name-->
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px symbol-md-40px">
                            <img src="{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/media/svg/avatars/blank.svg') }}"
                                alt="image" />
                        </div>
                        <!--end::Symbol-->
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
                                    <img alt="Logo"
                                        src="{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/media/svg/avatars/blank.svg') }}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <div class="fw-semibold text-muted fs-7">
                                        {{ auth()->user()->email }}
                                    </div>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('profile') }}" class="menu-link px-5">
                                My Profile
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="{{ route('logout') }}" class="menu-link px-5"
                                    onclick="event.preventDefault();
                            this.closest('form').submit();">
                                    Sign Out
                                </a>
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                </div>
                <!--end::User -->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header top-->
    <!--begin::Header navs-->
    <div
        class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0 overflow-hidden overflow-lg-visible">
        <div class="d-lg-flex  container-fluid  w-100">
            <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">

                <div class="tab-content">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade {{ request()->is('user') || request()->is('user/*') || request()->is('role') || request()->is('role/*') || request()->is('department') || request()->is('department/*') || request()->is('standard') || request()->is('standard/*') || request()->is('document-type') || request()->is('document-type/*') || request()->is('document-archive') || request()->is('document-archive/*') || request()->is('recycle') || request()->is('recycle/*') || request()->is('meeting-type') || request()->is('meeting-type/*') ? 'active show' : '' }}"
                        id="kt_header_navs_tab_setting">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0"
                                id="#kt_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('user') || request()->is('user/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->

                                    <a class="menu-link py-3" href="/user">
                                        <span class="menu-title">User</span>
                                    </a>

                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('role') || request()->is('role/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->

                                    <a class="menu-link py-3" href="/role">
                                        <span class="menu-title">Role</span>
                                    </a>

                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('department') || request()->is('department/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->

                                    <a class="menu-link py-3" href="/department">
                                        <span class="menu-title">Department</span>
                                    </a>

                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('standard') || request()->is('standard/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <a class="menu-link py-3" href="/standard">
                                        <span class="menu-title">Standard</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('document-type') || request()->is('document-type/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <a class="menu-link py-3" href="/document-type">
                                        <span class="menu-title">Document Type</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('document-archive') || request()->is('document-archive/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <a class="menu-link py-3" href="/document-archive">
                                        <span class="menu-title">Document Archive</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('meeting-type') || request()->is('meeting-type/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <a class="menu-link py-3" href="/meeting-type">
                                        <span class="menu-title">Meeting Type</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('recycle') || request()->is('recycle/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <a class="menu-link py-3" href="/recycle">
                                        <span class="menu-title">Recycle Bin</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                </div>

                <div class="tab-content">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade {{ request()->is('internal-audit') || request()->is('internal-audit/*') || request()->is('meeting') || request()->is('meeting/*') || request()->is('schedule') || request()->is('schedule/*') || request()->is('instrument') || request()->is('instrument/*') || request()->is('finding') || request()->is('finding/*') ? 'active show' : '' }}"
                        id="kt_header_navs_tab_peformance_evaluation">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0"
                                id="#kt_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('internal-audit') || request()->is('internal-audit/*') || request()->is('schedule') || request()->is('schedule/*') || request()->is('instrument') || request()->is('instrument/*') || request()->is('finding') || request()->is('finding/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->

                                    <a class="menu-link py-3" href="/internal-audit">
                                        <span class="menu-title">Internal Audit</span>
                                    </a>

                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('meeting') || request()->is('meeting/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <a class="menu-link py-3" href="/meeting">
                                        <span class="menu-title">Meeting</span>
                                    </a>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                </div>

                <div class="tab-content">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade {{ request()->is('document') || request()->is('document/*') ? 'active show' : '' }}"
                        id="kt_header_navs_tab_support">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0"
                                id="#kt_header_menu" data-kt-menu="true">
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="bottom-start"
                                    class="menu-item {{ request()->is('document') || request()->is('document/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <span class="menu-link py-3">
                                        <span class="menu-title">File Manager</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div
                                        class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('document') || request()->is('document/*') ? 'active' : '' }} py-3"
                                                href="/document">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-folder">
                                                        <i class="path1"></i>
                                                        <i class="path2"></i>
                                                    </i>
                                                </span>
                                                <span class="menu-title">Document</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->

                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                </div>
                <div class="tab-content">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade {{ request()->is('issue') ? 'active show' : '' }}"
                        id="kt_header_navs_tab_context">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0"
                                id="#kt_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div
                                    class="menu-item {{ request()->is('issue') || request()->is('issue/*') ? 'here show menu-here-bg' : '' }} menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->

                                    <a class="menu-link py-3" href="/issue">
                                        <span class="menu-title">Issue</span>
                                    </a>

                                    <!--end:Menu link-->
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Header navs-->
</div>
<!--end::Header-->

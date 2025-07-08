<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <meta name="description" content="TEDC ChatDoc AI">
        <meta name="keywords" content="Tedc, Chat Document, AI">
        <meta name="author" content="PIXINVENT">
        <title>TEDC ChatDoc AI</title>
        <link rel="apple-touch-icon" href="{{ asset('app-assets/images/tedc.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('app-assets/images/tedc.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    </head>
    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
        <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
            <div class="navbar-container d-flex content">
                <ul class="nav navbar-nav align-items-center ms-auto">
                    <li class="nav-item dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name fw-bolder">{{ Auth::user()->name }}</span>
                                <span class="user-status">Online</span>
                            </div>
                            <span class="avatar">
                                <img class="round" src="{{ !empty(Auth::user()->foto) ? asset('foto/'.Auth::user()->foto) : asset('app-assets/images/portrait/small/avatar-s-11.jpg') }}" alt="avatar" height="40" width="40">
                                <span class="avatar-status-online"></span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                            <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="me-50" data-feather="user"></i> Profile</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="me-50" data-feather='log-out'></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- BEGIN: Main Menu-->
        <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item me-auto">
                        <a class="navbar-brand" href="/">
                            <span class="brand-logo">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSj2Nx53dKP_qwIN7bC4gGN3p4J1SfnChpfsw&s" alt=""></span>
                                <h2 class="brand-text mb-0" style="color: hsl(240 5.9% 10%);font-size: 15px;margin-left: -8px;margin-top: 1px;">TEDC ChatDoc AI</h2>
                            </a>
                    </li>
                    <li class="nav-item nav-toggle">
                        <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                            <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                            <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="nav-item {!!(Request::is('/')) ? ' active' : '' !!}">
                        <a class="d-flex align-items-center" href="/">
                            <i data-feather="square"></i>
                            <span class="menu-title text-truncate" data-i18n="Modal Examples">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {!!(Request::is('document')) ? ' active' : '' !!}">
                        <a class="d-flex align-items-center" href="{{ route('document.index') }}">
                            <i data-feather="file"></i>
                            <span class="menu-title text-truncate" data-i18n="Modal Examples">Dokumen</span>
                        </a>
                    </li>
                    <li class="nav-item {!!(Request::is('users')) ? ' active' : '' !!}">
                        <a class="d-flex align-items-center" href="{{ route('users.index') }}">
                            <i data-feather="users"></i>
                            <span class="menu-title text-truncate" data-i18n="Modal Examples">User</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item {!!(Request::is('history')) ? ' active' : '' !!}">
                        <a class="d-flex align-items-center" href="{{ route('users.index') }}">
                            <i data-feather='clock'></i>
                            <span class="menu-title text-truncate" data-i18n="Modal Examples">History</span>
                        </a>
                    </li> --}}
                    {{-- <li class=" nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="user"></i>
                            <span class="menu-title text-truncate" data-i18n="User">Master Data</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a class="d-flex align-items-center" href="app-user-list.html">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="List">List</span>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i data-feather="log-out"></i>
                            <span class="menu-title text-truncate" data-i18n="Modal Examples">Logout</span>
                        </a>
                    </li> --}}
                    {{-- <li class=" nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="user"></i>
                            <span class="menu-title text-truncate" data-i18n="User">Master Data</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a class="d-flex align-items-center" href="app-user-list.html">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="List">List</span>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
        </div> @yield('content') <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        <footer class="footer footer-static footer-light">
            <p class="clearfix mb-0">
                <span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; {{date('Y')}} By TEDC ChatDoc AI</span>
            </p>
        </footer>
        <button class="btn btn-primary btn-icon scroll-top" type="button">
            <i data-feather="arrow-up"></i>
        </button>
        <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
        <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
        <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        @include('sweetalert::alert')
        @stack('scripts')

        <script>
            $('.select2').select2({
                // theme: "bootstrap"
            });

            $(document).ready(function () {
                $('#basic-datatables').DataTable();
            });
        </script>
        <script>
            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            })
        </script>
    </body>
    <!-- END: Body-->
</html>
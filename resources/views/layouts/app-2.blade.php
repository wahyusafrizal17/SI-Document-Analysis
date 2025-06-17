
<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="TEDC ChatDoc AI">
    <meta name="keywords" content="Tedc, Chat Document, AI">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TEDC ChatDoc AI</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/tedc.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('app-assets/images/tedc.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="" style="background: #3a3a3a;">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content" style="background: #1E1E1E;">
            <div class="bookmark-wrapper d-flex align-items-center">
                <h2 style="font-size: 20px;font-weight: bold;margin-bottom: 5px;color: white;">AI CHAT</h2>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">{{ Auth::user()->name ?? '-' }}</span><span class="user-status">{{ Auth::user()->email ?? '-' }}</span></div><span class="avatar"><img class="round" src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="me-50" data-feather="power"></i> Login
                        </a>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="me-50" data-feather="user"></i> Profile
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="me-50" data-feather="power"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="">
                    <img src="{{ asset('app-assets/images/tedc.png') }}" alt="" style="width: 40px;">
                        <h2 class="brand-text" style="font-size: 30px;margin-top: 3px;color: white;">TEDC</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" navigation-header"><span>History</span></li>
                @if($histori->isEmpty())
                <li class=" nav-item"><a class="d-flex align-items-center" href="javascript:void(0)"><span class="menu-title text-truncate" data-i18n="Email">Belum ada pencarian</span></a></li>
                @else
                    @foreach($histori as $row)
                    <li class="nav-item {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? 'active' : '' }}"><a class="d-flex align-items-center" href="javascript:void(0)"><span class="menu-title text-truncate" data-i18n="Email">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</span></a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    @yield('content') 

    <!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-center">
          <h2 class="modal-title" id="loginModalLabel">Login</h2>
        </div>
        <form method="POST" action="{{ route('login') }}">
          @csrf
        <div class="modal-body">
          <div class="mb-1">
              <label class="form-label" for="login-email">Email</label>
              <input id="login-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="mb-1">
              <div class="d-flex justify-content-between">
                  <label class="form-label" for="login-password">Password</label>
              </div>
              <div class="input-group input-group-merge form-password-toggle">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
          </div>
          <div class="mb-1" align="right">
              <label class="form-check-label" for="remember-me"> Belum punya akun? <a href="javascript:void(0)" onclick="showRegister()">Daftar</a></label>
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
      </div>
    </div>
  </div> 

      <!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-center">
            <h2 class="modal-title" id="loginModalLabel">Register</h2>
          </div>
        <form method="POST" action="{{ route('register') }}">
          @csrf
        <div class="modal-body">
          <input type="hidden" name="role" value="Pengguna">
            <div class="mb-1">
                <label class="form-label" for="login-name">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-1">
                <label class="form-label" for="login-email">Email</label>
                <input id="login-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-1">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="login-password">Password</label>
                </div>
                <div class="input-group input-group-merge form-password-toggle">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                </div>
            </div>
            <div class="mb-1">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="login-password-confirm">Confirm Password</label>
                </div>
                <div class="input-group input-group-merge form-password-toggle">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                </div>
            </div>
          <div class="mb-1" align="right">
              <label class="form-check-label" for="remember-me"> Sudah punya akun? <a href="javascript:void(0)" onclick="showLogin()">Login</a></label>
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
      </div>
    </div>
  </div> 

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0">
            <span class="float-md-end d-none d-md-block">Politeknik TEDC @ {{date('Y')}}</span>
        </p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


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
        scrollToBottom();
        function scrollToBottom() {
            var contentChat = document.querySelector('.content-chat');
            if (contentChat) {
                contentChat.scrollTo({
                    top: contentChat.scrollHeight,
                    behavior: 'smooth' // Enable smooth scrolling
                });
            }
        }
    </script>
</body>
<!-- END: Body-->
</html>
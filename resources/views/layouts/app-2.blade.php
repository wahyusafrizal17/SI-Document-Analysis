
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
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl" style="backdrop-filter: blur(12px); background: rgba(30,30,30,0.85); border-radius: 0 0 2rem 2rem; box-shadow: 0 4px 24px 0 rgba(31,38,135,0.15);">
        <div class="navbar-container d-flex content" style="background: transparent;">
            <div class="bookmark-wrapper d-flex align-items-center">
                <h2 style="font-size: 22px;font-weight: bold;margin-bottom: 5px;color: white;letter-spacing: 1px;">AI CHAT</h2>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none text-end">
                            <span class="user-name fw-bolder" style="color: #fff;">{{ Auth::user()->name ?? '-' }}</span>
                            <span class="user-status" style="color: #bbb;">{{ Auth::user()->email ?? '-' }}</span>
                        </div>
                        <span class="avatar" style="box-shadow: 0 2px 12px 0 rgba(106,130,251,0.18); border: 2px solid #fff;">
                            <img class="round" src="{{ !empty(Auth::user()->foto) ? asset('foto/'.Auth::user()->foto) : asset('app-assets/images/portrait/small/avatar-s-11.jpg') }}" alt="avatar" height="44" width="44" style="object-fit: cover; border-radius: 50%;">
                            {{-- <span class="avatar-status-online"></span> --}}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        @if(Auth::check())
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="me-50" data-feather="user"></i> Profile
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="me-50" data-feather="power"></i> Logout
                        </a>
                        @else
                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="me-50" data-feather="power"></i> Login
                        </a>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true" style="background: rgba(34,34,50); backdrop-filter: blur(12px); border-right: 1px solid rgba(255,255,255,0.18);">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="/" style="display: flex; align-items: center; gap: 0.5rem;">
                        <img src="{{ asset('app-assets/images/tedc.png') }}" alt="AI Logo" style="width: 40px; filter: drop-shadow(0 0 8px #fff8);">
                        <h2 class="brand-text" style="font-size: 28px; margin: 0; color: white; font-weight: 700; text-shadow: 0 2px 8px #0006;">TEDC</h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse" style="color: #fff;margin-top: 29px;">
                        <i class="d-block d-xl-none toggle-icon font-medium-4" data-feather="x"></i>
                        <i class="d-none d-xl-block collapse-toggle-icon font-medium-4" data-feather="disc" data-ticon="disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom" style="background: linear-gradient(180deg, rgba(106,130,251,0.1) 0%, transparent 100%); height: 2px;"></div>
        <div class="main-menu-content" style="padding: 1rem 0;">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="navigation-header" style="padding: 1rem 1.5rem 0.5rem; margin-top: 1rem;">
                    <span style="color: #fff; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1; opacity: 0.8;">
                        <i data-feather="clock" style="width: 14px; height: 14px; margin-right: 8px;"></i>Chat History
                    </span>
                </li>
                @if(empty($histori))
                    <li class="nav-item">
                        <div class="menu-item-empty" style="margin: 0.5rem 1rem; padding: 1.5rem; border-radius: 1; background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2); text-align: center;">
                            <i data-feather="inbox" style="width: 32px; height: 32px; margin-bottom: 0.5rem; opacity: 0.4; color: #bbb;"></i>
                            <p style="color: #bbb; margin: 0; font-size: 0.875;">No chat history yet</p>
                            <small style="color: #999; font-size: 0.75rem;">Start chatting to see your history here</small>
                        </div>
                    </li>
                @else
                    @foreach($histori as $row)
                        <li class="nav-item history-nav-item {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? 'active' : '' }}" data-tanggal="{{ $row->tanggal }}">
                            <div class="history-card" onclick="showHistory('{{$row->tanggal}}', this)" 
                                 style="margin: 0.5rem 1rem; padding: 1rem; border-radius: 1em; background: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? 'linear-gradient(135deg, #6a82fb 0%, #fc5c7d 100%)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? 'rgba(255,255,255,0.3)' : 'rgba(255,255,255,0.1)' }}; cursor: pointer; transition: all 0.3s cubic-bezier(.4,2,.3,1); position: relative;">
                                
                                <!-- Active indicator -->
                                @if(\Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y'))
                                    <div style="position: absolute; top: 0; right: 0; width: 0; height: 0; border-left: 20px solid transparent; border-right: 0px solid transparent; border-top: 20px solid #fff;">
                                    </div>
                                @endif
                                
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="history-icon" style="width: 40px; height: 40px; border-radius: 50%; background: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? 'rgba(255,255,255,0.2)' : 'rgba(255,255,255,0.1)' }}; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                                        <i data-feather="calendar" style="width: 18px; height: 18px; color: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? '#fff' : '#bbb' }}; opacity: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? '1' : '0.7' }};"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="history-date" style="color: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? '#fff' : '#fff' }}; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.25rem;">
                                           {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="history-time" style="color: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? 'rgba(255,255,255,0.8)' : '#999' }}; font-size: 0.75rem;">
                                           {{ \Carbon\Carbon::parse($row->tanggal)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="history-arrow" style="opacity: 0.5; transition: all 0.3s;">
                                        <i data-feather="chevron-right" style="width: 16px; height: 16px; color: {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') == date('d-m-Y') ? '#fff' : '#bbb' }}"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
                
                <!-- Quick Actions Section -->
                {{-- <li class="navigation-header" style="padding: 2rem 1.5rem 0.5rem; margin-top: 1rem;">
                    <span style="color: #fff; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1; opacity: 0.8;">
                        <i data-feather="zap" style="width: 14px; height: 14px; margin-right: 8px;"></i>Quick Actions
                    </span>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center menu-item" href="javascript:void(0)" onclick="clearHistory()" 
                       style="margin: 0.25rem 1rem; padding: 0.75rem; border-radius: 1; background: rgba(255,255,255,0.05); color: #fff; transition: all 0.3s;">
                        <i data-feather="refresh-cw" style="width: 16px; height: 16px; margin-right: 12px; opacity: 0.6;"></i>
                        <span class="menu-title text-truncate">Clear History</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center menu-item" href="{{ route('profile.index') }}" 
                       style="margin: 0.25rem 1rem; padding: 0.75rem; border-radius: 1; background: rgba(255,255,255,0.05); color: #fff; transition: all 0.3s;">
                        <i data-feather="settings" style="width: 16px; height: 16px; margin-right: 12px; opacity: 0.6;"></i>
                        <span class="menu-title text-truncate">Settings</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    @yield('content') 

    <!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modern-auth-modal p-0" style="border-radius: 2rem; overflow: hidden; background: rgba(34,34,50,0.85); box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37); border: 1px solid rgba(255,255,255,0.18); backdrop-filter: blur(10px);">
            <div class="row g-0">
                <!-- Left Side - AI Visual -->
                <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #6a82fb 0%, #fc5c7d 100%); flex-direction: column; position: relative; padding: 10px; text-align: center;">
                    <img src='{{ asset('app-assets/images/tedc.png') }}' alt="AI Logo" style="width: 90px; margin-bottom: 1.5rem; filter: drop-shadow(0 0 16px #fff8);">
                    <h2 style="color: #fff; font-weight: 700; font-size: 2rem; text-shadow: 0 2px 16px #0006;">Welcome to TEDC ChatDoc AI</h2>
                    <div style="display: flex; gap: 1rem; padding-top: 50px;">
                        <span style="background: rgba(255,255,255,0.15); border-radius: 1rem; padding: 0.5rem 1rem; color: #fff; font-size: 1rem;">🤖 Smart AI</span>
                        <span style="background: rgba(255,255,255,0.15); border-radius: 1rem; padding: 0.5rem 1rem; color: #fff; font-size: 1rem;">📄 Document</span>
                        <span style="background: rgba(255,255,255,0.15); border-radius: 1rem; padding: 0.5rem 1rem; color: #fff; font-size: 1rem;">💬 Chat</span>
                    </div>
                </div>
                <!-- Right Side - Login Form -->
                <div class="col-lg-6 col-12 d-flex align-items-center justify-content-center" style="background: rgba(40,40,60,0.97); min-height: 480px;">
                    <div class="w-100 p-4 p-lg-5">
                        <h3 class="mb-2 text-center" style="color: #fff; font-weight: 600;">Sign In</h3>
                        <p class="mb-2 text-center" style="color: #bbb;">Masuk ke akun Anda untuk menggunakan AI ChatDoc</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-1">
                                <label class="form-label text-white-50" for="login-email"><i data-feather="mail" style="margin-right: 6px;"></i>Email</label>
                                <input id="login-email" type="email" class="form-control modern-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem; border: none;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white-50" for="login-password"><i data-feather="lock" style="margin-right: 6px;"></i>Password</label>
                                <div class="input-group">
                                    <input id="login-password" type="password" class="form-control modern-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem 0 0 1rem; border: none;">
                                    <span class="input-group-text" style="background: rgba(255,255,255,0.08); border-radius: 0 1rem 1rem 0; border: none; cursor: pointer;" onclick="togglePassword('login-password')"><i data-feather="eye"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-white-50">Belum punya akun? <a href="javascript:void(0)" onclick="showRegister()" class="text-info">Daftar</a></span>
                                <button type="submit" class="btn btn-gradient-primary px-4 py-2" style="border-radius: 1rem; font-weight: 600;">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modern-auth-modal p-0" style="border-radius: 2rem; overflow: hidden; background: rgba(34,34,50,0.85); box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37); border: 1px solid rgba(255,255,255,0.18); backdrop-filter: blur(10px);">
            <div class="row g-0">
                <!-- Left Side - AI Visual -->
                <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fc5c7d 0%, #6a82fb 100%); flex-direction: column; position: relative;">
                    <img src='{{ asset('app-assets/images/tedc.png') }}' alt="AI Logo" style="width: 90px; margin-bottom: 1.5rem; filter: drop-shadow(0 0 16px #fff8);">
                    <h2 style="color: #fff; font-weight: 700; font-size: 2rem; text-shadow: 0 2px 16px #0006;">Join TEDC ChatDoc AI</h2>
                    <p style="color: #f3f3f3; font-size: 1.1rem; margin-bottom: 2rem; text-align: center;">Daftar dan nikmati kemudahan pencarian dokumen dengan AI.</p>
                    <div style="display: flex; gap: 1rem; padding-top: 30px;">
                        <span style="background: rgba(255,255,255,0.15); border-radius: 1rem; padding: 0.5rem 1rem; color: #fff; font-size: 1rem;">🚀 Cepat</span>
                        <span style="background: rgba(255,255,255,0.15); border-radius: 1rem; padding: 0.5rem 1rem; color: #fff; font-size: 1rem;">🔒 Aman</span>
                        <span style="background: rgba(255,255,255,0.15); border-radius: 1rem; padding: 0.5rem 1rem; color: #fff; font-size: 1rem;">⚡ Mudah</span>
                    </div>
                </div>
                <!-- Right Side - Register Form -->
                <div class="col-lg-6 col-12 d-flex align-items-center justify-content-center" style="background: rgba(40,40,60,0.97); min-height: 520px;">
                    <div class="w-100 p-4 p-lg-5">
                        <h3 class="mb-2 text-center" style="color: #fff; font-weight: 600;">Register</h3>
                        <p class="mb-4 text-center" style="color: #bbb;">Buat akun baru untuk mulai menggunakan AI ChatDoc</p>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="role" value="Pengguna">
                            <div class="mb-1">
                                <label class="form-label text-white-50" for="register-name"><i data-feather="user" style="margin-right: 6px;"></i>Nama Lengkap</label>
                                <input id="register-name" type="text" class="form-control modern-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem; border: none;">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label class="form-label text-white-50" for="register-email"><i data-feather="mail" style="margin-right: 6px;"></i>Email</label>
                                <input id="register-email" type="email" class="form-control modern-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem; border: none;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label class="form-label text-white-50" for="register-password"><i data-feather="lock" style="margin-right: 6px;"></i>Password</label>
                                <div class="input-group">
                                    <input id="register-password" type="password" class="form-control modern-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem 0 0 1rem; border: none;">
                                    <span class="input-group-text" style="background: rgba(255,255,255,0.08); border-radius: 0 1rem 1rem 0; border: none; cursor: pointer;" onclick="togglePassword('register-password')"><i data-feather="eye"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white-50" for="register-password-confirm"><i data-feather="lock" style="margin-right: 6px;"></i>Konfirmasi Password</label>
                                <div class="input-group">
                                    <input id="register-password-confirm" type="password" class="form-control modern-input" name="password_confirmation" required autocomplete="new-password" style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem 0 0 1rem; border: none;">
                                    <span class="input-group-text" style="background: rgba(255,255,255,0.08); border-radius: 0 1rem 1rem 0; border: none; cursor: pointer;" onclick="togglePassword('register-password-confirm')"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-white-50">Sudah punya akun? <a href="javascript:void(0)" onclick="showLogin()" class="text-info">Login</a></span>
                                <button type="submit" class="btn btn-gradient-primary px-4 py-2" style="border-radius: 1rem; font-weight: 600;">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Modern Modal & Navbar -->
<style>
.btn-gradient-primary {
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: #fff;
    border: none;
    transition: box-shadow 0.2s;
    box-shadow: 0 2px 8px 0 rgba(252,92,125,0.15);
}
.btn-gradient-primary:hover, .btn-gradient-primary:focus {
    background: linear-gradient(90deg, #fc5c7d 0%, #6a82fb 100%);
    color: #fff;
    box-shadow: 0 4px 16px 0 rgba(106,130,251,0.18);
}
.modern-input:focus {
    background: rgba(255,255,255,0.12) !important;
    color: #fff !important;
    box-shadow: 0 0.2rem 0.5rem rgba(16,16,32,0.25) !important;
    border: none !important;
}
.modern-input::placeholder {
    color: rgba(255,255,255,0.5) !important;
}
.header-navbar {
    transition: background 0.3s, box-shadow 0.3s;
}
.avatar {
    box-shadow: 0 2px 12px 0 rgba(106,130,251,0.18);
    border: 2px solid #fff;
    border-radius: 50%;
    overflow: hidden;
}

/* Modern Menu Styles */
.main-menu {
    transition: all 0.3s ease;
}
.menu-item {
    transition: all 0.3s cubic-bezier(.4,2,.3,1);
    cursor: pointer;
}
.menu-item:hover, .nav-item.active .menu-item {
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%) !important;
    color: #fff !important;
    transform: translateX(4px);
    box-shadow: 0 2px 8px 0 rgba(106,130,251,0.10);
}
.menu-item i {
    transition: all 0.3s;
}
.menu-item:hover i, .nav-item.active .menu-item i {
    opacity: 1 !important;
    transform: scale(1.1);
}
.navigation-header {
    border-bottom: 1px solid rgba(255,255,255,0.08);
    margin-bottom: 0.5rem;
}
.navbar-brand:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}
.navbar-brand {
    display: flex !important;
    align-items: center;
    gap: 0.75rem;
    padding: 0;
    margin: 0;
    text-decoration: none;
}
.navbar-brand img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin: 0;
    display: block;
}
.brand-text {
    font-size: 28px;
    color: #fff;
    font-weight: 700;
    margin: 0;
    line-height: 1;
    letter-spacing: 1px;
    text-shadow: 0 2px 8px #0006;
}

/* History Card Styles */
.history-card {
    transition: all 0.3s cubic-bezier(.4,2,.3,1);
    cursor: pointer;
}
.history-card:hover {
    transform: translateX(4px) scale(1.02);
    box-shadow: 0 16px 0 rgba(106,130,251,0.15);
    background: linear-gradient(135deg, #6a82fb 0%, #fc5c7d 100%) !important;
    border-color: rgba(255,255,255,0.4) !important;
}
.history-card:hover .history-icon {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}
.history-card:hover .history-arrow {
    opacity: 1;
    transform: translateX(4px);
}
.history-icon {
    transition: all 0.3s cubic-bezier(.4,2,.3,1);
}
.history-arrow {
    transition: all 0.3s cubic-bezier(.4,2,.3,1);
}
.menu-item-empty {
    transition: all 0.3s ease;
}
.menu-item-empty:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,255,255,0.3);
}
</style>
<script>
function togglePassword(id) {
    var input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

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
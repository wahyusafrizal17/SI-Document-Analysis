
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
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/authentication.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/style.css') }}">

</head>

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="background-image: url('https://cdn.pixabay.com/photo/2023/12/27/04/32/background-8471342_1280.jpg');background-size: cover;">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5" style="margin-left: -100px;"><img class="img-fluid" src="https://cdni.iconscout.com/illustration/premium/thumb/user-login-illustration-download-in-svg-png-gif-file-formats--password-profile-account-man-lifestyle-pack-business-illustrations-5857345.png?f=webp" alt="Login V2"></div>
                        </div>
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <div class="text-center mb-2">
                                    <img src="{{ asset('app-assets/images/tedc.png') }}" alt="" width="50%">
                                </div>
                                <div class="text-center">
                                    <div style="position:absolute;right: 207px;background-color:#FFD700;width: 149px;height: 37px;transform: rotate(1.73deg);border-radius:10px;z-index: 1;margin-top: -3px;" class="landing-header-pdf-highlight" aria-hidden="true"></div>
                                    <h2 class="card-title fw-bold mb-1" style="position: relative;z-index: 2;">TEDC ChatDoc AI</h2>
                                </div>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
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
                                        <div class="form-check">
                                            <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between gap-2">
                                        <button type="submit" class="btn btn-primary w-50" tabindex="4"><i data-feather='log-in'></i> Sign in</button>
                                        <a href="{{ route('register') }}" class="btn btn-primary w-50 bg-chat-doc" tabindex="4"><i data-feather='user-plus'></i> Daftar</a>
                                    </div>                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/auth-login.js') }}"></script>

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

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="My Daily Shop">
    <meta name="keywords" content="login, auth, entry">
    <meta name="author" content="My Daily Shop Login">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - My Daily Shop</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="{{ asset('admin/assets/img/logo.png') }}" alt="img">
                        </div>
                        <form action="{{ route('admin.login.action') }}" method="post">
                            @csrf

                            <div class="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Please login to your account</h4>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                {{-- <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div> --}}

                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="text" name="email" placeholder="Enter your email address">
                                    <img src="{{ asset('admin/assets/img/icons/mail.svg') }}" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input name="password" type="password" class="pass-input" placeholder="Enter your password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <div class="alreadyuser">
                                    <h4><a href="#" class="hover-a">Forgot Password?</a></h4>
                                </div>
                            </div>
                            <div class="form-login">
                                <button class="btn btn-login" type="submit">Sign In</button>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
                <div class="login-img">
                    <img src="{{ asset('admin/assets/img/login.jpg') }}" alt="img">
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
</body>

</html>

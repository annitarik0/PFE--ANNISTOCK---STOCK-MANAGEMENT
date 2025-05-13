<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} - {{ __('messages.app_name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/iofrm-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/iofrm-theme2.css')}}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .form-body {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
            min-height: 100vh;
            background-attachment: fixed !important;
            overflow: visible;
            padding-bottom: 50px;
        }

        body::after {
            content: "";
            display: block;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
            z-index: -1;
        }

        /* Input field styling */
        input.form-control,
        input[type="email"],
        input[type="password"] {
            border: 1px solid #4b6cb7 !important;
            transition: all 0.3s ease !important;
        }

        input.form-control:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #182848 !important;
            box-shadow: 0 0 0 0.2rem rgba(75, 108, 183, 0.25) !important;
        }

        /* Button styling */
        .ibtn,
        button[type="submit"] {
            background-color: #4b6cb7 !important;
            border-color: #4b6cb7 !important;
            color: white !important;
        }

        .ibtn:hover,
        button[type="submit"]:hover {
            background-color: #3a5aa0 !important;
            border-color: #3a5aa0 !important;
        }

        /* Link styling */
        .form-button a {
            color: white !important;
        }

        .form-button a:hover {
            color: white !important;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-body">

        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                    <div class="annistock">
                        <img src="{{asset('backend/assets/images/img2.jpg.png')}}"  class="annistock">
                        </div>


                        <h3>{{ __('messages.login_title') }}</h3>
                        <p>{{ __('messages.login_subtitle') }}</p>

                        <div class="page-links">
                            <a href="{{route('login')}}" class="active">{{ __('messages.login') }}</a><a href="{{route('register')}}">{{ __('messages.register') }}</a>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="padding-left: 20px; margin-bottom: 0;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <input class="form-control" type="email" id="email" name="email" placeholder="{{ __('messages.email') }}" required value="{{ old('email') }}" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input class="form-control" type="password" id="password" name="password" placeholder="{{ __('messages.password') }}" required style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">{{ __('messages.login') }}</button> <a href="{{ route('password.request') }}" style="color: white !important; text-decoration: none;">{{ __('messages.forgot_password') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('backend/assets/js/popper.min.js')}}"></script>
<script src="{{asset('backend/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/main.js')}}"></script>
</body>
</html>




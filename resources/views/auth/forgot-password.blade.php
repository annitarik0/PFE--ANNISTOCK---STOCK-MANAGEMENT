<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password Page</title>
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
                        <h3>Password Reset</h3>
                        <p>To reset your password, enter the email address you use to sign in to AnniStock</p>
                        <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                            <input class="form-control" type="email" id="email" name="email" placeholder="E-mail Address" required style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                            <div class="form-button full-width">
                                <button
                                id="submit"
                                type="submit"
                                class="form-control ibtn">Send Reset Link
                            </button>
                            <a type="submit" href="{{ route('login') }}" style="color: white !important; text-decoration: none;">Return To Login Page</a>
                            </div>
                        </form>
                    </div>

                    <!-- Only show this section when status is set -->
                    @if (session('status'))
                    <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Password link sent</h3>
                        <p>Please check your inbox </p>
                        <div class="info-holder">
                            <span>Unsure if that email address was correct?</span> <a href="#">We can help</a>.
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('backend/assets/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('backend/assets/js/popper.min.js')}}"></script>
<script src="{{asset('backend/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/main.js')}}"></script>
</body>
</html>


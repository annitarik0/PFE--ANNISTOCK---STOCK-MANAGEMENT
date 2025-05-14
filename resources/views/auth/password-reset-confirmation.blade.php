<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Email Sent</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-body {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .form-body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiPjwvcmVjdD4KPC9zdmc+');
            opacity: 0.5;
            z-index: 0;
        }

        .reset-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            margin: 20px;
            position: relative;
            z-index: 1;
        }

        .card-header {
            background-color: rgba(75, 108, 183, 0.4);
            color: white;
            padding: 15px 20px;
            text-align: center;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            height: 130px;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(75, 108, 183, 0.6) 0%, rgba(24, 40, 72, 0.6) 100%);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 1;
            animation: subtle-shift 8s ease-in-out infinite alternate;
        }

        @keyframes subtle-shift {
            0% {
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                background-position: 0% 0%;
            }
            100% {
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                background-position: 100% 100%;
            }
        }

        .header-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMSI+PC9yZWN0Pgo8L3N2Zz4=');
            opacity: 0.7;
            mix-blend-mode: overlay;
        }

        .logo-container {
            margin: 0;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            padding: 5px;
            margin-top: 10px;
        }

        .logo-container img {
            height: auto;
            width: auto;
            max-width: 95%;
            max-height: 130%;
            object-fit: contain;
            margin: 0 auto;
            display: block;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            transform: scale(1.3);
        }

        .card-body {
            padding: 30px;
            text-align: center;
        }

        .success-icon {
            width: 70px;
            height: 70px;
            background-color: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #4CAF50;
            font-size: 30px;
        }

        .card-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .card-text {
            color: #666;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .email-highlight {
            font-weight: 600;
            color: #4b6cb7;
            background-color: #f0f4ff;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            margin: 5px 0;
        }

        .btn-return {
            background-color: #4b6cb7;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-return:hover {
            background-color: #3a5aa0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
            text-decoration: none;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .help-text {
            color: #888;
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .reset-card {
                margin: 15px;
            }

            .card-body {
                padding: 20px;
            }

            .success-icon {
                width: 60px;
                height: 60px;
                font-size: 25px;
            }

            .card-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-body">
        <div class="reset-card">
            <div class="card-header">
                <div class="header-overlay"></div>
                <div class="logo-container">
                    <img src="{{asset('backend/assets/images/img2.jpg.png')}}" alt="AnniStock Logo">
                </div>
            </div>

            <div class="card-body">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>

                <h2 class="card-title">Password Reset Email Sent</h2>

                <p class="card-text">
                    We've sent a password reset link to:
                </p>

                <div class="email-highlight">
                    {{ $email }}
                </div>

                <p class="card-text">
                    Please check your inbox and follow the instructions to reset your password.
                </p>

                <a href="{{ route('login') }}" class="btn-return">
                    Return to Login
                </a>
            </div>

            <div class="card-footer">
                <p class="help-text">
                    If you don't see the email, please check your spam folder or contact support.
                </p>
            </div>
        </div>
    </div>

    <script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/main.js')}}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                        <h3>Get more things done with AnniStock.</h3>
                        <p>Access to the most powerfull tool in the entire inventory and stock management.</p>
                        <div style="background-color: #f5f7fa; border: 1px solid #e1e5eb; border-left: 4px solid #4285f4; padding: 16px; margin-bottom: 25px; border-radius: 4px;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-user-shield" style="color: #4285f4; margin-right: 12px; font-size: 16px;"></i>
                                <div>
                                    <div style="font-size: 15px; color: #3c4043; font-weight: 500; margin-bottom: 2px;">
                                        You are registering as an <strong style="color: #4285f4;">EMPLOYEE</strong>
                                    </div>
                                    <div style="font-size: 13px; color: #5f6368;">
                                        Admin approval may be required for full system access
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger" style="font-size: 14px; padding: 10px; border-radius: 5px; background-color: #f8d7da; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                            <ul style="margin-bottom: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="page-links">
                        <a href="{{route('login')}}">Login</a><a href="{{route('register')}}" class="active">Register</a>
                        </div>
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                            <div class="form-group">
                                <input class="form-control" type="text" id="name" name="name" placeholder="Full Name" required value="{{ old('name') }}" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="E-mail Address" required value="{{ old('email') }}" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                            </div>

                            <a href="{{ route('login') }}" style="color: white !important; text-decoration: none;">
                                 {{ __('Already registered?') }}
                            </a>

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn" style="background-color: #4b6cb7 !important; border-color: #4b6cb7 !important; color: white !important;">Register</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Real-time password validation
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const registerForm = document.getElementById('registerForm');

        // Add event listener for real-time validation
        if (confirmPassword && password) {
            confirmPassword.addEventListener('input', function() {
                validatePasswords();
            });

            password.addEventListener('input', function() {
                if (confirmPassword.value) {
                    validatePasswords();
                }
            });
        }

        function validatePasswords() {
            // Find the parent form-group
            const formGroup = confirmPassword.closest('.form-group');

            // Remove any existing error message
            const existingError = formGroup.querySelector('.password-match-error');
            if (existingError) {
                existingError.remove();
            }

            // Create new error message
            const errorSpan = document.createElement('span');
            errorSpan.className = 'text-danger password-match-error';
            formGroup.appendChild(errorSpan);

            if (password.value !== confirmPassword.value) {
                errorSpan.textContent = 'Passwords do not match';
                confirmPassword.style.borderColor = 'red';
                return false;
            } else {
                errorSpan.textContent = 'Passwords match';
                errorSpan.className = 'text-success password-match-error';
                confirmPassword.style.borderColor = 'green';
                return true;
            }
        }

        // Form submission validation
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('The password confirmation does not match.');
                    confirmPassword.focus();
                    return false;
                }

                // Enhanced password validation
                const passwordValue = password.value;
                if (passwordValue.length < 10) {
                    e.preventDefault();
                    alert('Password must be at least 10 characters long.');
                    password.focus();
                    return false;
                }

                // Check for uppercase, lowercase, number, and special character
                const hasUpperCase = /[A-Z]/.test(passwordValue);
                const hasLowerCase = /[a-z]/.test(passwordValue);
                const hasNumbers = /\d/.test(passwordValue);
                const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(passwordValue);

                if (!hasUpperCase || !hasLowerCase || !hasNumbers || !hasSpecialChar) {
                    e.preventDefault();
                    alert('Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.');
                    password.focus();
                    return false;
                }

                return true;
            });
        }
    });
</script>
</body>
</html>





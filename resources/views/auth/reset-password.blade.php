<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - AnniStock</title>
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
            background-color: rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            color: white !important;
        }

        input.form-control:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #182848 !important;
            box-shadow: 0 0 0 0.2rem rgba(75, 108, 183, 0.25) !important;
        }

        input.form-control::placeholder,
        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
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

        /* Error message styling */
        .text-danger {
            color: #ff6b6b !important;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .error {
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        /* Password match indicator */
        .password-match-container {
            display: none; /* Initially hidden */
            align-items: center;
            margin: 10px 0 15px;
            padding: 8px 12px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .password-match-container.match {
            background-color: rgba(76, 175, 80, 0.2);
            border-left: 3px solid #4CAF50;
        }

        .password-match-container.mismatch {
            background-color: rgba(244, 67, 54, 0.2);
            border-left: 3px solid #F44336;
        }

        .password-match-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 10px;
            font-family: 'FontAwesome';
            font-size: 16px;
        }

        .password-match-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Make sure FontAwesome icons are visible */
        .password-match-container.match .password-match-icon {
            color: #4CAF50;
        }

        .password-match-container.mismatch .password-match-icon {
            color: #F44336;
        }

        /* Form button styling to match login page */
        .form-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
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
                            <img src="{{asset('backend/assets/images/img2.jpg.png')}}" class="annistock">
                        </div>

                        <h3>Get back to your account securely.</h3>
                        <p>Create a new password to access the most powerful tool in inventory management.</p>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <input class="form-control" type="email" id="email" name="email"
                                   value="{{ old('email', $request->email) }}" required autofocus
                                   placeholder="Email Address" autocomplete="username" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Password -->
                            <input class="form-control" type="password" id="password" name="password"
                                   required placeholder="New Password" autocomplete="new-password" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Confirm Password -->
                            <input class="form-control" type="password" id="password_confirmation"
                                   name="password_confirmation" required placeholder="Confirm New Password"
                                   autocomplete="new-password" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">

                            <!-- Password match indicator -->
                            <div id="password-match-container" class="password-match-container">
                                <span id="password-match-icon" class="password-match-icon"></span>
                                <span id="password-match-text" class="password-match-text"></span>
                            </div>

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Update Password</button>
                                <a href="{{ route('login') }}" style="color: white !important; text-decoration: none;">Back to login</a>
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
            const resetForm = document.querySelector('form[action="{{ route('password.store') }}"]');
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    const password = document.getElementById('password');
                    const confirmPassword = document.getElementById('password_confirmation');

                    if (password.value !== confirmPassword.value) {
                        e.preventDefault();
                        alert('The password confirmation does not match.');
                        confirmPassword.focus();
                        return false;
                    }
                });
            }

            // Real-time password validation
            const password = document.querySelector('input[name="password"]');
            const confirmPassword = document.querySelector('input[name="password_confirmation"]');

            // Initialize the password match container
            const container = document.getElementById('password-match-container');
            if (container) {
                container.style.display = 'none';
            }

            // Add event listener for real-time validation
            if (confirmPassword) {
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
                const container = document.getElementById('password-match-container');
                const icon = document.getElementById('password-match-icon');
                const text = document.getElementById('password-match-text');

                // Only show if both password fields have values
                if (password.value && confirmPassword.value) {
                    container.style.display = 'flex';

                    if (password.value !== confirmPassword.value) {
                        // Passwords don't match
                        container.className = 'password-match-container mismatch';
                        icon.innerHTML = '&#xf00d;'; // X icon
                        text.textContent = 'Passwords do not match';
                        confirmPassword.style.borderColor = '#F44336';
                        return false;
                    } else {
                        // Passwords match
                        container.className = 'password-match-container match';
                        icon.innerHTML = '&#xf00c;'; // Check icon
                        text.textContent = 'Passwords match';
                        confirmPassword.style.borderColor = '#4CAF50';
                        return true;
                    }
                } else {
                    // Hide if either field is empty
                    container.style.display = 'none';
                    confirmPassword.style.borderColor = '#4b6cb7';
                    return false;
                }
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/iofrm-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/iofrm-theme2.css')}}">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="annistock">
                            <img src="{{asset('backend/assets/images/img2.jpg.png')}}" class="annistock">
                        </div>
                        <h3>Reset Your Password</h3>
                        <p>Enter your new password below to complete the reset process</p>
                        
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <input class="form-control" type="email" id="email" name="email" 
                                   value="{{ old('email', $request->email) }}" required autofocus 
                                   placeholder="Email Address" autocomplete="username">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Password -->
                            <input class="form-control" type="password" id="password" name="password" 
                                   required placeholder="New Password" autocomplete="new-password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Confirm Password -->
                            <input class="form-control" type="password" id="password_confirmation" 
                                   name="password_confirmation" required placeholder="Confirm New Password" 
                                   autocomplete="new-password">

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Reset Password</button>
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
                const errorSpan = document.getElementById('password-match-error');
                
                // Create error span if it doesn't exist
                if (!errorSpan && confirmPassword.parentNode) {
                    const span = document.createElement('span');
                    span.id = 'password-match-error';
                    span.className = 'error';
                    confirmPassword.parentNode.appendChild(span);
                }
                
                const errorElement = document.getElementById('password-match-error');
                
                if (password.value !== confirmPassword.value) {
                    errorElement.textContent = 'Passwords do not match';
                    errorElement.style.color = 'red';
                    confirmPassword.style.borderColor = 'red';
                    return false;
                } else {
                    errorElement.textContent = 'Passwords match';
                    errorElement.style.color = 'green';
                    confirmPassword.style.borderColor = 'green';
                    return true;
                }
            }
        });
    </script>
</body>
</html>


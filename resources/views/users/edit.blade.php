<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Edit User</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />

        <style>
            .users-container {
                padding: 30px 0;
            }

            .users-header {
                margin-bottom: 30px;
            }

            .users-title {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .users-title i {
                color: #4b6cb7;
                margin-right: 10px;
                font-size: 28px;
            }

            .users-subtitle {
                color: #6c757d;
                margin-bottom: 0;
            }

            .user-form-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 15px rgba(0,0,0,0.05);
                margin-bottom: 30px;
                background-color: white;
                border: 1px solid rgba(0,0,0,0.03);
                padding: 30px;
            }

            .form-title {
                text-align: center;
                margin-bottom: 30px;
                color: #333;
                font-weight: 600;
                font-size: 24px;
            }

            .btn-back {
                background-color: #4b6cb7;
                color: white;
                border-radius: 8px;
                padding: 10px 20px;
                font-size: 14px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                transition: all 0.2s ease;
            }

            .btn-back i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-back:hover {
                background-color: #3a5aa0;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
            }

            .profile-image-container {
                display: flex;
                align-items: center;
                margin-bottom: 30px;
                justify-content: center;
            }

            .image-preview {
                width: 180px;
                height: 180px;
                border-radius: 50%;
                object-fit: cover;
                border: 5px solid #f8f9fa;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .image-preview:hover {
                transform: scale(1.05);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .profile-placeholder {
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: linear-gradient(135deg, #4b6cb7, #3a5aa0);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-weight: bold;
                font-size: 70px;
                margin-right: 40px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .profile-placeholder:hover {
                transform: scale(1.05);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .image-upload {
                flex: 1;
                margin-left: 20px;
            }

            .custom-file-upload {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4b6cb7;
                color: white !important;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.3s;
                font-weight: 500;
            }

            .custom-file-upload:hover {
                background-color: #3a5aa0;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .custom-file-upload i {
                margin-right: 8px;
                color: white !important;
            }

            input[type="file"] {
                display: none;
            }

            .image-help-text {
                font-size: 13px;
                color: #6c757d;
                margin-top: 10px;
                text-align: center;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-group label {
                display: block;
                margin-bottom: 10px;
                font-weight: 600;
                color: #495057;
                font-size: 14px;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                font-size: 14px;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
            }

            .form-group input:focus,
            .form-group select:focus {
                border-color: #4b6cb7;
                box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
                outline: none;
            }

            .form-group select {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234b6cb7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 10px center;
                background-size: 16px;
            }

            .error {
                color: #f1556c;
                font-size: 13px;
                margin-top: 5px;
                display: block;
            }

            .btn-update {
                background-color: #4b6cb7;
                color: white;
                border-radius: 6px;
                padding: 12px 20px;
                font-size: 16px;
                font-weight: 600;
                display: inline-block;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                width: 100%;
                border: none;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-top: 10px;
            }

            .btn-update:hover {
                background-color: #3a5aa0;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }
        </style>

    </head>


    <body>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>
        @include('header-dash')
        <!-- Keep this notification component -->
        @include('components.notification')
        <div class="users-container">
            <div class="container">
                <div class="users-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="users-title">
                                <i class="mdi mdi-account-edit"></i> Edit User
                            </h1>
                            <p class="users-subtitle">Update user information</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('users.index') }}" class="btn-back">
                                <i class="mdi mdi-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </div>
                </div>

                @if(isset($user))
                <div class="user-form-card">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="image">
                                <i class="mdi mdi-account-circle mr-1"></i> Profile Image
                            </label>
                            <div class="profile-image-container">
                                @if($user->image)
                                    <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" class="image-preview">
                                @else
                                    <div class="profile-placeholder" id="placeholder">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="image-upload">
                                    <label for="image" class="custom-file-upload">
                                        <i class="mdi mdi-camera"></i> Choose New Image
                                    </label>
                                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <p class="image-help-text">Recommended: Square image, at least 200x200 pixels</p>
                                    @error('image') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">
                                <i class="mdi mdi-account mr-1"></i> Full Name
                            </label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="mdi mdi-email-outline mr-1"></i> Email
                            </label>
                            <input type="email" id="email" name="email" required placeholder="tarikanni@example.com" value="{{ $user->email }}">
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <i class="mdi mdi-lock-outline mr-1"></i> Password <span style="font-size: 12px; color: #6c757d;">(Leave blank to keep current password)</span>
                            </label>
                            <input type="password" id="password" name="password" placeholder="Enter new password" >
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="mdi mdi-lock-check-outline mr-1"></i> Confirm Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">
                                <i class="mdi mdi-shield-account mr-1"></i> Role
                            </label>
                            <select id="role" name="role" required>
                                <option value="employee" {{ $user->role == 'employee' || $user->role == 'user' ? 'selected' : '' }}>Employee</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn-update">
                            <i class="mdi mdi-content-save mr-1"></i> Update User
                        </button>
                    </form>
                </div>
                @else
                <div class="user-form-card">
                    <div class="alert alert-danger">
                        User not found. <a href="{{ route('users.index') }}">Return to user list</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @include('footer-dash')

        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>

        <!--Morris Chart-->
        <script src="../plugins/morris/morris.min.js')}}"></script>
        <script src="../plugins/raphael/raphael.min.js')}}"></script>

        <!-- dashboard js -->
        <script src="{{asset('admin/assets/pages/dashboard.int.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>

        @yield('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Image preview functionality
                const imageInput = document.getElementById('image');
                if (imageInput) {
                    imageInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                // If there's already an image element
                                const existingImage = document.querySelector('.image-preview');
                                if (existingImage) {
                                    existingImage.src = e.target.result;
                                    existingImage.style.display = 'block';
                                }
                                // If there's a placeholder, replace it with an image
                                else {
                                    const placeholder = document.querySelector('.profile-placeholder');
                                    if (placeholder) {
                                        const parent = placeholder.parentNode;

                                        const img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.className = 'image-preview';
                                        img.alt = 'Profile Preview';

                                        parent.replaceChild(img, placeholder);
                                    }
                                }
                            };

                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }

                // Real-time password validation
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('password_confirmation');

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

                    // If both password fields are empty, no validation needed
                    if (password.value === '' && confirmPassword.value === '') {
                        // Remove any existing error message
                        if (errorSpan) {
                            errorSpan.remove();
                        }
                        confirmPassword.style.borderColor = '';
                        return true;
                    }

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

                // Form submission validation
                const userEditForm = document.querySelector('form');
                if (userEditForm) {
                    userEditForm.addEventListener('submit', function(e) {
                        // Only validate if at least one password field has a value
                        if ((password.value || confirmPassword.value) && !validatePasswords()) {
                            e.preventDefault();
                            alert('The password confirmation does not match.');
                            confirmPassword.focus();
                            return false;
                        }

                        // If password is provided, make sure it's at least 6 characters
                        if (password.value && password.value.length < 6) {
                            e.preventDefault();
                            alert('Password must be at least 6 characters long.');
                            password.focus();
                            return false;
                        }
                    });
                }
            });
        </script>
    </body>
</html>

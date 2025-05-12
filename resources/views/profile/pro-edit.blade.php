<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - My Profile</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

        <style>
            .profile-container {
                padding: 30px 0;
            }

            .profile-header {
                margin-bottom: 30px;
            }

            .profile-title {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .profile-title i {
                color: #4b6cb7;
                margin-right: 10px;
                font-size: 28px;
            }

            .profile-subtitle {
                color: #6c757d;
                margin-bottom: 0;
            }

            .profile-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 15px rgba(0,0,0,0.08);
                margin-bottom: 30px;
                border: 1px solid rgba(0,0,0,0.03);
            }

            .profile-card .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid rgba(0,0,0,0.05);
                padding: 15px 20px;
            }

            .profile-card .card-header h5 {
                margin: 0;
                font-weight: 600;
                color: #333;
                display: flex;
                align-items: center;
            }

            .profile-card .card-header h5 i {
                margin-right: 8px;
                color: #4b6cb7;
            }

            .profile-card .card-body {
                padding: 25px;
                background-color: white;
            }

            .profile-image-section {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px;
                border-right: 1px solid #f1f1f1;
            }

            .profile-image-container {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                overflow: hidden;
                margin-bottom: 20px;
                position: relative;
                box-shadow: 0 3px 15px rgba(0,0,0,0.1);
                border: 3px solid white;
            }

            .profile-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .profile-placeholder {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
                color: white;
                font-size: 60px;
                font-weight: 600;
            }

            .image-upload-btn {
                position: absolute;
                bottom: 5px;
                right: 5px;
                background-color: #4b6cb7;
                color: white;
                border-radius: 50%;
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s ease;
                border: 2px solid white;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }

            .image-upload-btn:hover {
                background-color: #3a5aa0;
                transform: scale(1.1);
            }

            .image-upload-btn i {
                font-size: 18px;
            }

            .user-role-badge {
                background-color: #4b6cb7;
                color: white;
                border-radius: 20px;
                padding: 5px 15px;
                font-size: 14px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                margin-bottom: 15px;
            }

            .user-role-badge i {
                margin-right: 5px;
                font-size: 16px;
            }

            .user-role-badge.admin {
                background-color: #f1556c;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 10px 15px;
                font-size: 14px;
                color: #495057;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                outline: none;
                border-color: #4b6cb7;
                box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
            }

            .input-group-text {
                background-color: #f8f9fa;
                border: 1px solid #e0e0e0;
                border-radius: 0 8px 8px 0;
                color: #6c757d;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .input-group-text:hover {
                background-color: #e9ecef;
                color: #495057;
            }

            .btn-update {
                background-color: #4b6cb7;
                color: white;
                border-radius: 8px;
                padding: 10px 20px;
                font-size: 14px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                transition: all 0.2s ease;
                border: none;
                cursor: pointer;
            }

            .btn-update i {
                margin-right: 5px;
                font-size: 16px;
            }

            .btn-update:hover {
                background-color: #3a5aa0;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(75, 108, 183, 0.2);
            }

            .section-divider {
                margin: 30px 0;
                border-top: 1px solid #f1f1f1;
                padding-top: 30px;
            }

            .danger-zone {
                background-color: #fff5f5;
                border: 1px solid #ffe5e5;
                border-radius: 10px;
                padding: 20px;
            }

            .danger-zone-title {
                color: #f1556c;
                font-weight: 600;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .danger-zone-title i {
                margin-right: 8px;
                font-size: 20px;
            }

            .danger-zone-text {
                color: #6c757d;
                margin-bottom: 15px;
            }

            .btn-danger-action {
                background-color: #f1556c;
                color: white;
                border-radius: 8px;
                padding: 10px 20px;
                font-size: 14px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                transition: all 0.2s ease;
                border: none;
                cursor: pointer;
            }

            .btn-danger-action i {
                margin-right: 5px;
                font-size: 16px;
            }

            .btn-danger-action:hover {
                background-color: #e63e57;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(241, 85, 108, 0.2);
            }

            .error {
                color: #f1556c;
                font-size: 12px;
                margin-top: 5px;
                display: block;
            }

            .success-alert {
                background-color: #e6f7f0;
                border: 1px solid #d1f0e0;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 20px;
                color: #02c58d;
                display: flex;
                align-items: center;
            }

            .success-alert i {
                margin-right: 10px;
                font-size: 20px;
            }

            @media (max-width: 767.98px) {
                .profile-image-section {
                    border-right: none;
                    border-bottom: 1px solid #f1f1f1;
                    padding-bottom: 30px;
                    margin-bottom: 30px;
                }
            }
        </style>
    </head>
    <body>
        <!-- Loader -->
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

        <!-- Include notification component -->
        @include('components.notification')

        <div class="profile-container">
            <div class="container">
                <div class="profile-header">
                    <h1 class="profile-title">
                        <i class="mdi mdi-account-circle"></i> My Profile
                    </h1>
                    <p class="profile-subtitle">Manage your account information and settings</p>
                </div>

                @if(session('success'))
                    <div class="success-alert">
                        <i class="mdi mdi-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-4">
                        <div class="profile-card">
                            <div class="card-header">
                                <h5><i class="mdi mdi-account"></i> Account Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="profile-image-section">
                                    <form action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data" id="profileImageForm">
                                        @csrf

                                        <div class="profile-image-container">
                                            @if($user->image)
                                                <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" class="profile-image">
                                            @else
                                                <div class="profile-placeholder">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif

                                            <label for="image" class="image-upload-btn">
                                                <i class="mdi mdi-camera"></i>
                                            </label>

                                            <input type="file" name="image" id="image" style="display: none;" onchange="document.getElementById('profileImageForm').submit();">
                                        </div>

                                        @error('image')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </form>

                                    <div class="user-role-badge {{ $user->role === 'admin' ? 'admin' : '' }}">
                                        @if($user->role === 'admin')
                                            <i class="mdi mdi-shield-account"></i> Administrator
                                        @else
                                            <i class="mdi mdi-account"></i> Employee
                                        @endif
                                    </div>

                                    <h4 class="text-center mb-0">{{ $user->name }}</h4>
                                    <p class="text-muted text-center">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="profile-card">
                            <div class="card-header">
                                <h5><i class="mdi mdi-account-edit"></i> Edit Profile</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('patch')

                                    <div class="form-group">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn-update">
                                            <i class="mdi mdi-content-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>

                                <div class="section-divider"></div>

                                <h5 class="mb-4"><i class="mdi mdi-lock mr-2"></i> Change Password</h5>

                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="form-group">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('current_password')">
                                                    <i class="mdi mdi-eye" id="current_password_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('current_password', 'updatePassword')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('password')">
                                                    <i class="mdi mdi-eye" id="password_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('password', 'updatePassword')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                                                    <i class="mdi mdi-eye" id="password_confirmation_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn-update">
                                            <i class="mdi mdi-lock-reset"></i> Update Password
                                        </button>
                                    </div>
                                </form>

                                @if(Auth::user()->isAdmin())
                                <div class="section-divider"></div>

                                <div class="danger-zone">
                                    <h5 class="danger-zone-title">
                                        <i class="mdi mdi-alert-circle"></i> Delete Account
                                    </h5>
                                    <p class="danger-zone-text">
                                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                                    </p>

                                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                        @csrf
                                        @method('delete')

                                        <div class="form-group">
                                            <label for="delete_password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="delete_password" name="password" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" onclick="togglePassword('delete_password')">
                                                        <i class="mdi mdi-eye" id="delete_password_icon"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            @error('password', 'userDeletion')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn-danger-action">
                                            <i class="mdi mdi-delete"></i> Delete Account
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('footer-dash')

        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('admin/assets/js/app.js')}}"></script>

        <script>
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(inputId + '_icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('mdi-eye');
                    icon.classList.add('mdi-eye-off');
                } else {
                    input.type = 'password';
                    icon.classList.remove('mdi-eye-off');
                    icon.classList.add('mdi-eye');
                }
            }
        </script>
    </body>
</html>

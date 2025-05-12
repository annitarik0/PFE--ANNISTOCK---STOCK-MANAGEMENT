<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Profile</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        @include('header-dash')
        @include('components.notification')
        
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <h4 class="mt-0 header-title text-center mb-4">User Profile</h4>
                                
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                <!-- Profile Image Form -->
                                <form action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data" class="mb-5">
                                    @csrf
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Profile Image</label>
                                        <div class="col-sm-10">
                                            <div class="profile-image-container">
                                                @if(auth()->user()->image)
                                                    <div class="current-image">
                                                        <img src="{{ asset(auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="profile-image">
                                                    </div>
                                                @else
                                                    <div class="profile-placeholder">
                                                        {{ substr(auth()->user()->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                
                                                <div class="image-upload">
                                                    <label for="image" class="custom-file-upload">
                                                        <i class="mdi mdi-camera"></i> Change Image
                                                    </label>
                                                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/jpg,image/gif">
                                                    <p class="image-help-text">Recommended: Square image, at least 200x200 pixels</p>
                                                    @error('image') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            <button type="submit" class="btn btn-primary">Update Image</button>
                                        </div>
                                    </div>
                                </form>
                                
                                <!-- Profile Information Form -->
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" required placeholder="ex : John Doe" value="{{ old('name', $user->name) }}">
                                            @error('name') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email Address</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" required placeholder="john@example.com" value="{{ old('email', $user->email) }}">
                                            @error('email') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                                
                                <!-- Password Change Section -->
                                <div class="section-divider">
                                    <h4 class="mt-0 header-title mb-4">Change Password</h4>
                                    <p class="text-muted mb-4">
                                        Ensure your account is using a long, random password to stay secure.
                                    </p>
                                    
                                    <form method="post" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('put')
                                        
                                        <div class="form-group row">
                                            <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                                            <div class="col-sm-10 password-toggle">
                                                <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="Enter your current password">
                                                <span class="toggle-icon" onclick="togglePassword('current_password')">
                                                    <i class="mdi mdi-eye"></i>
                                                </span>
                                                @error('current_password', 'updatePassword') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10 password-toggle">
                                                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your new password">
                                                <span class="toggle-icon" onclick="togglePassword('password')">
                                                    <i class="mdi mdi-eye"></i>
                                                </span>
                                                @error('password', 'updatePassword') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10 password-toggle">
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm your new password">
                                                <span class="toggle-icon" onclick="togglePassword('password_confirmation')">
                                                    <i class="mdi mdi-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-success">Update Password</button>
                                                
                                                @if (session('status') === 'password-updated')
                                                    <span class="text-success ml-2">Password updated successfully!</span>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Delete Account Section -->
                                <div class="section-divider">
                                    <h4 class="mt-0 header-title mb-4">Delete Account</h4>
                                    <div class="delete-warning">
                                        Warning: This action cannot be undone. All your data will be permanently deleted.
                                    </div>
                                    
                                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                        @csrf
                                        @method('delete')
                                        
                                        <div class="form-group row">
                                            <label for="delete_password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10 password-toggle">
                                                <input type="password" class="form-control" id="delete_password" name="password" required placeholder="Enter your password to confirm">
                                                <span class="toggle-icon" onclick="togglePassword('delete_password')">
                                                    <i class="mdi mdi-eye"></i>
                                                </span>
                                                @error('password', 'userDeletion') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-danger">Delete Account</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('footer-dash')

        <!-- jQuery  -->
        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const imageInput = document.getElementById('image');
                if (imageInput) {
                    imageInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            
                            reader.onload = function(e) {
                                // If there's already an image element
                                const existingImage = document.querySelector('.profile-image');
                                if (existingImage) {
                                    existingImage.src = e.target.result;
                                } 
                                // If there's a placeholder, replace it with an image
                                else {
                                    const placeholder = document.querySelector('.profile-placeholder');
                                    if (placeholder) {
                                        const parent = placeholder.parentNode;
                                        
                                        const imageDiv = document.createElement('div');
                                        imageDiv.className = 'current-image';
                                        
                                        const img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.className = 'profile-image';
                                        img.alt = 'Profile Preview';
                                        
                                        imageDiv.appendChild(img);
                                        parent.replaceChild(imageDiv, placeholder);
                                    }
                                }
                                
                                // Show the submit button when an image is selected
                                document.querySelector('button[type="submit"]').style.display = 'inline-block';
                            };
                            
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
            });
            
            // Function to toggle password visibility
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const icon = event.currentTarget.querySelector('i');
                
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



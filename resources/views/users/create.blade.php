<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Create User</title>
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

            .btn-create {
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
                max-width: 300px;
                border: none;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-top: 10px;
                margin-left: auto;
                margin-right: auto;
            }

            .btn-create:hover {
                background-color: #3a5aa0;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }

            /* Image upload styling - Professional version with round image */
            .profile-image-container {
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 30px auto;
                flex-wrap: wrap;
                max-width: 600px;
                background-color: #f8f9fa;
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                border: 1px solid rgba(0,0,0,0.03);
                text-align: center;
            }

            .image-preview-container {
                width: 160px;
                height: 160px;
                margin-right: 30px;
                border-radius: 50%;
                overflow: hidden;
                background-color: white;
                border: 3px solid #e0e0e0;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                position: relative;
            }

            .image-preview-container:hover {
                border-color: #4b6cb7;
                transform: scale(1.03);
                box-shadow: 0 5px 15px rgba(75, 108, 183, 0.2);
                cursor: pointer;
            }

            .image-preview-container:hover::after {
                content: 'Change';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: rgba(75, 108, 183, 0.8);
                color: white;
                text-align: center;
                padding: 5px 0;
                font-size: 14px;
                font-weight: 500;
            }

            .profile-placeholder {
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #f0f2f5 0%, #e6e9f0 100%);
                color: #4b6cb7;
                transition: all 0.3s ease;
                position: relative;
            }

            .image-preview {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: none;
            }

            .image-upload {
                flex: 1;
                min-width: 250px;
                padding-left: 10px;
            }

            .custom-file-upload {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4b6cb7;
                color: white;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.3s;
                font-weight: 500;
                font-size: 14px;
                margin-bottom: 15px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .custom-file-upload:hover {
                background-color: #3a5aa0;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }

            .custom-file-upload i {
                margin-right: 8px;
            }

            input[type="file"] {
                display: none;
            }

            .image-help-text {
                font-size: 13px;
                color: #6c757d;
                margin-top: 10px;
                line-height: 1.5;
            }

            /* Password strength indicator */
            .password-strength {
                margin-top: 8px;
                height: 5px;
                border-radius: 3px;
                background-color: #e9ecef;
                overflow: hidden;
            }

            .password-strength-bar {
                height: 100%;
                width: 0;
                transition: width 0.3s, background-color 0.3s;
            }

            .password-strength-text {
                font-size: 12px;
                margin-top: 5px;
                font-weight: 500;
            }

            .password-match-indicator {
                display: flex;
                align-items: center;
                margin-top: 8px;
                font-size: 14px;
            }

            .password-match-indicator i {
                margin-right: 5px;
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
                                <i class="mdi mdi-account-plus"></i> Create New User
                            </h1>
                            <p class="users-subtitle">Add a new user to the system</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('users.index') }}" class="btn-back">
                                <i class="mdi mdi-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </div>
                </div>

                <div class="user-form-card">
                    <form action="{{ url('/users') }}" method="POST" enctype="multipart/form-data" id="user-create-form">
                        @csrf
                        <!-- Add hidden token field for extra security -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="profile-image-container">
                            <label for="image" class="image-preview-container" title="Click to change profile photo">
                                <div class="profile-placeholder" id="placeholder">
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; background-color: rgba(255, 255, 255, 0.8); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                                        <i class="mdi mdi-camera" style="font-size: 40px; color: #4b6cb7;"></i>
                                    </div>
                                </div>
                                <img id="image-preview" class="image-preview">
                            </label>
                            <div class="image-upload">
                                <h4 style="margin-top: 0; margin-bottom: 15px; color: #444; font-size: 18px;">Profile Photo</h4>
                                <label for="image" class="custom-file-upload">
                                    <i class="mdi mdi-cloud-upload"></i> Upload Image
                                </label>
                                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <p class="image-help-text">
                                    <i class="mdi mdi-information-outline" style="color: #4b6cb7; margin-right: 5px;"></i>
                                    Recommended: Square image in JPG, PNG format<br>
                                    Minimum size: 200x200 pixels
                                </p>
                                @error('image') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="mdi mdi-account mr-1"></i> Full Name
                                    </label>
                                    <input type="text" id="name" name="name" required placeholder="Enter full name">
                                    @error('name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">
                                        <i class="mdi mdi-email-outline mr-1"></i> Email Address
                                    </label>
                                    <input type="email" id="email" name="email" required placeholder="Enter email address">
                                    @error('email') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role">
                                <i class="mdi mdi-shield-account mr-1"></i> User Role
                            </label>
                            <select id="role" name="role" required>
                                <option value="employee">Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">
                                        <i class="mdi mdi-lock-outline mr-1"></i> Password
                                    </label>
                                    <input type="password" id="password" name="password" required placeholder="Enter password">
                                    <div class="password-strength">
                                        <div class="password-strength-bar" id="password-strength-bar"></div>
                                    </div>
                                    <div class="password-strength-text" id="password-strength-text"></div>
                                    @error('password') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">
                                        <i class="mdi mdi-lock-check-outline mr-1"></i> Confirm Password
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                                    <div class="password-match-indicator" id="password-match-indicator"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-create" id="submit-btn">
                                <i class="mdi mdi-account-plus mr-1"></i> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('footer-dash')

        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>

        <!-- Add JavaScript for form validation and AJAX submission -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced image preview functionality
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        const file = this.files[0];

                        reader.onload = function(e) {
                            const placeholder = document.getElementById('placeholder');
                            const imagePreview = document.getElementById('image-preview');
                            const previewContainer = document.querySelector('.image-preview-container');

                            if (placeholder) {
                                placeholder.style.opacity = '0';
                                placeholder.style.visibility = 'hidden';
                                placeholder.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
                            }

                            // Apply a smooth transition effect
                            imagePreview.style.opacity = '0';
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';

                            // Add a subtle border to the container when an image is selected
                            previewContainer.style.borderColor = '#5985ee';
                            previewContainer.style.borderWidth = '3px';

                            // Add a pulsing animation to highlight the new image
                            previewContainer.style.animation = 'pulse 1.5s';

                            // Add the animation keyframes if they don't exist
                            if (!document.getElementById('pulse-animation')) {
                                const style = document.createElement('style');
                                style.id = 'pulse-animation';
                                style.textContent = `
                                    @keyframes pulse {
                                        0% { box-shadow: 0 0 0 0 rgba(89, 133, 238, 0.7); }
                                        70% { box-shadow: 0 0 0 10px rgba(89, 133, 238, 0); }
                                        100% { box-shadow: 0 0 0 0 rgba(89, 133, 238, 0); }
                                    }
                                `;
                                document.head.appendChild(style);
                            }

                            // Fade in the image
                            setTimeout(() => {
                                imagePreview.style.transition = 'opacity 0.3s ease';
                                imagePreview.style.opacity = '1';
                            }, 50);

                            // Show file name in help text
                            const helpText = document.querySelector('.image-help-text');
                            if (helpText) {
                                const fileName = file.name;
                                const fileSize = Math.round(file.size / 1024); // Convert to KB
                                helpText.innerHTML = `
                                    <i class="mdi mdi-check-circle" style="color: #28a745; margin-right: 5px;"></i>
                                    <strong>${fileName}</strong> (${fileSize} KB)<br>
                                    <span style="color: #6c757d; font-size: 12px; margin-top: 5px; display: inline-block;">
                                        Click "Upload Image" again to change
                                    </span>
                                `;
                            }
                        };

                        reader.readAsDataURL(file);

                        // Validate file size and type
                        validateFileSize(this);
                    }
                });
            }

            // Password strength and validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const matchIndicator = document.getElementById('password-match-indicator');

            // Add event listener for password strength
            if (password) {
                password.addEventListener('input', function() {
                    const strength = checkPasswordStrength(this.value);
                    updatePasswordStrengthIndicator(strength);

                    if (confirmPassword && confirmPassword.value) {
                        validatePasswords();
                    }
                });
            }

            // Add event listener for password confirmation
            if (confirmPassword) {
                confirmPassword.addEventListener('input', function() {
                    validatePasswords();
                });
            }

            function checkPasswordStrength(password) {
                // Initialize score
                let score = 0;

                // If password is empty, return 0
                if (password.length === 0) return 0;

                // Award points for length
                if (password.length >= 8) score += 1;
                if (password.length >= 12) score += 1;

                // Award points for complexity
                if (/[A-Z]/.test(password)) score += 1; // Has uppercase
                if (/[a-z]/.test(password)) score += 1; // Has lowercase
                if (/[0-9]/.test(password)) score += 1; // Has number
                if (/[^A-Za-z0-9]/.test(password)) score += 1; // Has special char

                return score;
            }

            function updatePasswordStrengthIndicator(strength) {
                // Map strength score (0-6) to percentage width and color
                const maxScore = 6;
                const percentage = (strength / maxScore) * 100;

                // Update the strength bar
                if (strengthBar) {
                    strengthBar.style.width = percentage + '%';

                    // Set color based on strength
                    if (strength <= 2) {
                        strengthBar.style.backgroundColor = '#dc3545'; // Weak - red
                    } else if (strength <= 4) {
                        strengthBar.style.backgroundColor = '#ffc107'; // Medium - yellow
                    } else {
                        strengthBar.style.backgroundColor = '#28a745'; // Strong - green
                    }
                }

                // Update the strength text
                if (strengthText) {
                    if (strength === 0) {
                        strengthText.textContent = '';
                    } else if (strength <= 2) {
                        strengthText.textContent = 'Weak password';
                        strengthText.style.color = '#dc3545';
                    } else if (strength <= 4) {
                        strengthText.textContent = 'Medium strength password';
                        strengthText.style.color = '#ffc107';
                    } else {
                        strengthText.textContent = 'Strong password';
                        strengthText.style.color = '#28a745';
                    }
                }
            }

            function validatePasswords() {
                if (!matchIndicator) return false;

                if (password.value === confirmPassword.value && password.value !== '') {
                    matchIndicator.innerHTML = '<i class="mdi mdi-check-circle"></i> Passwords match';
                    matchIndicator.style.color = '#28a745';
                    confirmPassword.style.borderColor = '#28a745';
                    return true;
                } else if (confirmPassword.value === '') {
                    matchIndicator.innerHTML = '';
                    confirmPassword.style.borderColor = '';
                    return false;
                } else {
                    matchIndicator.innerHTML = '<i class="mdi mdi-alert-circle"></i> Passwords do not match';
                    matchIndicator.style.color = '#dc3545';
                    confirmPassword.style.borderColor = '#dc3545';
                    return false;
                }
            }

            function validateFileSize(input) {
                // Find the error container
                let errorContainer = input.closest('.image-upload').querySelector('.error');

                // If there's an existing error message, remove it
                if (errorContainer) {
                    errorContainer.remove();
                }

                if (input.files && input.files[0]) {
                    // Check file size (2MB = 2 * 1024 * 1024)
                    const maxSize = 2 * 1024 * 1024;
                    if (input.files[0].size > maxSize) {
                        showError(input, 'Image size must be less than 2MB');
                        return false;
                    }

                    // Check file type
                    const fileType = input.files[0].type;
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!validTypes.includes(fileType)) {
                        showError(input, 'File must be an image (JPEG, PNG, JPG, GIF)');
                        return false;
                    }

                    return true;
                }
                return true;
            }

            function showError(input, message) {
                // Remove any existing error messages
                const existingErrors = input.closest('.image-upload').querySelectorAll('.error');
                existingErrors.forEach(error => error.remove());

                // Create a new error message with icon
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error';
                errorDiv.innerHTML = `
                    <i class="mdi mdi-alert-circle" style="margin-right: 5px;"></i>
                    ${message}
                `;
                errorDiv.style.padding = '10px';
                errorDiv.style.marginTop = '10px';
                errorDiv.style.backgroundColor = 'rgba(220, 53, 69, 0.1)';
                errorDiv.style.borderRadius = '4px';
                errorDiv.style.display = 'flex';
                errorDiv.style.alignItems = 'center';

                // Find the help text element and insert the error after it
                const helpText = input.closest('.image-upload').querySelector('.image-help-text');
                if (helpText) {
                    helpText.insertAdjacentElement('afterend', errorDiv);
                } else {
                    // If no help text, append to the parent
                    input.closest('.image-upload').appendChild(errorDiv);
                }

                // Reset the image preview container
                const previewContainer = document.querySelector('.image-preview-container');
                if (previewContainer) {
                    previewContainer.style.borderColor = '#e0e0e0';
                    previewContainer.style.borderWidth = '3px';
                    previewContainer.style.animation = 'none';
                    previewContainer.style.boxShadow = '0 3px 10px rgba(0, 0, 0, 0.08)';
                }

                // Show the placeholder again
                const placeholder = document.getElementById('placeholder');
                const imagePreview = document.getElementById('image-preview');
                if (placeholder && imagePreview) {
                    placeholder.style.opacity = '1';
                    placeholder.style.visibility = 'visible';
                    placeholder.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
                    imagePreview.style.display = 'none';
                }

                // Reset the help text
                if (helpText) {
                    helpText.innerHTML = `
                        <i class="mdi mdi-information-outline" style="color: #5985ee; margin-right: 5px;"></i>
                        Recommended: Square image in JPG, PNG format<br>
                        Minimum size: 200x200 pixels
                    `;
                }

                // Clear the input
                input.value = '';
            }

            // Traditional form submission with client-side validation
            const userCreateForm = document.getElementById('user-create-form'); // Get form by ID
            if (userCreateForm) {
                userCreateForm.addEventListener('submit', function(e) {
                    // Validate passwords
                    if (!validatePasswords()) {
                        e.preventDefault();
                        alert('Please make sure your passwords match.');
                        confirmPassword.focus();
                        return false;
                    }

                    // Validate file if selected
                    if (imageInput && imageInput.files.length > 0) {
                        if (!validateFileSize(imageInput)) {
                            e.preventDefault();
                            return false;
                        }
                    }

                    // Show loading state
                    const submitBtn = document.getElementById('submit-btn');
                    submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin mr-1"></i> Creating...';
                    submitBtn.disabled = true;

                    // Log form data for debugging
                    console.log('Form submission data:');
                    const formData = new FormData(this);
                    for (let pair of formData.entries()) {
                        if (pair[0] !== 'password' && pair[0] !== 'password_confirmation') {
                            console.log(pair[0] + ': ' + pair[1]);
                        } else {
                            console.log(pair[0] + ': [REDACTED]');
                        }
                    }

                    // Let the form submit normally
                    return true;
                });
            }

            // Function to display validation errors
            function displayErrors(errors) {
                // Clear all existing error messages
                document.querySelectorAll('.error').forEach(el => {
                    el.remove();
                });

                // Reset all input borders
                document.querySelectorAll('input, select, textarea').forEach(el => {
                    el.style.borderColor = '';
                });

                // Re-validate passwords
                if (password && confirmPassword && confirmPassword.value) {
                    validatePasswords();
                }

                // Display new error messages
                if (errors) {
                    Object.keys(errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            input.style.borderColor = '#dc3545';

                            const errorMessage = errors[field][0];
                            const span = document.createElement('span');
                            span.className = 'error';
                            span.textContent = errorMessage;

                            // Add error message after the input
                            input.parentNode.appendChild(span);
                        }
                    });
                }
            }
        });
        </script>
    </body>
</html>

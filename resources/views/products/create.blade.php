<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Create Product</title>
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
            .products-container {
                padding: 30px 0;
            }

            .products-header {
                margin-bottom: 30px;
            }

            .products-title {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .products-title i {
                color: #4b6cb7;
                margin-right: 10px;
                font-size: 28px;
            }

            .products-subtitle {
                color: #6c757d;
                margin-bottom: 0;
            }

            .product-form-card {
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
            .form-group select,
            .form-group textarea {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                font-size: 14px;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
            }

            .form-group input:focus,
            .form-group select:focus,
            .form-group textarea:focus {
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

            /* Image upload styling */
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
                border-radius: 10px;
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
                object-fit: contain;
                object-position: center;
                display: none;
                background-color: white;
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

            .section-title {
                margin-top: 30px;
                margin-bottom: 20px;
                color: #495057;
                font-size: 18px;
                text-align: center;
                font-weight: 600;
                position: relative;
                padding-bottom: 10px;
            }

            .section-title:after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 50px;
                height: 2px;
                background-color: #4b6cb7;
            }

            .alert-custom {
                margin-bottom: 20px;
                padding: 15px;
                border-radius: 8px;
                background-color: #fff3cd;
                border: 1px solid #ffeeba;
            }

            .alert-custom h5 {
                margin-top: 0;
                color: #856404;
                font-weight: 600;
                font-size: 16px;
            }

            .alert-custom ul {
                margin-bottom: 0;
                padding-left: 20px;
                color: #856404;
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

        <!-- Include notification component -->
        @include('components.notification')

        <div class="products-container">
            <div class="container">
                <div class="products-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="products-title">
                                <i class="mdi mdi-package-variant-closed-plus"></i> Create New Product
                            </h1>
                            <p class="products-subtitle">Add a new product to your inventory</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('products.index') }}" class="btn-back">
                                <i class="mdi mdi-arrow-left"></i> Back to Products
                            </a>
                        </div>
                    </div>
                </div>

                <div class="product-form-card">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                        <div class="alert-custom">
                            <h5>Please fix the following errors:</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert-custom">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="profile-image-container">
                            <label for="image" class="image-preview-container" title="Click to change product image">
                                <div class="profile-placeholder" id="placeholder" style="display: flex; align-items: center; justify-content: center;">
                                    <div style="width: 80px; height: 80px; background-color: rgba(255, 255, 255, 0.8); border-radius: 50%; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; align-items: center; justify-content: center;">
                                        <i class="mdi mdi-image-outline" style="font-size: 40px; color: #4b6cb7;"></i>
                                    </div>
                                </div>
                                <img id="image-preview" class="image-preview">
                            </label>
                            <div class="image-upload">
                                <h4 style="margin-top: 0; margin-bottom: 15px; color: #444; font-size: 18px;">Product Image</h4>
                                <label for="image" class="custom-file-upload">
                                    <i class="mdi mdi-cloud-upload"></i> Upload Image
                                </label>
                                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <p class="image-help-text">
                                    <i class="mdi mdi-information-outline" style="color: #4b6cb7; margin-right: 5px;"></i>
                                    Optional: Upload an image for your product<br>
                                    Accepted formats: JPEG, PNG, JPG, GIF<br>
                                    Maximum size: 2MB
                                </p>
                                @error('image') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <h4 class="section-title">Product Details</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="mdi mdi-tag-outline mr-1"></i> Product Name
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter product name">
                                    @error('name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">
                                        <i class="mdi mdi-folder-outline mr-1"></i> Category
                                    </label>
                                    <select id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">
                                        <i class="mdi mdi-currency-usd mr-1"></i> Price ($)
                                    </label>
                                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required placeholder="0.00">
                                    @error('price') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">
                                        <i class="mdi mdi-package-variant mr-1"></i> Quantity in Stock
                                    </label>
                                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required placeholder="0">
                                    @error('quantity') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                <i class="mdi mdi-text-box-outline mr-1"></i> Product Description
                            </label>
                            <textarea id="description" name="description" rows="5" placeholder="Enter product description">{{ old('description') }}</textarea>
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-create">
                                <i class="mdi mdi-check-circle mr-1"></i> Create Product
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

        <!--Morris Chart-->
        <script src="{{asset('plugins/morris/morris.min.js')}}"></script>
        <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
    </body>
</html>

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
                        imagePreview.style.position = 'absolute';
                        imagePreview.style.top = '0';
                        imagePreview.style.left = '0';
                        imagePreview.style.right = '0';
                        imagePreview.style.bottom = '0';
                        imagePreview.style.margin = 'auto';

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
                    Required: PNG image with white background<br>
                    Maximum size: 2MB
                `;
            }

            // Clear the input
            input.value = '';
        }

        // Add input validation for price and quantity
        const priceInput = document.getElementById('price');
        if (priceInput) {
            priceInput.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        }

        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
                // Ensure it's an integer
                this.value = Math.floor(this.value);
            });
        }
    });
</script>

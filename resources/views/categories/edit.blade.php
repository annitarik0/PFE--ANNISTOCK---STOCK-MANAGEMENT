<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Edit Category</title>
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
            .categories-container {
                padding: 30px 0;
            }

            .categories-header {
                margin-bottom: 30px;
            }

            .categories-title {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .categories-title i {
                color: #4b6cb7;
                margin-right: 10px;
                font-size: 28px;
            }

            .categories-subtitle {
                color: #6c757d;
                margin-bottom: 0;
            }

            .category-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 15px rgba(0,0,0,0.05);
                margin-bottom: 30px;
                background-color: white;
                border: 1px solid rgba(0,0,0,0.03);
            }

            .btn-create-category {
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

            .btn-create-category i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-create-category:hover {
                background-color: #3a5aa0;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
            }

            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 10px; /* Consistent spacing between buttons */
            }

            .btn-edit, .btn-delete, .btn-update {
                background-color: #4b6cb7;
                color: white;
                border-radius: 6px;
                padding: 7px 12px;
                font-size: 13px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                min-width: 80px;
                border: none;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                height: 34px; /* Fixed height for consistency */
            }

            .btn-edit i, .btn-delete i, .btn-update i {
                margin-right: 5px;
                font-size: 15px;
            }

            .btn-edit:hover, .btn-delete:hover, .btn-update:hover {
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }

            .btn-edit:hover {
                background-color: #3a5aa0;
            }

            .btn-delete {
                background-color: #f1556c;
            }

            .btn-delete:hover {
                background-color: #e63e57;
            }

            .btn-update {
                background-color: #28a745;
                width: 100%;
                height: 40px;
                font-size: 14px;
            }

            .btn-update:hover {
                background-color: #218838;
            }

            .form-container {
                max-width: 800px;
                margin: 0 auto;
                padding: 30px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 3px 15px rgba(0,0,0,0.05);
                border: 1px solid rgba(0,0,0,0.03);
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

            .form-group input {
                width: 100%;
                padding: 10px 15px;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                font-size: 14px;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
            }

            .form-group input:focus {
                border-color: #4b6cb7;
                box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
                outline: none;
            }

            .error {
                color: #f1556c;
                font-size: 13px;
                margin-top: 5px;
                display: block;
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

        <div class="categories-container">
            <div class="container">
                <div class="categories-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="categories-title">
                                <i class="mdi mdi-tag-multiple"></i> Edit Category
                            </h1>
                            <p class="categories-subtitle">Update category information</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('categories.index') }}" class="btn-create-category">
                                <i class="mdi mdi-arrow-left"></i> Back to Categories
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-container">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">
                                <i class="mdi mdi-tag mr-1"></i> Category Name
                            </label>
                            <input type="text" id="name" name="name" required placeholder="Enter category name" value="{{ $category->name }}">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn-update">
                            <i class="mdi mdi-content-save"></i> Update Category
                        </button>
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
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
    </body>
</html>
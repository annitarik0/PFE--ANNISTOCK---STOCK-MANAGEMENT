<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Categories Management</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

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

            .filter-bar {
                background-color: #f8f9fa;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 30px;
                box-shadow: 0 3px 15px rgba(0,0,0,0.08);
                border: 1px solid rgba(0,0,0,0.03);
            }

            .filter-bar .form-group {
                margin-bottom: 0;
            }

            .filter-bar label {
                font-weight: 600;
                color: #4b6cb7;
                margin-bottom: 8px;
                display: block;
                font-size: 14px;
            }

            .filter-bar select, .filter-bar input {
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 10px 15px;
                background-color: white;
                width: 100%;
                font-size: 14px;
                color: #495057;
            }

            .filter-bar select {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234b6cb7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 10px center;
                background-size: 16px;
            }

            .filter-bar select:focus, .filter-bar input:focus {
                outline: none;
                border-color: #4b6cb7;
                box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
            }

            .filter-title {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
            }

            .filter-title i {
                margin-right: 8px;
                color: #4b6cb7;
            }

            .filter-reset {
                color: #4b6cb7;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                margin-left: auto;
            }

            .filter-reset i {
                margin-right: 5px;
                font-size: 16px;
            }

            .filter-reset:hover {
                color: #3a5aa0;
                text-decoration: none;
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

            .btn-edit, .btn-delete {
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

            .btn-edit i, .btn-delete i {
                margin-right: 5px;
                font-size: 15px;
            }

            .btn-edit:hover, .btn-delete:hover {
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

            .categories-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }

            .categories-table th {
                background: linear-gradient(to bottom, #f8f9fa, #f1f3f5);
                color: #495057;
                font-weight: 600;
                padding: 15px;
                border-bottom: 2px solid #e9ecef;
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 0.5px;
                text-align: center;
            }

            .categories-table td {
                padding: 15px;
                border-bottom: 1px solid #e9ecef;
                vertical-align: middle;
                transition: all 0.2s ease;
                text-align: center;
            }

            .categories-table tbody tr {
                transition: all 0.2s ease;
            }

            .categories-table tbody tr:hover {
                background-color: #f8f9fa;
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .categories-table tbody tr:last-child td {
                border-bottom: none;
            }

            .empty-categories {
                text-align: center;
                padding: 50px 20px;
                background-color: #f8f9fa;
                border-radius: 10px;
                margin: 30px 0;
            }

            .empty-categories i {
                font-size: 48px;
                color: #adb5bd;
                margin-bottom: 20px;
                display: block;
            }

            .empty-categories h3 {
                font-size: 20px;
                color: #495057;
                margin-bottom: 10px;
            }

            .empty-categories p {
                color: #6c757d;
                margin-bottom: 20px;
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
                                <i class="mdi mdi-tag-multiple"></i> Categories Management
                            </h1>
                            <p class="categories-subtitle">View and manage your product categories</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('categories.create') }}" class="btn-create-category">
                                <i class="mdi mdi-plus-circle"></i> Create New Category
                            </a>
                        </div>
                    </div>
                </div>



                <div class="category-card">
                    <div class="table-responsive">
                        <table class="categories-table">
                            <thead>
                                <tr>
                                    <th width="15%">ID</th>
                                    <th width="40%">Name</th>
                                    <th width="25%">Products Count</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categories-list">
                                @forelse($categories as $category)
                                <tr class="category-row"
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}"
                                    data-products="{{ $category->products->count() }}">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products->count() }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn-edit">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="margin: 0; padding: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                                    <i class="mdi mdi-delete"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-categories">
                                            <i class="mdi mdi-tag-off-outline"></i>
                                            <h3>No Categories Found</h3>
                                            <p>You haven't created any categories yet.</p>
                                            <a href="{{ route('categories.create') }}" class="btn-create-category">
                                                <i class="mdi mdi-plus-circle"></i> Create Your First Category
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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


    </body>
</html>
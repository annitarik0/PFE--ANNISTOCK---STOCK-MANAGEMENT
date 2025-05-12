<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - User Management</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

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

            .user-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 15px rgba(0,0,0,0.05);
                margin-bottom: 30px;
                background-color: white;
                border: 1px solid rgba(0,0,0,0.03);
            }

            .btn-create-user {
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

            .btn-create-user i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-create-user:hover {
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

            .users-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }

            .users-table th {
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

            .users-table td {
                padding: 15px;
                border-bottom: 1px solid #e9ecef;
                vertical-align: middle;
                transition: all 0.2s ease;
                text-align: center;
            }

            .users-table tbody tr {
                transition: all 0.2s ease;
            }

            .users-table tbody tr:hover {
                background-color: #f8f9fa;
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .users-table tbody tr:last-child td {
                border-bottom: none;
            }

            .user-image {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                margin: 0 auto;
            }

            .user-image-placeholder {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background-color: #4b6cb7;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 18px;
                margin: 0 auto;
            }

            .role-badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .role-admin {
                background-color: rgba(75, 108, 183, 0.15);
                color: #4b6cb7;
            }

            .role-employee {
                background-color: rgba(75, 108, 183, 0.15);
                color: #4b6cb7;
            }

            .role-user {
                background-color: rgba(108, 117, 125, 0.15);
                color: #6c757d;
            }

            .status-badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .status-active {
                background-color: rgba(2, 197, 141, 0.15);
                color: #02c58d;
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
                                <i class="mdi mdi-account-multiple"></i> User Management
                            </h1>
                            <p class="users-subtitle">View and manage your system users</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ url('/direct-create-user') }}" class="btn-create-user">
                                <i class="mdi mdi-account-plus"></i> Create New User
                            </a>
                        </div>
                    </div>
                </div>

                <div class="user-card">
                    <div class="table-responsive">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Image</th>
                                    <th width="20%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="10%">Role</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        @if($user->image)
                                            <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" class="user-image">
                                        @else
                                            <div class="user-image-placeholder">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="role-badge role-admin">Admin</span>
                                        @elseif($user->role == 'employee')
                                            <span class="role-badge role-employee">Employee</span>
                                        @else
                                            <span class="role-badge role-user">{{ ucfirst($user->role) }}</span>
                                        @endif
                                    </td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </a>

                                            @if(auth()->id() != $user->id)
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin: 0; padding: 0;" class="delete-user-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-delete delete-user-btn" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-role="{{ $user->role }}">
                                                        <i class="mdi mdi-delete"></i> Delete
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn-delete" style="background-color: #adb5bd;" disabled title="You cannot delete your own account">
                                                    <i class="mdi mdi-delete"></i> Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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

        <!--Morris Chart-->
        <script src="../plugins/morris/morris.min.js')}}"></script>
        <script src="../plugins/raphael/raphael.min.js')}}"></script>

        <!-- dashboard js -->
        <script src="{{asset('admin/assets/pages/dashboard.int.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle delete user buttons
                const deleteButtons = document.querySelectorAll('.delete-user-btn');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-user-id');
                        const userName = this.getAttribute('data-user-name');
                        const userRole = this.getAttribute('data-user-role');

                        // Additional warning for admin users
                        let warningMessage = `Are you sure you want to delete the user "${userName}"?`;
                        if (userRole === 'admin') {
                            warningMessage += '\n\nWARNING: This is an admin user. Deleting this user may affect system administration.';
                        }

                        warningMessage += '\n\nThis action cannot be undone.';

                        if (confirm(warningMessage)) {
                            // Find the parent form and submit it
                            const form = this.closest('form');
                            if (form) {
                                form.submit();
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>

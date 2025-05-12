<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Dashboard</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- morris css -->
        <link rel="stylesheet" href="../plugins/morris/morris.css">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
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
        @include('components.notification')
        
        <div class="user-form-wrapper">
            <div class="user-view-form">
                <h2 class="form-title">User Profile</h2>
                
                <div class="form-group text-center">
                    @if($user->image)
                        <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" style="max-width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 150px; height: 150px; border-radius: 50%; background-color: #007bff; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 60px; margin: 0 auto;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="form-control-static">{{ $user->name }}</div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="form-control-static">{{ $user->email }}</div>
                </div>

                <div class="form-group">
                    <label>Created At</label>
                    <div class="form-control-static">{{ $user->created_at->format('M d, Y') }}</div>
                </div>

                <div class="form-group">
                    <label>Last Updated</label>
                    <div class="form-control-static">{{ $user->updated_at->format('M d, Y') }}</div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
                    
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete User</button>
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

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
    </body>
</html>

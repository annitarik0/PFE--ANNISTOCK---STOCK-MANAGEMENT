<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header content -->
    
    @include('components.notification')
    
    <main>
        @yield('content')
    </main>
    
    <!-- Footer content -->
    
    <!-- Scripts -->
    <script>
        // Update notification count every 30 seconds
        setInterval(function() {
            fetch('/notifications/count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('.noti-icon-badge');
                    if (badge) {
                        badge.textContent = data.count;
                    }
                });
        }, 30000);
    </script>
</body>
</html>



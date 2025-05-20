<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Security Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:; connect-src 'self';">
    <!-- Security headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta name="referrer" content="strict-origin-when-cross-origin">
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



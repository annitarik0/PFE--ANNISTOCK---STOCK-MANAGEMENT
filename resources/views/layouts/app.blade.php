<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Enhanced Content Security Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' data: https://fonts.gstatic.com; connect-src 'self' https:; frame-src 'self'; object-src 'none'; base-uri 'self';">
    <!-- Security headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <!-- Permissions Policy -->
    <meta http-equiv="Permissions-Policy" content="camera=(), microphone=(), geolocation=(), interest-cohort=()">
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



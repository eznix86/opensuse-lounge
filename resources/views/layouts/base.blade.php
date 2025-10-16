<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? config('app.name', 'openSUSE Lounge') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-sans-3:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!--- Favicon -->
    <link rel="shortcut icon" href="/favicon-for-light.ico">
    <link rel="icon" href="/favicon-for-light.ico">
    <script>
      const shortcutIcon = document.querySelector('link[rel="shortcut icon"]');
      const faviconEl = document.querySelector('link[rel="icon"]');
      const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      mediaQuery.addEventListener('change', (event) => setDarkThemeEnabled(event.matches));
      function setDarkThemeEnabled(value) {
        if (value) {
          shortcutIcon.setAttribute('href', '/favicon-for-dark.ico');
          faviconEl.setAttribute('href', '/favicon-for-dark.ico');
        } else {
          shortcutIcon.setAttribute('href', '/favicon-for-light.ico');
          faviconEl.setAttribute('href', '/favicon-for-light.ico');
        }
      }
      setDarkThemeEnabled(mediaQuery.matches);
    </script>

</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col relative">    
        <div class="absolute top-0 left-0 right-0 bg-gradient-opensuse h-[70vh] dark:opacity-70 z-0">
        </div>    
        <!-- Navigation -->
        @yield('navigation')
        
        <!-- Flash Messages -->
        <div class="z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif
            
            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
        </div>
        <!-- Main Content -->
        @yield('main')
        
        <!-- Footer -->
        <footer class="@yield('footer-class', 'bg-card border-t border-default') mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <p class="text-center text-sm text-secondary">
                    &copy; {{ date('Y') }} openSUSE Project. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>


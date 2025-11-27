<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $pageTitle ?? 'Alas Chiquitanas' }} | {{ config('app.name') }}</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-100 font-sans antialiased">
    <!-- Header -->
    <x-frontend.header />
    
    <!-- Main Content -->
    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </main>
    
    <!-- Footer -->
    <x-frontend.footer />
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>


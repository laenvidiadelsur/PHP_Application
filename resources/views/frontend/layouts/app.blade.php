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
    
    <!-- External Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <style>
        .swiper-button-next, .swiper-button-prev {
            color: #ea580c;
        }
        .swiper-pagination-bullet-active {
            background: #ea580c;
        }
        .heart-animation {
            transition: transform 0.2s;
        }
        .heart-animation:active {
            transform: scale(1.3);
        }
    </style>
    
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
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Global Snackbar -->
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            timeout: null,
            notify(event) {
                this.show = true;
                this.message = event.detail.message;
                this.type = event.detail.type || 'success';
                
                if (this.timeout) clearTimeout(this.timeout);
                this.timeout = setTimeout(() => { this.show = false }, 3000);
            }
        }" 
        @notify.window="notify($event)"
        class="fixed bottom-4 right-4 z-50 flex items-center gap-2 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300"
        :class="{
            'translate-y-0 opacity-100': show,
            'translate-y-full opacity-0': !show,
            'bg-gray-900 text-white': type === 'success',
            'bg-red-600 text-white': type === 'error'
        }"
        style="display: none;"
        x-show="true">
        
        <span x-text="type === 'success' ? '✅' : '⚠️'"></span>
        <span class="font-medium text-sm" x-text="message"></span>
    </div>

    @stack('scripts')
</body>
</html>


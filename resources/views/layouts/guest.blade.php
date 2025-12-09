<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIM Pajak') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl animate-float"
            style="animation-delay: 1s;"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <!-- Logo -->
        <div class="mb-8 animate-slide-down">
            <a href="/" class="flex items-center justify-center">
                <img src="{{ asset('images/taxflow-logo.png') }}" alt="TaxFlow" class="h-16 w-auto">
            </a>
        </div>

        <!-- Content Card -->
        <div class="w-full sm:max-w-md animate-slide-up">
            <div class="card card-glass">
                {{ $slot }}
            </div>
        </div>

        <!-- Back to Home Link -->
        <div class="mt-6 animate-slide-up stagger-1">
            <a href="/" class="text-sm text-gray-600 hover:text-blue-600 transition-colors">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>
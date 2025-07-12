<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistema de emissão de certificados do IFMS.">
    <meta name="keywords"
        content="certificados, ifms, emissão de certificados, sistema de certificados, educação, tecnologia, Laravel">
    <meta name="author" content="Jaderson e Lara">
    <meta name="theme-color" content="#4CAF50">
    <title>@yield('title', config('app.name', 'Certificados IFMS'))</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('imagens/favicon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <title>{{ config('app.name', 'Certificados IFMS') }}</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/base.css') }}">
    <link rel="icon" href="{{ asset('imagens/favicon.ico') }}" type="image/x-icon">
    @stack('head')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-green-custom dark:bg-gray-900">
        <!-- logo laravel -->
        <!-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> -->

        <div>
            @include('layouts.base', ['slot' => $slot])
        </div>
    </div>
</body>

</html>

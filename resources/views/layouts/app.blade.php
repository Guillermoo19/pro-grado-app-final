<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- Fondo del body: blanco por defecto, gris muy oscuro en modo oscuro --}}
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-950">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-950"> {{-- Contenedor principal --}}
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                {{-- Header de la página: blanco por defecto, gris oscuro en modo oscuro --}}
                <header class="bg-white dark:bg-gray-850 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

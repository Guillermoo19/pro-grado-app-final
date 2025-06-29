<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Catálogo de Productos</title>

        <!-- Fuentes -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation') {{-- Se incluye la barra de navegación del layout de Breeze --}}

            <!-- Encabezado de Página -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Contenido de Página -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                                {{ __('Nuestro Catálogo de Productos') }}
                            </h2>

                            {{-- Mensajes de éxito y error al principio del contenedor --}}
                            @if (session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            @endif

                            @if ($productos->isEmpty())
                                <p>Lo sentimos. Actualmente no hay productos disponibles.</p>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($productos as $producto)
                                        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                                @if ($producto->imagen)
                                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="h-full w-full object-cover">
                                                @else
                                                    <img src="https://via.placeholder.com/400x300.png?text=Sin+Imagen" alt="Placeholder" class="h-full w-full object-cover">
                                                @endif
                                            </div>
                                            <div class="p-5 flex flex-col justify-between h-auto">
                                                <div>
                                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $producto->nombre }}</h3>
                                                    <p class="text-gray-700 text-sm mb-4">{{ Str::limit($producto->descripcion, 100) }}</p>
                                                    <div class="flex items-center justify-between mb-4">
                                                        <span class="text-2xl font-bold text-gray-900">${{ number_format($producto->precio, 2) }}</span>
                                                        <span class="text-sm text-gray-600">Stock: {{ $producto->stock }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="w-full mt-auto">
                                                    <form action="{{ route('carrito.add') }}" method="POST" class="w-full">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $producto->id }}">
                                                        <button type="submit" 
                                                                style="background-color: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; font-weight: bold; width: 100%; border: none; cursor: pointer;"
                                                                onmouseover="this.style.backgroundColor='#0056b3'" 
                                                                onmouseout="this.style.backgroundColor='#007bff'"
                                                                class="focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            Añadir al Carrito
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmación de Pedido - Los Chamos</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <!-- Barra de Navegación Simple -->
    <nav class="bg-chamos-marron-oscuro p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-chamos-amarillo text-2xl font-bold">Los Chamos</a>
            <div>
                <a href="{{ route('productos.catalogo') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 rounded-md text-sm font-medium mr-4">Catálogo</a>
                <a href="{{ route('carrito.index') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 rounded-md text-sm font-medium mr-4">Carrito</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 rounded-md text-sm font-medium">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 rounded-md text-sm font-medium">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenido Principal de Confirmación -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <h1 class="text-4xl font-bold text-chamos-marron-oscuro mb-4">¡Pedido Realizado con Éxito!</h1>
                <p class="text-lg text-gray-700 mb-6">Gracias por tu compra. Tu pedido #{{ $pedido->id }} ha sido procesado.</p>
                
                <div class="text-left inline-block bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-md mb-8">
                    <h2 class="text-2xl font-semibold text-chamos-marron-oscuro mb-4">Detalles del Pedido</h2>
                    <p class="text-gray-700 mb-2"><strong>Número de Pedido:</strong> {{ $pedido->id }}</p>
                    <p class="text-gray-700 mb-2"><strong>Fecha del Pedido:</strong> {{ $pedido->order_date->format('d/m/Y H:i') }}</p>
                    <p class="text-gray-700 mb-2"><strong>Total:</strong> ${{ number_format($pedido->total_amount, 2) }}</p>
                    <p class="text-gray-700 mb-2"><strong>Estado:</strong> <span class="capitalize">{{ $pedido->status }}</span></p>

                    <h3 class="text-xl font-semibold text-chamos-marron-claro mt-6 mb-3">Productos Incluidos:</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach ($pedido->detallePedidos as $detalle)
                            <li>{{ $detalle->producto->nombre }} - Cantidad: {{ $detalle->cantidad }} - Precio unitario: ${{ number_format($detalle->precio_unitario, 2) }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6">
                    <a href="{{ route('productos.catalogo') }}" class="inline-flex items-center px-6 py-3 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-chamos-amarillo focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                        Continuar Comprando
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-6 py-3 bg-chamos-marron-claro border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-chamos-marron-claro focus:ring-offset-2 transition ease-in-out duration-150">
                        Ver Mis Pedidos
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

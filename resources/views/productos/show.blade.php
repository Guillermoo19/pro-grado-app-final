<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ $producto->nombre }}</h3>

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
                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <!-- Columna de la Imagen -->
                    <div>
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-96 object-cover rounded-lg shadow-md">
                        @else
                            <img src="https://placehold.co/600x400.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-96 object-cover rounded-lg shadow-md">
                        @endif
                    </div>

                    <!-- Columna de Detalles y Formulario -->
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 mb-4">${{ number_format($producto->precio, 2) }}</p>
                        <p class="text-gray-700 text-base mb-6 leading-relaxed">{{ $producto->descripcion }}</p>

                        <!-- Ingredientes Relacionados -->
                        @if ($producto->ingredientes->isNotEmpty())
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Ingredientes Principales:</h4>
                            <ul class="list-disc list-inside text-gray-600 mb-6">
                                @foreach ($producto->ingredientes as $ingrediente)
                                    <li>{{ $ingrediente->nombre }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600 mb-6">No hay información de ingredientes disponible.</p>
                        @endif

                        <!-- Formulario para Añadir al Carrito -->
                        <form action="{{ route('carrito.add') }}" method="POST" class="flex flex-col gap-4">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                            <div class="flex items-center space-x-4">
                                <label for="cantidad" class="text-lg font-medium text-gray-700">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" value="1" min="1" class="w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-md text-xl transition duration-300 ease-in-out transform hover:scale-105">
                                Añadir al Carrito
                            </button>
                        </form>

                        <!-- Botón Volver al Catálogo -->
                        <div class="mt-8">
                            <a href="{{ route('productos.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                Volver al Catálogo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

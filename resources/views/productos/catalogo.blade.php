<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuestro Menú') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Explora Nuestros Deliciosos Platos') }}</h3>

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
                    <p class="text-gray-600">{{ __('No hay productos disponibles en el catálogo.') }}</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($productos as $producto)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                @if ($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-48 object-cover">
                                @else
                                    <img src="https://placehold.co/400x300.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $producto->nombre }}</h4>
                                    <p class="text-gray-600 text-sm mt-1 mb-2">{{ Str::limit($producto->descripcion, 70) }}</p>
                                    <p class="text-xl font-bold text-gray-800 mb-4">${{ number_format($producto->precio, 2) }}</p>

                                    {{-- ENLACE A LA NUEVA PÁGINA DE DETALLES DEL PRODUCTO --}}
                                    <a href="{{ route('productos.showPublic', $producto->id) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

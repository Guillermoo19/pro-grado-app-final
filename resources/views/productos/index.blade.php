<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menú de Los Chamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-900">{{ __('Explora Nuestro Delicioso Menú') }}</h3>

                {{-- Mensajes de sesión --}}
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

                {{-- Botón para Crear Producto, visible solo para administradores --}}
                @auth
                    @if (Auth::user()->isAdmin())
                        <div class="mb-6">
                            <a href="{{ route('admin.productos.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Crear Nuevo Producto') }}
                            </a>
                        </div>
                    @endif
                @endauth

                {{-- Itera sobre las categorías y luego sobre los productos de cada categoría --}}
                @forelse ($categorias as $categoria)
                    @if ($categoria->productos->count() > 0)
                        <div class="mb-8">
                            <h4 class="text-3xl font-extrabold text-gray-900 mb-4">
                                {{ $categoria->nombre }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($categoria->productos as $producto)
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden p-4 transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                        {{-- Contenido del producto --}}
                                        <div class="relative w-full h-48 mb-4">
                                            @if ($producto->imagen)
                                                <img src="{{ asset('storage/' . str_replace('public/', '', $producto->imagen)) }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover rounded-md shadow-md">
                                            @else
                                                <img src="https://placehold.co/400x300.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-full object-cover rounded-md shadow-md">
                                            @endif
                                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                                <a href="{{ route('productos.show', $producto->id) }}" class="text-white text-xl font-bold">Ver Detalles</a>
                                            </div>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $producto->nombre }}</h4>
                                        <p class="text-gray-700 text-center mb-4">{{ Str::limit($producto->descripcion, 75) }}</p>
                                        {{-- CAMBIO: Color del precio a negro para mejor visibilidad --}}
                                        <span class="text-2xl font-bold text-gray-900">${{ number_format($producto->precio, 2) }}</span>
                                        <a href="{{ route('productos.show', $producto->id) }}" class="mt-4 block w-full text-center bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Añadir al Carrito
                                        </a>
                                        {{-- Sección de administración para la vista pública --}}
                                        @auth
                                            @if (Auth::user()->isAdmin())
                                                <div class="mt-4 flex justify-center space-x-2">
                                                    {{-- Botones de administración --}}
                                                    <a href="{{ route('admin.productos.edit', $producto->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-black text-xs font-bold rounded-md transition-colors">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-md transition-colors">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-gray-500">
                        <p>No hay productos disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menú de Los Chamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-4">
                            {{-- Botón para volver al dashboard principal --}}
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-[#ffd700] border border-transparent rounded-md font-semibold text-xs text-chamos-marron-oscuro uppercase tracking-widest hover:bg-[#e6c100] active:bg-[#ccad00] focus:outline-none focus:border-[#ccad00] focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Volver a Inicio
                            </a>
                            <h3 class="text-2xl font-bold text-chamos-marron-oscuro">
                                {{ __('Explora Nuestro Delicioso Menú') }}
                            </h3>
                        </div>
                        {{-- Botón para crear un nuevo plato --}}
                        <a href="{{ route('admin.productos.create') }}" class="inline-flex items-center px-4 py-2 bg-[#ffd700] border border-transparent rounded-md font-semibold text-xs text-chamos-marron-oscuro uppercase tracking-widest hover:bg-[#e6c100] active:bg-[#ccad00] focus:outline-none focus:border-[#ccad00] focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Crear Nuevo Plato') }}
                        </a>
                    </div>
                    
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
                        <p class="text-gray-600">{{ __('No hay platos registrados en el sistema.') }}</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($productos as $producto)
                                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                    @if ($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">Sin imagen</div>
                                    @endif
                                    <div class="p-4">
                                        <h4 class="text-xl font-bold text-gray-900">{{ $producto->nombre }}</h4>
                                        <p class="text-gray-600">{{ $producto->descripcion }}</p>
                                        <p class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($producto->precio, 2) }}</p>
                                        <div class="mt-4 flex space-x-2">
                                            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="flex-1 text-center py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition ease-in-out duration-150">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este plato? Esta acción es irreversible.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex-1 py-2 px-4 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition ease-in-out duration-150">
                                                    Eliminar
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
    </div>
</x-app-layout>

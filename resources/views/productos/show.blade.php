<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Plato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row items-center md:items-start">
                    <div class="md:w-1/2 flex-shrink-0 mb-6 md:mb-0">
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-auto rounded-lg shadow-lg object-cover max-h-96">
                        @else
                            <img src="https://placehold.co/600x400.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-auto rounded-lg shadow-lg object-cover max-h-96">
                        @endif
                    </div>

                    <div class="md:w-1/2 md:ps-8">
                        <h3 class="text-3xl font-bold text-chamos-marron-oscuro mb-4">{{ $producto->nombre }}</h3>
                        <p class="text-gray-700 text-lg mb-4">{{ $producto->descripcion }}</p>
                        <p class="text-4xl font-extrabold text-chamos-verde mb-6">${{ number_format($producto->precio, 2) }}</p>

                        {{-- Formulario para añadir al carrito con opciones de ingredientes --}}
                        <form action="{{ route('carrito.add') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                            <div class="flex flex-col">
                                <label for="cantidad" class="text-lg font-semibold text-gray-700 mb-2">Cantidad de Platos:</label>
                                <input type="number" name="cantidad" id="cantidad" value="1" min="1" class="w-24 p-2 border border-gray-300 rounded-md shadow-sm text-center text-lg">
                            </div>

                            {{-- Sección para ingredientes personalizables --}}
                            @if ($ingredientes->isNotEmpty())
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-700 mb-3">Ingredientes Adicionales:</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach ($ingredientes as $ingrediente)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="ingredientes[]" value="{{ $ingrediente->id }}" class="form-checkbox text-chamos-verde h-5 w-5">
                                                <span class="ms-2 text-gray-700">{{ $ingrediente->nombre }} (+${{ number_format($ingrediente->precio, 2) }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <button type="submit" class="w-full px-6 py-3 bg-chamos-amarillo text-chamos-marron-oscuro font-bold rounded-md shadow-lg hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                Añadir al Carrito
                            </button>
                        </form>

                        <div class="mt-6">
                            <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Volver al Menú') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

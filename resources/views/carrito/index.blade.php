<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tu Carrito de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Tu Carrito de Compras') }}</h3>

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

                    {{-- Verifica si el carrito está vacío --}}
                    @if (empty($productosEnCarrito))
                        <p class="text-gray-600">{{ __('Tu carrito está vacío.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-xs text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Ir al Menú') }}
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($productosEnCarrito as $item)
                                <div class="flex items-center bg-gray-50 rounded-lg shadow-sm p-4">
                                    <div class="flex-shrink-0 w-24 h-24 rounded-md overflow-hidden mr-4">
                                        @if ($item['imagen'])
                                            <img src="{{ asset('storage/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://via.placeholder.co/100x100.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-full object-cover">
                                        @endif
                                    </div>

                                    <div class="flex-grow">
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $item['nombre'] }}</h4>
                                        <p class="text-md font-medium text-gray-700">${{ number_format($item['precio'], 2) }} x {{ $item['cantidad'] }}</p>

                                        {{-- Muestra los ingredientes adicionales --}}
                                        @if (count($item['ingredientes_adicionales']) > 0)
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p class="font-semibold">Ingredientes Adicionales:</p>
                                                <ul class="list-disc list-inside">
                                                    @foreach ($item['ingredientes_adicionales'] as $ingrediente)
                                                        <li>{{ $ingrediente->nombre }} (${{ number_format($ingrediente->precio, 2) }})</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex flex-col items-end space-y-2 ml-4">
                                        <p class="font-bold text-lg text-gray-900">${{ number_format($item['subtotal'], 2) }}</p>
                                        <div class="flex items-center space-x-2">
                                             {{-- Formulario para actualizar cantidad --}}
                                            <form action="{{ route('carrito.update') }}" method="POST" class="flex items-center">
                                                @csrf
                                                <input type="hidden" name="item_key" value="{{ $item['item_key'] }}">
                                                <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="0" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center">
                                                <button type="submit" class="ml-2 px-3 py-1 bg-chamos-verde text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Actualizar
                                                </button>
                                            </form>
                                        </div>
                                         {{-- Formulario para eliminar producto --}}
                                        <form action="{{ route('carrito.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="item_key" value="{{ $item['item_key'] }}">
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Contenedor del total y el botón de pago --}}
                        <div class="flex flex-col sm:flex-row justify-between items-end mt-8 pt-4 border-t border-gray-200 relative">
                            <h4 class="text-xl font-bold text-gray-900 mb-4 sm:mb-0">{{ __('Total del Carrito:') }} ${{ number_format($total, 2) }}</h4>
                            
                            <div class="ml-auto relative z-10">
                                <form id="checkoutForm" action="{{ route('carrito.checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="px-6 py-3 bg-chamos-verde text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Proceder al Pago') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

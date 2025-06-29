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

                    @if (empty($cart))
                        <p class="text-gray-600">{{ __('Tu carrito está vacío.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('productos.catalogo') }}" class="inline-flex items-center px-4 py-2 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-xs text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Ir al Catálogo') }}
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @php $total = 0; @endphp
                            @foreach ($cart as $id => $item)
                                @php $total += $item['precio'] * $item['cantidad']; @endphp
                                <div class="flex items-center bg-gray-50 rounded-lg shadow-sm p-4">
                                    {{-- Imagen del producto --}}
                                    <div class="flex-shrink-0 w-24 h-24 rounded-md overflow-hidden mr-4">
                                        @if ($item['imagen'])
                                            <img src="{{ asset('storage/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/100x100.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-full object-cover">
                                        @endif
                                    </div>

                                    <div class="flex-grow">
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $item['nombre'] }}</h4>
                                        <p class="text-sm text-gray-600 mb-2">{{ $item['descripcion'] }}</p>
                                        <p class="text-md font-medium text-gray-700">${{ number_format($item['precio'], 2) }} x {{ $item['cantidad'] }}</p>
                                    </div>

                                    <div class="flex items-center space-x-3 ml-4">
                                        {{-- Formulario para actualizar cantidad --}}
                                        <form action="{{ route('carrito.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center">
                                            {{-- ******************************************************* --}}
                                            {{-- ¡AJUSTE DE ESTILO! Botón "Actualizar" como texto simple --}}
                                            <button type="submit" 
                                                    style="background: none; border: none; color: #007bff; text-decoration: underline; cursor: pointer; font-weight: bold; margin-left: 0.5rem;"
                                                    onmouseover="this.style.color='#0056b3'" 
                                                    onmouseout="this.style.color='#007bff'">
                                                Actualizar
                                            </button>
                                            {{-- ******************************************************* --}}
                                        </form>

                                        {{-- Formulario para eliminar producto (ya visible en rojo) --}}
                                        <form action="{{ route('carrito.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200">
                            <h4 class="text-xl font-bold text-gray-900">{{ __('Total del Carrito:') }} ${{ number_format($total, 2) }}</h4>
                            <form action="{{ route('carrito.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-chamos-verde text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Proceder al Pago') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Producto') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ $producto->nombre }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                @if ($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg shadow-md">
                                        <span class="text-gray-500">{{ __('No hay imagen disponible') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-lg text-gray-700 mb-2"><strong>{{ __('Descripción:') }}</strong> {{ $producto->descripcion ?? 'N/A' }}</p>
                                <p class="text-lg text-gray-700 mb-2"><strong>{{ __('Precio:') }}</strong> ${{ number_format($producto->precio, 2) }}</p>
                                <p class="text-lg text-gray-700 mb-2"><strong>{{ __('Stock:') }}</strong> {{ $producto->stock }}</p>
                                <p class="text-lg text-gray-700 mb-4"><strong>{{ __('Categoría:') }}</strong> {{ $producto->categoria->nombre ?? 'N/A' }}</p>

                                @if ($producto->ingredientes->isNotEmpty())
                                    <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ __('Ingredientes:') }}</h4>
                                    <ul class="list-disc list-inside text-gray-700">
                                        @foreach ($producto->ingredientes as $ingrediente)
                                            <li>{{ $ingrediente->nombre }} ({{ $ingrediente->pivot->cantidad }} {{ $ingrediente->pivot->unidad_medida }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-600">{{ __('No hay ingredientes asociados a este producto.') }}</p>
                                @endif

                                <div class="mt-6 flex space-x-4">
                                    <a href="{{ route('admin.productos.edit', $producto->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Editar Producto') }}
                                    </a>
                                    <a href="{{ route('admin.productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Volver a la lista') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
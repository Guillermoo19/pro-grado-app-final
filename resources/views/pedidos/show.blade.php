<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de Mi Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">Pedido #{{ $pedido->id }}</h3>

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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Información del Pedido -->
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Información del Pedido') }}</h4>
                        <p class="text-gray-700 mb-2"><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y') }}</p>
                        <p class="text-gray-700 mb-2"><strong>Hora:</strong> {{ $pedido->created_at->format('H:i') }}</p>
                        <p class="text-gray-700 mb-2"><strong>Total Pagado:</strong> <span class="font-bold text-green-600">${{ number_format($pedido->total, 2) }}</span></p>
                        <p class="text-gray-700 mb-2"><strong>Estado del Pedido:</strong> <span class="font-bold">{{ ucfirst($pedido->estado_pedido) }}</span></p>
                        <p class="text-gray-700 mb-2"><strong>Estado del Pago:</strong> <span class="font-bold">{{ ucfirst($pedido->estado_pago) }}</span></p>
                        <p class="text-gray-700 mb-2"><strong>Tipo de Entrega:</strong> <span class="font-bold">{{ ucfirst($pedido->tipo_entrega) }}</span></p>
                        @if ($pedido->tipo_entrega === 'domicilio')
                            <p class="text-gray-700 mb-2"><strong>Dirección de Entrega:</strong> {{ $pedido->direccion_entrega ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Teléfono de Contacto:</strong> {{ $pedido->telefono_contacto ?? 'N/A' }}</p>
                        @endif
                    </div>

                    <!-- Información del Cliente -->
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Información del Cliente') }}</h4>
                        @if ($pedido->user)
                            <p class="text-gray-700 mb-2"><strong>Nombre:</strong> {{ $pedido->user->name }}</p>
                            <p class="text-gray-700 mb-2"><strong>Correo:</strong> {{ $pedido->user->email }}</p>
                            @if ($pedido->telefono_contacto)
                                <p class="text-gray-700 mb-2"><strong>Teléfono (Pedido):</strong> {{ $pedido->telefono_contacto }}</p>
                            @endif
                            @if ($pedido->direccion_entrega)
                                <p class="text-gray-700 mb-2"><strong>Dirección (Pedido):</strong> {{ $pedido->direccion_entrega }}</p>
                            @endif
                        @else
                            <p class="text-gray-700 mb-2">Usuario no disponible.</p>
                        @endif
                    </div>
                </div>

                <!-- Detalles de los Platos -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Platos en tu Pedido') }}</h4>
                @if ($pedido->productos->isEmpty())
                    <p class="text-gray-600">No hay platos en este pedido.</p>
                @else
                    <div class="border rounded-lg overflow-hidden mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plato</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($pedido->productos as $producto)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->pivot->cantidad }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($producto->pivot->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Comprobante de Pago -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Comprobante de Pago') }}</h4>
                @if ($pedido->comprobante_url)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $pedido->comprobante_url) }}" alt="Comprobante de Pago" class="w-64 h-auto rounded-lg shadow-md mt-2">
                        <a href="{{ asset('storage/' . $pedido->comprobante_url) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-gray-900 uppercase tracking-widest hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition ease-in-out duration-150 mt-4">
                            {{ __('Ver comprobante en tamaño completo') }}
                        </a>
                    </div>
                @else
                    <p class="text-gray-600 mb-4">No se ha subido ningún comprobante para este pedido.</p>
                @endif

                <div class="mt-8 text-right">
                    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-gray-900 uppercase tracking-widest hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Volver a Mis Pedidos') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Pedido (Admin)') }}
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
                        <p class="text-gray-700 mb-2"><strong>Tipo de Entrega:</strong> <span class="font-bold">{{ ucfirst(str_replace('_', ' ', $pedido->tipo_entrega)) }}</span></p>
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
                        @else
                            <p class="text-gray-700 mb-2">Usuario no disponible.</p>
                        @endif
                    </div>
                </div>

                <!-- Detalles de los Platos -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Platos en el Pedido') }}</h4>
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
                        <a href="{{ asset('storage/' . $pedido->comprobante_url) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm mt-2 block">Ver comprobante en tamaño completo</a>
                    </div>
                @else
                    <p class="text-gray-600 mb-4">No se ha subido ningún comprobante para este pedido.</p>
                @endif

                <!-- Formulario para Actualizar Estado del Pedido -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3 mt-8">{{ __('Actualizar Estado del Pedido') }}</h4>
                <form action="{{ route('admin.pedidos.update_estado_pedido', $pedido->id) }}" method="POST" class="mb-6">
                    @csrf
                    @method('PATCH')
                    <div class="flex items-center space-x-4">
                        <select name="estado_pedido" class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pendiente" {{ $pedido->estado_pedido == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_preparacion" {{ $pedido->estado_pedido == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                            <option value="en_camino" {{ $pedido->estado_pedido == 'en_camino' ? 'selected' : '' }}>En Camino</option>
                            <option value="entregado" {{ $pedido->estado_pedido == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelado" {{ $pedido->estado_pedido == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Actualizar Estado Pedido</button>
                    </div>
                </form>

                <!-- Formulario para Actualizar Estado del Pago -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Actualizar Estado del Pago') }}</h4>
                <form action="{{ route('admin.pedidos.update_estado_pago', $pedido->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="flex items-center space-x-4">
                        <select name="estado_pago" class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pendiente" {{ $pedido->estado_pago == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pendiente_revision" {{ $pedido->estado_pago == 'pendiente_revision' ? 'selected' : '' }}>Pendiente de Revisión</option>
                            <option value="pagado" {{ $pedido->estado_pago == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="rechazado" {{ $pedido->estado_pago == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Actualizar Estado Pago</button>
                    </div>
                </form>

                <div class="mt-8 text-right">
                    <a href="{{ route('admin.pedidos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Volver a la Lista de Pedidos') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

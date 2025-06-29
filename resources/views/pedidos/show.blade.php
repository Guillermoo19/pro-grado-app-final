<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Pedido #') . $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-chamos-marron-oscuro mb-4">Pedido #{{ $pedido->id }}</h3>

                    <div class="mb-6">
                        <p class="text-gray-700 mb-2"><strong>Fecha:</strong> {{ $pedido->order_date->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-700 mb-2"><strong>Total:</strong> ${{ number_format($pedido->total_amount, 2) }}</p>
                        <p class="text-gray-700 mb-2"><strong>Estado:</strong> <span class="capitalize">{{ $pedido->status }}</span></p>
                    </div>

                    <h4 class="text-xl font-semibold text-chamos-marron-claro mb-3">Productos del Pedido:</h4>
                    @if ($pedido->detallePedidos->isEmpty())
                        <p class="text-gray-700">No hay productos en este pedido.</p>
                    @else
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-chamos-marron-claro border border-gray-200 rounded-md">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pedido->detallePedidos as $detalle)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detalle->producto->nombre ?? 'Producto Eliminado' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detalle->cantidad }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="text-center mt-6">
                        <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition ease-in-out duration-150">
                            Volver a Mis Pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

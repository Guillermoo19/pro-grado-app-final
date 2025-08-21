<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Botón para volver al dashboard principal --}}
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Volver a Inicio
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Pedidos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Pedidos Pendientes (Lado Izquierdo) --}}
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">Pedidos Pendientes</h2>
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full leading-normal">
                                        <thead>
                                            <tr>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    ID Pedido
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Usuario
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Total
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Estado Pedido
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Estado Pago
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pedidosPendientes as $pedido)
                                                <tr>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pedido->id }}</td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pedido->user->name ?? 'N/A' }}</td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${{ number_format($pedido->total, 2) }}</td>
                                                    <td class="py-4 px-6">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                            @if ($pedido->estado_pedido === 'pendiente') bg-yellow-100 text-yellow-800
                                                            @elseif ($pedido->estado_pedido === 'en_preparacion') bg-blue-100 text-blue-800
                                                            @elseif ($pedido->estado_pedido === 'en_camino') bg-purple-100 text-purple-800
                                                            @elseif ($pedido->estado_pedido === 'entregado') bg-green-100 text-green-800
                                                            @elseif ($pedido->estado_pedido === 'cancelado') bg-red-100 text-red-800
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado_pedido)) }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                            @if ($pedido->estado_pago === 'pendiente') bg-yellow-100 text-yellow-800
                                                            @elseif ($pedido->estado_pago === 'pendiente_revision') bg-orange-100 text-orange-800
                                                            @elseif ($pedido->estado_pago === 'pagado') bg-green-100 text-green-800
                                                            @elseif ($pedido->estado_pago === 'rechazado') bg-red-100 text-red-800
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado_pago)) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                                        No hay pedidos pendientes por revisar.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Pedidos Completados (Lado Derecho) --}}
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">Pedidos Completados</h2>
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full leading-normal">
                                        <thead>
                                            <tr>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    ID Pedido
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Usuario
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Total
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Estado
                                                </th>
                                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pedidosCompletados as $pedido)
                                                <tr>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pedido->id }}</td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pedido->user->name ?? 'N/A' }}</td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${{ number_format($pedido->total, 2) }}</td>
                                                    <td class="py-4 px-6">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Entregado y Pagado
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                                        No hay pedidos completados.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

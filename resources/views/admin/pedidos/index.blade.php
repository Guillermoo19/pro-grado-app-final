<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Botón para volver al dashboard principal --}}
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150" style="color: #4A2004;">
                Volver a Inicio
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Pedidos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Pedidos Pendientes --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4 text-yellow-600">Pedidos Pendientes</h2>
                        {{-- Aplicamos el color de fondo a todo el cuadro --}}
                        <div class="p-6 rounded-lg shadow-md bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pedidosPendientes as $pedido)
                                            <tr class="bg-white">
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->id }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->user->name ?? 'N/A' }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">${{ number_format($pedido->total, 2) }}</td>
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if ($pedido->estado_pago === 'pendiente') bg-yellow-100 text-yellow-800
                                                        @elseif ($pedido->estado_pago === 'pendiente_revision') bg-orange-100 text-orange-800
                                                        @elseif ($pedido->estado_pago === 'pagado') bg-green-100 text-green-800
                                                        @elseif ($pedido->estado_pago === 'rechazado') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado_pago)) }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm space-x-2 flex items-center">
                                                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="text-yellow-600 hover:text-yellow-800">Ver Detalles</a>
                                                    {{-- Formulario para eliminar --}}
                                                    <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white">
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-800">
                                                    No hay pedidos pendientes por revisar.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Pedidos Completados --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4 text-green-600">Pedidos Completados</h2>
                        {{-- Aplicamos el color de fondo a todo el cuadro --}}
                        <div class="p-6 rounded-lg shadow-md bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pedidosCompletados as $pedido)
                                            <tr class="bg-white">
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->id }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->user->name ?? 'N/A' }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">${{ number_format($pedido->total, 2) }}</td>
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if ($pedido->estado_pago === 'pendiente') bg-yellow-100 text-yellow-800
                                                        @elseif ($pedido->estado_pago === 'pendiente_revision') bg-orange-100 text-orange-800
                                                        @elseif ($pedido->estado_pago === 'pagado') bg-green-100 text-green-800
                                                        @elseif ($pedido->estado_pago === 'rechazado') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado_pago)) }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm space-x-2 flex items-center">
                                                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="text-green-600 hover:text-green-800">Ver Detalles</a>
                                                    {{-- Formulario para eliminar --}}
                                                    <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white">
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-800">
                                                    No hay pedidos completados.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Pedidos Cancelados pero Pagados --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4 text-orange-600">Pedidos Cancelados (Pagados)</h2>
                        {{-- Aplicamos el color de fondo a todo el cuadro --}}
                        <div class="p-6 rounded-lg shadow-md bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Aquí se corrige la iteración --}}
                                        @forelse ($pedidosCanceladosPagados as $pedido)
                                            <tr class="bg-white">
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->id }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->user->name ?? 'N/A' }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">${{ number_format($pedido->total, 2) }}</td>
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if ($pedido->estado_pago === 'pendiente') bg-yellow-100 text-yellow-800
                                                        @elseif ($pedido->estado_pago === 'pendiente_revision') bg-orange-100 text-orange-800
                                                        @elseif ($pedido->estado_pago === 'pagado') bg-green-100 text-green-800
                                                        @elseif ($pedido->estado_pago === 'rechazado') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado_pago)) }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm space-x-2 flex items-center">
                                                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="text-orange-600 hover:text-orange-800">Ver Detalles</a>
                                                    {{-- Formulario para eliminar --}}
                                                    <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white">
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-800">
                                                    No hay pedidos cancelados que necesiten revisión.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Pedidos Rechazados --}}
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-red-600">Pedidos Rechazados</h2>
                        {{-- Aplicamos el color de fondo a todo el cuadro --}}
                        <div class="p-6 rounded-lg shadow-md bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pedidosRechazados as $pedido)
                                            <tr class="bg-white">
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->id }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">{{ $pedido->user->name ?? 'N/A' }}</td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-800">${{ number_format($pedido->total, 2) }}</td>
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if ($pedido->estado_pago === 'pendiente') bg-yellow-100 text-yellow-800
                                                        @elseif ($pedido->estado_pago === 'pendiente_revision') bg-orange-100 text-orange-800
                                                        @elseif ($pedido->estado_pago === 'pagado') bg-green-100 text-green-800
                                                        @elseif ($pedido->estado_pago === 'rechazado') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado_pago)) }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 text-sm space-x-2 flex items-center">
                                                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="text-red-600 hover:text-red-800">Ver Detalles</a>
                                                    {{-- Formulario para eliminar --}}
                                                    <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white">
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-800">
                                                    No hay pedidos rechazados.
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
</x-app-layout>

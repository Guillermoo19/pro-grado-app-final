<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Todos los Pedidos') }}</h3>

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

                    @if ($pedidos->isEmpty())
                        <p class="text-gray-600">{{ __('No hay pedidos registrados.') }}</p>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">{{ __('ID Pedido') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Usuario') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Fecha') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Total') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Estado') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedidos as $pedido)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $pedido->id }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $pedido->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="py-4 px-6">
                                                ${{ number_format($pedido->total, 2) }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $pedido->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $pedido->estado === 'completado' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $pedido->estado === 'cancelado' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($pedido->estado) }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6">
                                                {{-- CORREGIDO: Apunta a la ruta admin.pedidos.show --}}
                                                <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="font-medium text-blue-600 hover:underline">
                                                    {{ __('Ver Detalles') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

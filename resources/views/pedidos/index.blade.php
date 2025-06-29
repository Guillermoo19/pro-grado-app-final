<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Historial de Mis Compras</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($pedidos->isEmpty())
                        <p class="text-center text-gray-700 text-lg">Aún no has realizado ningún pedido. ¡Explora nuestro <a href="{{ route('productos.catalogo') }}" class="text-blue-600 hover:underline">catálogo</a>!</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-chamos-marron-claro">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pedido</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pedidos as $pedido)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pedido->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pedido->order_date->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($pedido->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">{{ $pedido->status }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-blue-300 focus:bg-blue-300 active:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2 transition ease-in-out duration-150">Ver Detalles</a>
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

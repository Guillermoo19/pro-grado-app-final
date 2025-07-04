<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Pedido #') }}{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Información del Pedido</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        <strong>ID de Pedido:</strong> {{ $pedido->id }}<br>
                        <strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}<br>
                        <strong>Total:</strong> ${{ number_format($pedido->total, 2) }}<br>
                        <strong>Estado:</strong> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $pedido->estado }}</span>
                    </p>
                    @if (Auth::user()->isAdmin() && $pedido->user)
                        <p class="mt-2 text-sm text-gray-600">
                            <strong>Usuario:</strong> {{ $pedido->user->name }} ({{ $pedido->user->email }})
                        </p>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Productos en este Pedido</h3>
                    @if ($pedido->productos->isEmpty())
                        <p class="mt-1 text-sm text-gray-600">Este pedido no tiene productos.</p>
                    @else
                        <div class="mt-4 border-t border-gray-200">
                            <ul role="list" class="divide-y divide-gray-200">
                                @foreach ($pedido->productos as $item)
                                    <li class="py-4 flex">
                                        {{-- AÑADIDO: Imagen del producto --}}
                                        <div class="flex-shrink-0 w-24 h-24 rounded-md overflow-hidden">
                                            @if ($item->imagen)
                                                <img src="{{ asset('storage/' . $item->imagen) }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://via.placeholder.com/100x100.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-full object-cover">
                                            @endif
                                        </div>

                                        <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3>
                                                        {{-- CORREGIDO: Acceso directo al nombre del producto --}}
                                                        @if ($item) 
                                                            <a href="#">{{ $item->nombre }}</a>
                                                        @else
                                                            Producto no disponible
                                                        @endif
                                                    </h3>
                                                    {{-- Acceso al subtotal desde la tabla pivote --}}
                                                    <p class="ml-4">${{ number_format($item->pivot->subtotal, 2) }}</p> 
                                                </div>
                                                {{-- Acceso a cantidad y precio unitario desde la tabla pivote --}}
                                                <p class="mt-1 text-sm text-gray-500">Cantidad: {{ $item->pivot->cantidad }}</p>
                                                <p class="mt-1 text-sm text-gray-500">Precio Unitario: ${{ number_format($item->pivot->precio_unitario, 2) }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

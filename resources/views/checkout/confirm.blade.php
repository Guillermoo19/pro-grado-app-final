<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Confirmación de Pedido y Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro dark:text-white">{{ __('Tu Pedido Ha Sido Creado') }}</h3>

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

                <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">Número de Pedido: <span class="font-bold">{{ $pedido->id }}</span></p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">Total a Pagar: <span class="font-bold text-green-600">${{ number_format($pedido->total, 2) }}</span></p>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-inner mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ __('Datos Bancarios para la Transferencia') }}</h4>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">Por favor, realiza la transferencia bancaria al siguiente número de cuenta y sube el comprobante.</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Banco:</strong> {{ $configuracion->banco ?? 'N/A' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Número de Cuenta:</strong> {{ $configuracion->numero_cuenta ?? 'N/A' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Nombre del Titular:</strong> {{ $configuracion->nombre_titular ?? 'N/A' }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Tipo de Cuenta:</strong> {{ $configuracion->tipo_cuenta ?? 'N/A' }}</p>
                </div>

                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ __('Productos en tu Pedido') }}</h4>
                    <ul>
                        @foreach($pedido->detalles as $detalle)
                            <li class="mb-2">
                                <span class="font-bold">{{ $detalle->cantidad }}x {{ $detalle->producto->nombre }}</span> - ${{ number_format($detalle->subtotal, 2) }}
                                @if ($detalle->ingredientes_adicionales)
                                    <ul class="ml-4 list-disc list-inside text-gray-600 dark:text-gray-400">
                                        @foreach($detalle->ingredientes_adicionales as $ingrediente)
                                            <li>+ {{ $ingrediente['nombre'] }} (${{ number_format($ingrediente['precio'], 2) }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro dark:text-white">{{ __('Subir Comprobante de Pago y Detalles de Entrega') }}</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">Por favor, sube una imagen (JPG, PNG, GIF, SVG) o PDF de tu comprobante de transferencia.</p>

                <form action="{{ route('checkout.upload_proof', $pedido->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="tipo_entrega" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Entrega</label>
                        <select name="tipo_entrega" id="tipo_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-gray-300" onchange="toggleDeliveryFields()">
                            <option value="recoger_local" {{ old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'recoger_local' ? 'selected' : '' }}>Recoger en Local</option>
                            <option value="domicilio" {{ old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'domicilio' ? 'selected' : '' }}>Envío a Domicilio</option>
                        </select>
                        @error('tipo_entrega')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="delivery_fields" class="{{ old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'domicilio' ? '' : 'hidden' }}">
                        <div class="mb-4">
                            <label for="direccion_entrega" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección de Entrega</label>
                            <input type="text" name="direccion_entrega" id="direccion_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-gray-300" value="{{ old('direccion_entrega', $pedido->direccion_entrega ?? '') }}">
                            @error('direccion_entrega')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="telefono_contacto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono de Contacto</label>
                            <input type="text" name="telefono_contacto" id="telefono_contacto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-gray-300" value="{{ old('telefono_contacto', $pedido->telefono_contacto ?? '') }}">
                            @error('telefono_contacto')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="proof_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seleccionar Comprobante:</label>
                        <input type="file" name="proof_image" id="proof_image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        @error('proof_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-chamos-verde text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Subir Comprobante y Guardar Detalles') }}
                        </button>
                        <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Ir a Mis Pedidos') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleDeliveryFields() {
            const tipoEntrega = document.getElementById('tipo_entrega').value;
            const deliveryFields = document.getElementById('delivery_fields');
            if (tipoEntrega === 'domicilio') {
                deliveryFields.classList.remove('hidden');
            } else {
                deliveryFields.classList.add('hidden');
            }
        }

        // Ejecutar al cargar la página para establecer el estado inicial
        document.addEventListener('DOMContentLoaded', toggleDeliveryFields);
    </script>
</x-app-layout>

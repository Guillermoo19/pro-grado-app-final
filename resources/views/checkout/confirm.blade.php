<x-app-layout>
    <x-slot name="header">
        {{-- Hacemos el texto del encabezado oscuro para que se vea en el fondo blanco. --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmación de Pedido y Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Cambiamos el fondo principal de la tarjeta a blanco --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Tu Pedido Ha Sido Creado') }}</h3>

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

                {{-- Hacemos el texto oscuro para que sea visible en el fondo blanco --}}
                <p class="text-lg text-gray-700 mb-4">Número de Pedido: <span class="font-bold">{{ $pedido->id }}</span></p>
                <p class="text-lg text-gray-700 mb-6">Total a Pagar: <span class="font-bold text-green-600">${{ number_format($pedido->total, 2) }}</span></p>

                <!-- SECCIÓN DE SELECCIÓN DEL MÉTODO DE PAGO -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Seleccionar Método de Pago') }}</h4>
                <div class="flex items-center space-x-6 mb-8">
                    <div class="flex items-center">
                        {{-- Aseguramos que el color del radio button sea visible --}}
                        <input type="radio" name="metodo_pago" id="bank_transfer" value="bank_transfer" class="form-radio h-4 w-4 text-chamos-verde-claro transition duration-150 ease-in-out" checked onchange="togglePaymentFields()">
                        <label for="bank_transfer" class="ml-2 block text-sm leading-5 font-medium text-gray-700">
                            Transferencia Bancaria
                        </label>
                    </div>
                    <div class="flex items-center">
                        {{-- Aseguramos que el color del radio button sea visible --}}
                        <input type="radio" name="metodo_pago" id="qr_payment" value="qr_payment" class="form-radio h-4 w-4 text-chamos-verde-claro transition duration-150 ease-in-out" onchange="togglePaymentFields()">
                        <label for="qr_payment" class="ml-2 block text-sm leading-5 font-medium text-gray-700">
                            Código QR
                        </label>
                    </div>
                </div>

                <!-- CONTENIDO DINÁMICO SEGÚN EL MÉTODO DE PAGO -->
                {{-- Cambiamos el fondo de la sección a gris claro o blanco --}}
                <div id="bank_transfer_fields" class="bg-gray-50 p-4 rounded-lg shadow-inner mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Datos Bancarios para la Transferencia') }}</h4>
                    <p class="text-gray-700 mb-2">Por favor, realiza la transferencia bancaria al siguiente número de cuenta y sube el comprobante.</p>
                    <p class="text-gray-700 mb-2"><strong>Banco:</strong> {{ $configuracion->banco ?? 'N/A' }}</p>
                    <p class="text-gray-700 mb-2"><strong>Número de Cuenta:</strong> {{ $configuracion->numero_cuenta ?? 'N/A' }}</p>
                    <p class="text-gray-700 mb-2"><strong>Nombre del Titular:</strong> {{ $configuracion->nombre_titular ?? 'N/A' }}</p>
                    <p class="text-gray-700 mb-2"><strong>Tipo de Cuenta:</strong> {{ $configuracion->tipo_cuenta ?? 'N/A' }}</p>
                </div>

                {{-- Cambiamos el fondo de la sección a gris claro o blanco --}}
                <div id="qr_payment_fields" class="hidden bg-gray-50 p-4 rounded-lg shadow-inner mb-8 text-center">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Pago por Código QR') }}</h4>
                    <p class="text-gray-700 mb-4">
                        Por favor, escanea este código QR para realizar el pago y sube el comprobante.
                    </p>
                    {{-- LÍNEA CORREGIDA: Ahora usamos la URL de la imagen del modelo $configuracion --}}
                    {{-- Si $configuracion->ruta_imagen_qr existe, la usamos, si no, usamos la imagen por defecto --}}
                    <img src="{{ $configuracion->ruta_imagen_qr ?? asset('images/QR.png') }}" alt="Código QR para pago" class="w-64 h-64 mx-auto rounded-lg shadow-lg">
                </div>
                
                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">{{ __('Productos en tu Pedido') }}</h4>
                    <ul>
                        @foreach($pedido->detalles as $detalle)
                            <li class="mb-2">
                                <span class="font-bold">{{ $detalle->cantidad }}x {{ $detalle->producto->nombre }}</span> - ${{ number_format($detalle->subtotal, 2) }}
                                @if ($detalle->ingredientes_adicionales)
                                    <ul class="ml-4 list-disc list-inside text-gray-600">
                                        @foreach($detalle->ingredientes_adicionales as $ingrediente)
                                            <li>+ {{ $ingrediente['nombre'] }} (${{ number_format($ingrediente['precio'], 2) }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Subir Comprobante de Pago y Detalles de Entrega') }}</h3>
                <p class="text-gray-700 mb-4">Por favor, sube una imagen (JPG, PNG, GIF, SVG) o PDF de tu comprobante de pago.</p>

                <form action="{{ route('checkout.upload_proof', $pedido->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="metodo_pago" id="selected_payment_method" value="bank_transfer">

                    <div class="mb-4">
                        <label for="tipo_entrega" class="block text-sm font-medium text-gray-700">Tipo de Entrega</label>
                        {{-- Aseguramos que los selectores y sus textos se vean bien --}}
                        <select name="tipo_entrega" id="tipo_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900 bg-white" onchange="toggleDeliveryFields()">
                            <option value="recoger_local" {{ old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'recoger_local' ? 'selected' : '' }}>Recoger en Local</option>
                            <option value="domicilio" {{ old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'domicilio' ? 'selected' : '' }}>Envío a Domicilio</option>
                        </select>
                        @error('tipo_entrega')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="delivery_fields" class="{{ old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'domicilio' ? '' : 'hidden' }}">
                        <div class="mb-4">
                            <label for="direccion_entrega" class="block text-sm font-medium text-gray-700">Dirección de Entrega</label>
                            <input type="text" name="direccion_entrega" id="direccion_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900 bg-white" value="{{ old('direccion_entrega', $pedido->direccion_entrega ?? '') }}">
                            @error('direccion_entrega')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="telefono_contacto" class="block text-sm font-medium text-gray-700">Teléfono de Contacto</label>
                            <input type="text" name="telefono_contacto" id="telefono_contacto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900 bg-white" value="{{ old('telefono_contacto', $pedido->telefono_contacto ?? '') }}">
                            @error('telefono_contacto')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="proof_image" class="block text-sm font-medium text-gray-700">Seleccionar Comprobante:</label>
                        {{-- Aseguramos que el color del input de archivo se vea bien --}}
                        <input type="file" name="proof_image" id="proof_image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none">
                        @error('proof_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        {{-- Botón "Subir Comprobante" ahora es amarillo con texto oscuro. --}}
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-md shadow-md hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Subir Comprobante y Guardar Detalles') }}
                        </button>
                        {{-- Botón "Ir a Mis Pedidos" ahora es amarillo con texto oscuro. --}}
                        <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-md shadow-md hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
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

        function togglePaymentFields() {
            const bankTransferFields = document.getElementById('bank_transfer_fields');
            const qrPaymentFields = document.getElementById('qr_payment_fields');
            const selectedPaymentMethodInput = document.getElementById('selected_payment_method');

            if (document.getElementById('bank_transfer').checked) {
                bankTransferFields.classList.remove('hidden');
                qrPaymentFields.classList.add('hidden');
                selectedPaymentMethodInput.value = 'bank_transfer';
            } else {
                bankTransferFields.classList.add('hidden');
                qrPaymentFields.classList.remove('hidden');
                selectedPaymentMethodInput.value = 'qr_payment';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleDeliveryFields();
            togglePaymentFields();
        });
    </script>
</x-app-layout>

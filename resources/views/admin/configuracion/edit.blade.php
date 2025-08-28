<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-200 leading-tight" style="color: black;">
            {{ __('Configuración del Establecimiento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Botón de "Volver a inicio" --}}
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-yellow-500 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Volver a inicio') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Mensaje de éxito si existe en la sesión --}}
                    @if (session('status'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.configuracion.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- SECCIÓN: SELECCIÓN DEL MÉTODO DE PAGO -->
                        <div class="space-y-4 mb-8">
                            <h3 class="text-xl font-bold text-gray-900">Seleccionar Método de Pago</h3>
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ (old('payment_method', $configuracion->metodo_pago ?? 'bank_transfer') == 'bank_transfer') ? 'checked' : '' }}>
                                    <label for="bank_transfer" class="ml-2 text-sm font-medium text-gray-700">Transferencia Bancaria</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="qr_payment" name="payment_method" value="qr_payment" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ (old('payment_method', $configuracion->metodo_pago ?? '') == 'qr_payment') ? 'checked' : '' }}>
                                    <label for="qr_payment" class="ml-2 text-sm font-medium text-gray-700">Código QR</label>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN: FORMULARIO PARA TRANSFERENCIA BANCARIA -->
                        <div id="bank_transfer_section" class="space-y-6">
                            <h3 class="text-xl font-bold text-gray-900">Datos de la Cuenta Bancaria y Contacto</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Banco --}}
                                <div>
                                    <x-input-label for="banco" :value="__('Banco')" />
                                    <x-text-input id="banco" name="banco" type="text" class="mt-1 block w-full text-gray-900" :value="old('banco', $configuracion->banco ?? '')" required autofocus autocomplete="banco" />
                                    <x-input-error class="mt-2" :messages="$errors->get('banco')" />
                                </div>

                                {{-- Número de Cuenta --}}
                                <div>
                                    <x-input-label for="numero_cuenta" :value="__('Número de Cuenta')" />
                                    <x-text-input id="numero_cuenta" name="numero_cuenta" type="text" class="mt-1 block w-full text-gray-900" :value="old('numero_cuenta', $configuracion->numero_cuenta ?? '')" required autocomplete="numero_cuenta" />
                                    <x-input-error class="mt-2" :messages="$errors->get('numero_cuenta')" />
                                </div>

                                {{-- Nombre del Titular --}}
                                <div>
                                    <x-input-label for="nombre_titular" :value="__('Nombre del Titular')" />
                                    <x-text-input id="nombre_titular" name="nombre_titular" type="text" class="mt-1 block w-full text-gray-900" :value="old('nombre_titular', $configuracion->nombre_titular ?? '')" required autocomplete="nombre_titular" />
                                    <x-input-error class="mt-2" :messages="$errors->get('nombre_titular')" />
                                </div>

                                {{-- Tipo de Cuenta --}}
                                <div>
                                    <x-input-label for="tipo_cuenta" :value="__('Tipo de Cuenta')" />
                                    <x-text-input id="tipo_cuenta" name="tipo_cuenta" type="text" class="mt-1 block w-full text-gray-900" :value="old('tipo_cuenta', $configuracion->tipo_cuenta ?? '')" autocomplete="tipo_cuenta" />
                                    <x-input-error class="mt-2" :messages="$errors->get('tipo_cuenta')" />
                                </div>
                                
                                {{-- Número de Contacto del Establecimiento --}}
                                <div>
                                    <x-input-label for="numero_contacto" :value="__('Número de Contacto del Establecimiento')" />
                                    <x-text-input id="numero_contacto" name="numero_contacto" type="text" class="mt-1 block w-full text-gray-900" :value="old('numero_contacto', $configuracion->numero_contacto ?? '')" required autocomplete="numero_contacto" />
                                    <x-input-error class="mt-2" :messages="$errors->get('numero_contacto')" />
                                </div>

                            </div>
                        </div>

                        <!-- SECCIÓN: PAGO POR CÓDIGO QR -->
                        <div id="qr_payment_section" class="mt-8 space-y-6 hidden">
                            <h3 class="text-xl font-bold text-gray-900">Pago por Código QR</h3>
                            <div class="flex flex-col items-center justify-center">
                                <p class="text-sm text-gray-600 mb-4">
                                    Escanee este código QR para realizar el pago.
                                </p>
                                {{-- Aumentamos el tamaño de la imagen del QR para que sea más fácil de escanear en móviles --}}
                                <img src="{{ asset('images/QR.png') }}" alt="Código QR para pago" class="w-80 h-80 rounded-lg shadow-lg">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('GUARDAR CAMBIOS') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT PARA MOSTRAR/OCULTAR SECCIONES -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankTransferRadio = document.getElementById('bank_transfer');
            const qrPaymentRadio = document.getElementById('qr_payment');
            const bankTransferSection = document.getElementById('bank_transfer_section');
            const qrPaymentSection = document.getElementById('qr_payment_section');

            function toggleSections() {
                if (bankTransferRadio.checked) {
                    bankTransferSection.classList.remove('hidden');
                    qrPaymentSection.classList.add('hidden');
                } else if (qrPaymentRadio.checked) {
                    bankTransferSection.classList.add('hidden');
                    qrPaymentSection.classList.remove('hidden');
                }
            }

            // Ocultar la sección del QR al cargar la página si el radio button de transferencia está seleccionado por defecto
            if (bankTransferRadio.checked) {
                qrPaymentSection.classList.add('hidden');
            } else {
                bankTransferSection.classList.add('hidden');
            }

            // Añadir event listeners a los radio buttons
            bankTransferRadio.addEventListener('change', toggleSections);
            qrPaymentRadio.addEventListener('change', toggleSections);
        });
    </script>
</x-app-layout>
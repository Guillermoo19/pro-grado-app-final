<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmación de Pedido y Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                @endif

                <div class="mb-8">
                    <p class="text-lg text-gray-700 mb-2"><strong>Número de Pedido:</strong> {{ $pedido->id }}</p>
                    <p class="text-lg text-gray-700 mb-2"><strong>Total a Pagar:</strong> <span class="text-green-600 font-bold text-xl">${{ number_format($pedido->total, 2) }}</span></p>
                    <p class="text-md text-gray-600">Por favor, realiza la transferencia bancaria al siguiente número de cuenta y sube el comprobante.</p>
                </div>

                <!-- Información de la Cuenta Bancaria -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Datos Bancarios para la Transferencia') }}</h4>
                    <p class="text-gray-700 mb-2"><strong>Banco:</strong> Banco Ejemplo</p>
                    <p class="text-gray-700 mb-2"><strong>Número de Cuenta:</strong> 123-456789-0</p>
                    <p class="text-gray-700 mb-2"><strong>Nombre del Titular:</strong> Tu Empresa S.A.</p>
                    <p class="text-gray-700 mb-2"><strong>Tipo de Cuenta:</strong> Ahorros</p>
                    <p class="text-gray-700 mb-2"><strong>RUC/NIT:</strong> 1234567890001</p>
                </div>

                <!-- Formulario de Subida de Comprobante -->
                <div class="p-6 border border-gray-200 rounded-lg shadow-sm">
                    <h4 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Subir Comprobante de Pago') }}</h4>

                    @if ($pedido->comprobante_imagen_url)
                        <div class="mb-4">
                            <p class="text-gray-700">Comprobante actual subido:</p>
                            <img src="{{ asset('storage/' . $pedido->comprobante_imagen_url) }}" alt="Comprobante de Pago" class="w-64 h-auto rounded-lg shadow-md mt-2">
                            <p class="text-sm text-gray-500 mt-1">Estado del pago: <span class="font-bold">{{ ucfirst($pedido->estado_pago) }}</span></p>
                        </div>
                        @if ($pedido->estado_pago === 'subido' || $pedido->estado_pago === 'verificado')
                            <p class="text-green-600 font-semibold mb-4">El comprobante ya ha sido subido y está en revisión o verificado.</p>
                        @else
                            <p class="text-orange-600 font-semibold mb-4">Puedes subir un nuevo comprobante si el anterior fue rechazado o si necesitas actualizarlo.</p>
                        @endif
                    @else
                        <p class="text-gray-600 mb-4">Por favor, sube una imagen (JPG, PNG, GIF, SVG) de tu comprobante de transferencia.</p>
                    @endif

                    <form action="{{ route('checkout.upload_proof', $pedido->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="comprobante" class="block text-sm font-medium text-gray-700">Seleccionar Comprobante:</label>
                            <input type="file" name="comprobante" id="comprobante" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100"/>
                            @error('comprobante')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Subir Comprobante
                        </button>
                    </form>
                </div>

                <!-- Botón para ver mis pedidos -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ir a Mis Pedidos
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

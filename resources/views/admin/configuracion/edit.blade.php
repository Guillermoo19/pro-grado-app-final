<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuración del Establecimiento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Botón de "Volver a inicio" --}}
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Volver a inicio') }}
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Mensaje de éxito si existe en la sesión --}}
                    @if (session('status'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.configuracion.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <h3 class="text-xl font-bold dark:text-white">Datos de la Cuenta Bancaria y Contacto</h3>
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
</x-app-layout>

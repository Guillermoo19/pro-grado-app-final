{{-- resources/views/categorias/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Crear Nueva Categoría</h3>

                    {{-- CORREGIDO: action="{{ route('admin.categorias.store') }}" --}}
                    <form action="{{ route('admin.categorias.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="nombre" :value="__('Nombre de la Categoría')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            {{-- Usando el componente x-text-area --}}
                            <x-text-area id="descripcion" class="block mt-1 w-full" name="descripcion">{{ old('descripcion') }}</x-text-area>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            {{-- CORREGIDO: href="{{ route('admin.categorias.index') }}" --}}
                            <a href="{{ route('admin.categorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ml-3 bg-chamos-amarillo text-chamos-marron-oscuro hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:ring-chamos-amarillo">
                                {{ __('Guardar Categoría') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

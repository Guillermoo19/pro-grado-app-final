{{-- resources/views/roles/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Rol: ') . $role->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre del Rol')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $role->nombre)" required autofocus autocomplete="nombre" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ml-3 bg-blue-200 text-black hover:bg-blue-300 focus:bg-blue-300 active:bg-blue-400 focus:ring-blue-200">
                                {{ __('Actualizar Rol') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
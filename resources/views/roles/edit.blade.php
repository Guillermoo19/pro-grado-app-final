<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Rol') . ': ' . $role->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Contenido original de tu formulario de edición de Roles --}}
                    <h1>Editar Rol: {{ $role->nombre }}</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Importante para las actualizaciones --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $role->nombre) }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Actualizar Rol</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                    {{-- FIN del contenido original del formulario --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
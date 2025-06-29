<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Listado de Roles</h3>
                        {{-- Botón Crear Nuevo Rol: Amarillo con letras café --}}
                        <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-xs text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-chamos-amarillo focus:ring-offset-2 transition ease-in-out duration-150">
                            Crear Nuevo Rol
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-chamos-marron-claro">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($roles as $role)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            {{-- Botón Editar: Azul pálido con texto negro --}}
                                            <a href="{{ route('roles.edit', $role->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-blue-300 focus:bg-blue-300 active:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">Editar</a>
                                            {{-- Botón Eliminar: Rojo con texto blanco --}}
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este rol?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Botón para volver al dashboard principal --}}
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Volver a inicio') }}
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Categorías') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Lista de Categorías') }}</h3>

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

                    <div class="mb-4">
                        <a href="{{ route('admin.categorias.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Crear Nueva Categoría') }}
                        </a>
                    </div>

                    @if ($categorias->isEmpty())
                        <p class="text-gray-600">{{ __('No hay categorías registradas en el sistema.') }}</p>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">{{ __('ID') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Nombre') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Descripción') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorias as $categoria)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $categoria->id }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $categoria->nombre }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $categoria->descripcion ?? 'N/A' }}
                                            </td>
                                            <td class="py-4 px-6 flex items-center space-x-2">
                                                <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="font-medium text-blue-600 hover:underline">
                                                    {{ __('Editar') }}
                                                </a>
                                                <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría? Esta acción es irreversible y afectará a los productos asociados.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:underline ml-2">
                                                        {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

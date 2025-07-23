<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Lista de Usuarios') }}</h3>

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

                    @if ($users->isEmpty())
                        <p class="text-gray-600">{{ __('No hay usuarios registrados en el sistema.') }}</p>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">{{ __('ID') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Nombre') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Email') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Teléfono') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Rol') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $user->id }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $user->name }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $user->email }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $user->phone_number ?? 'N/A' }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if ($user->isAdmin()) bg-indigo-100 text-indigo-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $user->role->name ?? 'N/A' }} {{-- <-- ¡IMPORTANTE! Cambiado a $user->role->name --}}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 flex items-center space-x-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="font-medium text-blue-600 hover:underline">
                                                    {{ __('Editar') }}
                                                </a>
                                                @if (Auth::user()->id !== $user->id && (! $user->isSuperAdmin() || Auth::user()->isSuperAdmin()))
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-red-600 hover:underline ml-2">
                                                            {{ __('Eliminar') }}
                                                        </button>
                                                    </form>
                                                @endif
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

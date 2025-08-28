{{--
    Este es el archivo principal para la gestión de usuarios en el panel de administración.
    Utiliza la plantilla 'app' de Laravel, la cual define el layout general de la página.
--}}
<x-app-layout>
    <x-slot name="header">
        {{-- Contenedor para el título y el botón, con el título ahora encima del botón --}}
        <div class="flex flex-col items-start justify-between">
            {{-- Título de la página, ahora en color negro --}}
            <h2 class="font-semibold text-xl text-black leading-tight mb-2">
                {{ __('Gestión de Usuarios') }}
            </h2>
            {{-- Botón de "Volver a inicio" --}}
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Volver a inicio') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                {{-- El título y el botón ya están en el header, esta parte se puede eliminar o dejar vacía --}}
            </div>

            {{-- CAMBIO PRINCIPAL: Fondo de todo el contenido a blanco --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Texto principal en un color oscuro --}}
                <div class="p-6 text-gray-900">
                    {{-- Mensaje de éxito si existe en la sesión --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                             role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{--
                        SECCIÓN PARA ADMINISTRADORES
                    --}}
                    <div class="mb-8">
                        {{-- Título de la sección --}}
                        <h3 class="text-xl font-bold mb-4">{{ __('Administradores') }}</h3>
                        @if($admins->isEmpty())
                            <p class="text-gray-500">{{ __('No hay administradores registrados.') }}</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-300">
                                    {{-- Cabecera de la tabla con un fondo gris claro --}}
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Teléfono</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rol</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    {{-- El cuerpo de la tabla se mantiene con un fondo blanco y texto oscuro --}}
                                    <tbody class="bg-white divide-y divide-gray-300">
                                        @foreach ($admins as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone_number ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{-- Rol de admin en un color que contrasta --}}
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-300 text-gray-800">
                                                        {{ optional($user->role)->nombre ?? 'Sin Rol' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end space-x-2">
                                                    {{-- Botón de Editar con el nuevo estilo --}}
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="text-black px-3 py-1 text-center font-medium rounded-lg bg-blue-300 hover:bg-blue-400">EDITAR</a>

                                                    @if (Auth::user()->id !== $user->id)
                                                        {{-- Botón de "Quitar Administración" en color azul oscuro --}}
                                                        <form action="{{ route('admin.users.demote', $user) }}" method="POST"
                                                            class="inline-block"
                                                            onsubmit="event.preventDefault(); showConfirmModal(this, '¿Estás seguro de que quieres quitarle el rol de administrador a este usuario?');">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="text-white px-3 py-1 text-center font-medium rounded-lg bg-indigo-700 hover:bg-indigo-800">Quitar Administración</button>
                                                        </form>

                                                        {{-- Formulario de Eliminar con estilo de la imagen --}}
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                            class="inline-block"
                                                            onsubmit="event.preventDefault(); showConfirmModal(this, '¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white px-3 py-1 text-center font-medium rounded-lg bg-red-600 hover:bg-red-700">Eliminar</button>
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

                    {{--
                        SECCIÓN PARA OTROS ROLES
                    --}}
                    @if($otherRoles->isNotEmpty())
                        <div class="mb-8">
                            {{-- Título de la sección --}}
                            <h3 class="text-xl font-bold mb-4 text-yellow-600">{{ __('Otros Roles (Personal)') }}</h3>
                            <p class="text-sm text-yellow-700 mb-2">
                                {{ __('Usuarios con roles distintos a Administrador o Cliente (ej. Chef, Cajero).') }}
                            </p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-300">
                                    {{-- Cabecera de la tabla con un fondo gris claro --}}
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Teléfono</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rol</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    {{-- El cuerpo de la tabla se mantiene con un fondo blanco y texto oscuro --}}
                                    <tbody class="bg-white divide-y divide-gray-300">
                                        @foreach ($otherRoles as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone_number ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-300 text-black">
                                                        {{ optional($user->role)->nombre ?? 'Sin Rol' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end space-x-2">
                                                    {{-- Botón de "Asignar Rol" ahora es de color verde --}}
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="text-white px-3 py-1 text-center font-medium rounded-lg bg-green-500 hover:bg-green-600">Asignar Rol</a>
                                                    @if (Auth::user()->id !== $user->id)
                                                        {{-- Botón de Eliminar con estilo de la imagen --}}
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                            class="inline-block"
                                                            onsubmit="event.preventDefault(); showConfirmModal(this, '¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white px-3 py-1 text-center font-medium rounded-lg bg-red-600 hover:bg-red-700">Eliminar</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{--
                        SECCIÓN PARA USUARIOS SIN ROL
                    --}}
                    @if($noRoleUsers->isNotEmpty())
                        <div class="mb-8">
                            {{-- Título de la sección --}}
                            <h3 class="text-xl font-bold mb-4 text-red-600">{{ __('Usuarios Sin Rol') }}</h3>
                            <p class="text-sm text-red-700 mb-2">
                                {{ __('Estos usuarios aún no tienen un rol asignado y necesitan ser gestionados.') }}
                            </p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-300">
                                    {{-- Cabecera de la tabla con un fondo gris claro --}}
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Teléfono</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rol</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    {{-- El cuerpo de la tabla se mantiene con un fondo blanco y texto oscuro --}}
                                    <tbody class="bg-white divide-y divide-gray-300">
                                        @foreach ($noRoleUsers as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone_number ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-300 text-black">
                                                        {{ optional($user->role)->nombre ?? 'Sin Rol' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end space-x-2">
                                                    {{-- Botón de "Asignar Rol" ahora es de color verde --}}
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="text-white px-3 py-1 text-center font-medium rounded-lg bg-green-500 hover:bg-green-600">Asignar Rol</a>
                                                    @if (Auth::user()->id !== $user->id)
                                                        {{-- Botón de Eliminar con estilo de la imagen --}}
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                            class="inline-block"
                                                            onsubmit="event.preventDefault(); showConfirmModal(this, '¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white px-3 py-1 text-center font-medium rounded-lg bg-red-600 hover:bg-red-700">Eliminar</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 py-6 text-center">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                {{-- Fondo gris claro --}}
                <div class="absolute inset-0 bg-gray-200 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- El modal ahora tiene un fondo blanco --}}
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Confirmación
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600" id="modal-message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Los botones del modal ahora tienen fondos blancos y grises --}}
                <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="confirm-button" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmar
                    </button>
                    {{-- Botón de cancelar ahora es blanco con texto oscuro --}}
                    <button id="cancel-button" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts para el modal de confirmación --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentForm;

            window.showConfirmModal = function(form, message) {
                currentForm = form;
                document.getElementById('modal-message').innerText = message;
                document.getElementById('confirmModal').classList.remove('hidden');
            }

            function closeConfirmModal() {
                document.getElementById('confirmModal').classList.add('hidden');
            }

            document.getElementById('confirm-button').addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
                closeConfirmModal();
            });

            document.getElementById('cancel-button').addEventListener('click', closeConfirmModal);
        });
    </script>
</x-app-layout>

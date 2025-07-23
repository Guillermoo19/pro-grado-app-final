<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Editar Usuario:') }} {{ $user->name }}</h3>

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

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número de Teléfono -->
                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">{{ __('Número de Teléfono') }}</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('phone_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rol (Solo visible y editable por el Super Admin) -->
                        @if (Auth::user()->isSuperAdmin() && Auth::id() !== $user->id) {{-- El super admin no puede cambiar su propio rol aquí --}}
                            <div class="mb-4">
                                <label for="role_id" class="block text-sm font-medium text-gray-700">{{ __('Rol') }}</label>
                                <select name="role_id" id="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    {{-- Asumiendo que tienes los roles 'admin' con ID 1 y 'client' con ID 2 --}}
                                    <option value="2" {{ old('role_id', $user->role_id) == '2' ? 'selected' : '' }}>Cliente</option>
                                    <option value="1" {{ old('role_id', $user->role_id) == '1' ? 'selected' : '' }}>Administrador</option>
                                    {{-- Puedes añadir más opciones si tienes otros roles (ej. chef) --}}
                                    @if ($user->role_id == 5) {{-- Si el rol actual es 'chef' --}}
                                        <option value="5" selected>Chef</option>
                                    @endif
                                </select>
                                @error('role_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif (Auth::user()->isSuperAdmin() && Auth::id() === $user->id)
                            <div class="mb-4">
                                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Rol') }}</label>
                                <input type="text" value="Administrador General" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed" disabled>
                                <p class="text-sm text-gray-500 mt-1">No puedes cambiar tu propio rol de Administrador General.</p>
                            </div>
                        @else {{-- Si no es super admin, solo muestra el rol actual --}}
                            <div class="mb-4">
                                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Rol') }}</label>
                                <input type="text" value="{{ $user->role->name ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed" disabled>
                                <p class="text-sm text-gray-500 mt-1">Solo el administrador general puede cambiar roles.</p>
                            </div>
                        @endif


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-chamos-verde border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Guardar Cambios') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

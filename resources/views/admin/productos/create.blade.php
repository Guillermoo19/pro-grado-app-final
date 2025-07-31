    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Nuevo Producto') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">{{ __('Formulario de Nuevo Producto') }}</h3>

                        <form method="POST" action="{{ route('admin.productos.store') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <label for="nombre" class="block font-medium text-sm text-gray-700">{{ __('Nombre del Producto') }} <span class="text-red-500">*</span></label>
                                <input id="nombre" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus />
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="descripcion" class="block font-medium text-sm text-gray-700">{{ __('Descripción del Producto') }}</label>
                                <textarea id="descripcion" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="descripcion">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="precio" class="block font-medium text-sm text-gray-700">{{ __('Precio') }} <span class="text-red-500">*</span></label>
                                <input id="precio" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" step="0.01" min="0" name="precio" value="{{ old('precio') }}" required />
                                @error('precio')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock" class="block font-medium text-sm text-gray-700">{{ __('Stock') }} <span class="text-red-500">*</span></label>
                                <input id="stock" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" min="0" name="stock" value="{{ old('stock', 1) }}" required />
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="categoria_id" class="block font-medium text-sm text-gray-700">{{ __('Categoría') }} <span class="text-red-500">*</span></label>
                                <select id="categoria_id" name="categoria_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">{{ __('Selecciona una categoría') }}</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="imagen" class="block font-medium text-sm text-gray-700">{{ __('Imagen del Producto') }} <span class="text-red-500">*</span></label>
                                <input id="imagen" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="imagen" required />
                                @error('imagen')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ingredientes" class="block font-medium text-sm text-gray-700">{{ __('Ingredientes (Opcional)') }}</label>
                                <select id="ingredientes" name="ingredientes[]" multiple class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-48">
                                    @foreach ($ingredientes as $ingrediente)
                                        <option value="{{ $ingrediente->id }}" {{ in_array($ingrediente->id, old('ingredientes', [])) ? 'selected' : '' }}>
                                            {{ $ingrediente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ingredientes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Guardar Producto') }}
                                </button>
                                <a href="{{ route('admin.productos.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
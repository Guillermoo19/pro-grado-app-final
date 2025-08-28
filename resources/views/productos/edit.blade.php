<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Producto: {{ $producto->nombre }}</h3>

                    <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Campo Nombre --}}
                        <div class="mb-4">
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $producto->nombre)" required autofocus />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        {{-- Campo Descripción --}}
                        <div class="mb-4">
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('descripcion', $producto->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        {{-- Campo Precio --}}
                        <div class="mb-4">
                            <x-input-label for="precio" :value="__('Precio')" />
                            <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio', $producto->precio)" required />
                            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                        </div>

                        {{-- CAMBIO AQUÍ: Campo Disponibilidad (antes Stock) --}}
                        <div class="mb-4">
                            <x-input-label for="stock" :value="__('Disponibilidad (Cantidad)')" /> {{-- Etiqueta cambiada --}}
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $producto->stock)" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        {{-- Campo Categoría --}}
                        <div class="mb-4">
                            <x-input-label for="categoria_id" :value="__('Categoría')" />
                            <select id="categoria_id" name="categoria_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Selecciona una Categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                        </div>

                        {{-- Campo Imagen del Producto --}}
                        <div class="mb-4">
                            <x-input-label for="imagen" :value="__('Imagen del Producto')" />
                            @if ($producto->imagen)
                                <div class="mt-2 mb-2">
                                    <p>Imagen actual:</p>
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen actual del producto" class="w-32 h-32 object-cover rounded-md shadow-sm">
                                </div>
                            @endif
                            <input id="imagen" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="imagen" />
                            <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF o SVG (Máx. 2MB). Deja vacío para mantener la imagen actual.</p>
                            <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Actualizar Producto') }}
                            </x-primary-button>
                            <a href="{{ route('admin.productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
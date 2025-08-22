<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control del Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-2">
                        Bienvenido al panel de control {{ Auth::user()->name }}.
                    </h1>
                    <!-- Texto actualizado según la solicitud del usuario -->
                    <p class="mt-4 text-gray-600">
                        Gestión de las áreas de administración (Crear, Leer, Actualizar, Borrar).
                    </p>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('admin.roles.index') }}" class="block p-4 bg-blue-100 rounded-lg shadow hover:bg-blue-200 transition">
                            <h4 class="font-semibold text-lg text-blue-800">Gestionar Roles</h4>
                            <p class="text-sm text-blue-600">Asignar y editar roles de usuario.</p>
                        </a>
                        <a href="{{ route('admin.categorias.index') }}" class="block p-4 bg-green-100 rounded-lg shadow hover:bg-green-200 transition">
                            <h4 class="font-semibold text-lg text-green-800">Gestionar Categorías</h4>
                            <p class="text-sm text-green-600">Administrar categorías de productos.</p>
                        </a>
                        <a href="{{ route('admin.productos.index') }}" class="block p-4 bg-yellow-100 rounded-lg shadow hover:bg-yellow-200 transition">
                            <h4 class="font-semibold text-lg text-yellow-800">Gestionar Productos</h4>
                            <p class="text-sm text-yellow-600">Añadir, editar y eliminar productos.</p>
                        </a>
                        <a href="{{ route('admin.pedidos.index') }}" class="block p-4 bg-purple-100 rounded-lg shadow hover:bg-purple-200 transition">
                            <h4 class="font-semibold text-lg text-purple-800">Gestionar Pedidos</h4>
                            <p class="text-sm text-purple-600">Revisar y actualizar el estado de los pedidos.</p>
                        </a>
                        {{-- AÑADIDO: Enlace para Gestionar Usuarios --}}
                        <a href="{{ route('admin.users.index') }}" class="block p-4 bg-orange-100 rounded-lg shadow hover:bg-orange-200 transition">
                            <h4 class="font-semibold text-lg text-orange-800">Gestionar Usuarios</h4>
                            <p class="text-sm text-orange-600">Administrar usuarios y sus roles.</p>
                        </a>
                        {{-- AÑADIDO: Enlace para Gestionar Ingredientes --}}
                        <a href="{{ route('admin.ingredientes.index') }}" class="block p-4 bg-pink-100 rounded-lg shadow hover:bg-pink-200 transition">
                            <h4 class="font-semibold text-lg text-pink-800">Gestionar Ingredientes</h4>
                            <p class="text-sm text-pink-600">Administrar los ingredientes disponibles.</p>
                        </a>
                        {{-- AÑADIDO: Enlace para Gestionar Configuración (ruta corregida) --}}
                        <a href="{{ route('admin.configuracion.edit') }}" class="block p-4 bg-teal-100 rounded-lg shadow hover:bg-teal-200 transition">
                            <h4 class="font-semibold text-lg text-teal-800">Configuración</h4>
                            <p class="text-sm text-teal-600">Ajustes generales de la aplicación.</p>
                        </a>
                        {{-- Añade más enlaces de administración aquí si tienes más secciones --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

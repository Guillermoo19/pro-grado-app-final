<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("¡Bienvenido al Dashboard de Administración!") }}
                    <p class="mt-4">Aquí podrás gestionar usuarios, productos, categorías y pedidos.</p>
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
                        {{-- Añade más enlaces de administración aquí si tienes más secciones --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

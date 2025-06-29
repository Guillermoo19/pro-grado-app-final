<nav x-data="{ open: false }" class="bg-chamos-marron-oscuro border-b border-chamos-marron-claro">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-chamos-amarillo" />
                    </a>
                </div>

                <!-- Navigation Links (Hidden on small screens) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                        {{ __('Mis Pedidos') }}
                    </x-nav-link>

                    <x-nav-link :href="route('productos.catalogo')" :active="request()->routeIs('productos.catalogo')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                        {{ __('Catálogo') }}
                    </x-nav-link>

                    <x-nav-link :href="route('carrito.index')" :active="request()->routeIs('carrito.index')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                        {{ __('Carrito') }}
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="ml-1 px-2 py-1 text-xs font-bold text-chamos-marron-oscuro bg-chamos-amarillo rounded-full">{{ $cartCount }}</span>
                        @endif
                    </x-nav-link>
                    
                    {{-- ************************************************ --}}
                    {{-- ¡NUEVO ENLACE! Gestión de Pedidos (Solo Admin) --}}
                    {{-- ************************************************ --}}
                    @can('viewAll', App\Models\Pedido::class)
                        <x-nav-link :href="route('pedidos.admin_index')" :active="request()->routeIs('pedidos.admin_index')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                            {{ __('Gestión de Pedidos') }}
                        </x-nav-link>
                    @endcan
                    {{-- ************************************************ --}}

                    @can('viewAny', App\Models\Role::class)
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                            {{ __('Roles') }}
                        </x-nav-link>
                    @endcan

                    @can('viewAny', App\Models\Categoria::class)
                        <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                            {{ __('Categorías') }}
                        </x-nav-link>
                    @endcan

                    @can('viewAny', App\Models\Producto::class)
                        <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                            {{ __('Productos (Admin)') }}
                        </x-nav-link>
                    @endcan

                    @can('viewAny', App\Models\Ingrediente::class)
                        <x-nav-link :href="route('ingredientes.index')" :active="request()->routeIs('ingredientes.*')" class="text-chamos-amarillo hover:text-white focus:border-chamos-amarillo active:border-chamos-amarillo">
                            {{ __('Ingredientes') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown / Public links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    {{-- Enlaces para usuarios NO autenticados (Login, Register, Carrito) --}}
                    <a href="{{ route('productos.catalogo') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 text-sm font-medium rounded-md">
                        {{ __('Catálogo') }}
                    </a>
                    <a href="{{ route('carrito.index') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 text-sm font-medium rounded-md">
                        {{ __('Carrito') }}
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="ml-1 px-2 py-1 text-xs font-bold text-chamos-marron-oscuro bg-chamos-amarillo rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('login') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 text-sm font-medium rounded-md">
                        {{ __('Iniciar Sesión') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-chamos-amarillo hover:text-white px-3 py-2 text-sm font-medium rounded-md">
                        {{ __('Registrarse') }}
                    </a>
                @else
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-chamos-amarillo bg-chamos-marron-oscuro hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Fondo del menú desplegable de usuario: siempre blanco, texto gris oscuro --}}
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Perfil') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endguest
            </div>

            <!-- Hamburger (for responsive menu) -->
            <div class="-ms-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-chamos-amarillo hover:text-white hover:bg-chamos-marron-claro focus:outline-none focus:bg-chamos-marron-claro focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-chamos-marron-oscuro"> {{-- Fondo del menú responsive --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-chamos-amarillo hover:text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')" class="text-chamos-amarillo hover:text-white">
                {{ __('Mis Pedidos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('productos.catalogo')" :active="request()->routeIs('productos.catalogo')" class="text-chamos-amarillo hover:text-white">
                {{ __('Catálogo') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('carrito.index')" :active="request()->routeIs('carrito.index')" class="text-chamos-amarillo hover:text-white">
                {{ __('Carrito') }}
                @php
                    $cartCount = count(session()->get('cart', []));
                @endphp
                @if($cartCount > 0)
                    <span class="ml-1 px-2 py-1 text-xs font-bold text-chamos-marron-oscuro bg-chamos-amarillo rounded-full">{{ $cartCount }}</span>
                @endif
            </x-responsive-nav-link>

            {{-- ************************************************ --}}
            {{-- ¡NUEVO ENLACE RESPONSIVE! Gestión de Pedidos (Solo Admin) --}}
            {{-- ************************************************ --}}
            @can('viewAll', App\Models\Pedido::class)
                <x-responsive-nav-link :href="route('pedidos.admin_index')" :active="request()->routeIs('pedidos.admin_index')" class="text-chamos-amarillo hover:text-white">
                    {{ __('Gestión de Pedidos') }}
                </x-responsive-nav-link>
            @endcan
            {{-- ************************************************ --}}

            @can('viewAny', App\Models\Role::class)
                <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="text-chamos-amarillo hover:text-white">
                    {{ __('Roles') }}
                </x-responsive-nav-link>
            @endcan

            @can('viewAny', App\Models\Categoria::class)
                <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" class="text-chamos-amarillo hover:text-white">
                    {{ __('Categorías') }}
                </x-responsive-nav-link>
            @endcan

            @can('viewAny', App\Models\Producto::class)
                <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" class="text-chamos-amarillo hover:text-white">
                    {{ __('Productos (Admin)') }}
                </x-responsive-nav-link>
            @endcan

            @can('viewAny', App\Models\Ingrediente::class)
                <x-responsive-nav-link :href="route('ingredientes.index')" :active="request()->routeIs('ingredientes.*')" class="text-chamos-amarillo hover:text-white">
                    {{ __('Ingredientes') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bg-chamos-marron-oscuro"> {{-- Fondo del menú de perfil responsive --}}
            <div class="px-4">
                <div class="font-medium text-base text-chamos-amarillo">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-chamos-beige">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-chamos-amarillo hover:text-white">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-chamos-amarillo hover:text-white">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

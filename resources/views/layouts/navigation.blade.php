<nav x-data="{ open: false }" style="background-color: #702c0c;" class="dark:bg-gray-800 border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/chamo-logo2.png') }}" alt="Los Chamos Logo" class="block h-20 w-auto fill-current text-chamos-marron-oscuro dark:text-gray-200">
                    </a>
                </div>

                <!-- Navigation Links - Ahora para usuarios que no son administradores -->
                {{-- Se añade una directiva @unless para ocultar estos enlaces si el usuario es admin --}}
                @auth
                    @unless (Auth::user()->isAdmin())
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="text-white hover:text-chamos-cafe">
                                {{ __('Menú') }}
                            </x-nav-link>
                            <x-nav-link :href="route('carrito.index')" :active="request()->routeIs('carrito.index')" class="text-white hover:text-chamos-cafe">
                                {{ __('Carrito') }}
                            </x-nav-link>
                            <x-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.index')" class="text-white hover:text-chamos-cafe">
                                {{ __('Mis Pedidos') }}
                            </x-nav-link>
                        </div>
                    @endunless
                @else
                    {{-- Si no está autenticado, muestra los enlaces de Menú y Carrito --}}
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                         <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="text-white hover:text-chamos-cafe">
                            {{ __('Menú') }}
                        </x-nav-link>
                        <x-nav-link :href="route('carrito.index')" :active="request()->routeIs('carrito.index')" class="text-white hover:text-chamos-cafe">
                            {{ __('Carrito') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth 
                    <!-- Dropdown del usuario autenticado -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <!-- Se combinan el nombre y el rol en una sola línea -->
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black dark:text-black bg-[#F9F5E6] dark:bg-[#F9F5E6] hover:text-gray-700 dark:hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <span>{{ Auth::user()->name }}</span>
                                    @if (Auth::user()->role)
                                        <!-- Se cambia el formato para que solo se vea el rol entre paréntesis y en color negro -->
                                        <span class="ms-1 text-xs text-black dark:text-black">
                                            ({{ Auth::user()->role->nombre }})
                                        </span>
                                    @endif
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 text-black dark:text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user()->isAdmin())
                                <!-- Enlaces de administración en el dropdown -->
                                <x-dropdown-link :href="route('admin.pedidos.index')">
                                    {{ __('Gestión de Pedidos') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.roles.index')">
                                    {{ __('Roles') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.categorias.index')">
                                    {{ __('Categorías') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.productos.index')">
                                    {{ __('Productos (Admin)') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.ingredientes.index')">
                                    {{ __('Ingredientes') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.users.index')">
                                    {{ __('Gestión de Usuarios') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <!-- Cierre de sesión -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else 
                    <!-- Enlaces de Login/Register si no está autenticado -->
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:text-chamos-cafe focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __('Iniciar Sesión') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-white hover:text-chamos-cafe focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __('Registrarse') }}</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Menú hamburguesa (versión móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white dark:text-gray-500 hover:text-white dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
        @auth
            @unless (Auth::user()->isAdmin())
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')">
                        {{ __('Menú') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('carrito.index')" :active="request()->routeIs('carrito.index')">
                        {{ __('Carrito') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.index')">
                        {{ __('Mis Pedidos') }}
                    </x-responsive-nav-link>
                </div>
            @endunless
        
            <!-- Opciones del menú de configuración responsivo -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if (Auth::user()->isAdmin())
                        <!-- Enlaces de administración en el dropdown responsivo -->
                        <x-responsive-nav-link :href="route('admin.pedidos.index')">
                            {{ __('Gestión de Pedidos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.roles.index')">
                            {{ __('Roles') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.categorias.index')">
                            {{ __('Categorías') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.productos.index')">
                            {{ __('Productos (Admin)') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.ingredientes.index')">
                            {{ __('Ingredientes') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.users.index')">
                            {{ __('Gestión de Usuarios') }}
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>

                    <!-- Cierre de sesión -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <!-- Enlaces para invitados responsivos -->
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Iniciar Sesión') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Registrarse') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>

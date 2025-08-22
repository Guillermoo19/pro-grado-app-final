<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('images/chamos-logo.png') }}" alt="Logo de Los Chamos" class="h-48 w-48 object-contain" />
            </a>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                {{-- Cambiamos el color de la etiqueta Email a blanco --}}
                <x-label for="email" value="{{ __('Correo electrónico') }}" class="text-white" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                {{-- Cambiamos el color de la etiqueta Password a blanco --}}
                <x-label for="password" value="{{ __('Contraseña') }}" class="text-white" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-chamos-beige">{{ __('Recordarme') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-chamos-beige hover:text-chamos-amarillo rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-chamos-amarillo" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-button class="ms-4 bg-chamos-amarillo text-chamos-marron-oscuro hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:ring-chamos-amarillo">
                    {{ __('Iniciar sesión') }}
                </x-button>
            </div>
        </form>

        {{-- ENLACE PARA REGISTRARSE --}}
        <div class="mt-4 text-center">
            <p class="text-sm text-chamos-beige">¿No tienes una cuenta?</p>
            <a class="underline text-sm text-chamos-beige hover:text-chamos-amarillo rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-chamos-amarillo" href="{{ route('register') }}">
                {{ __('Regístrate aquí') }}
            </a>
        </div>
        {{-- FIN DEL ENLACE PARA REGISTRARSE --}}
    </x-authentication-card>
</x-guest-layout>

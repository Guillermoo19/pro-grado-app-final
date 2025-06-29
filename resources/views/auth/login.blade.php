<x-guest-layout>
    {{-- Asegúrate de que x-auth-card exista y tenga estilos que permitan ver su contenido --}}
    <x-auth-card> 
        <x-slot name="logo">
            <a href="/">
                {{-- Asegura que el logo tenga un color visible (por ejemplo, gris oscuro) --}}
                <x-application-logo class="w-20 h-20 fill-current text-gray-800" /> 
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                {{-- No es necesario el dark:bg-gray-900 y dark:text-gray-100 aquí, ya que el componente text-input lo maneja --}}
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                {{-- No es necesario el dark:bg-gray-900 y dark:text-gray-100 aquí, ya que el componente text-input lo maneja --}}
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    {{-- El componente de input gestiona el dark mode para el checkbox --}}
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    {{-- Eliminamos la clase dark:text-gray-400 para asegurar el color por defecto --}}
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    {{-- Eliminamos las clases dark:text-gray-400 y dark:hover:text-gray-100 --}}
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                {{-- Botón "Log in": Colores de marca para un buen contraste --}}
                <x-primary-button class="ms-3 bg-chamos-marron-oscuro text-white hover:bg-chamos-marron-claro focus:bg-chamos-marron-claro active:bg-chamos-marron-claro focus:ring-chamos-marron-oscuro">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

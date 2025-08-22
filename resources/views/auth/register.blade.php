<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('images/chamos-logo.png') }}" alt="Logo de Los Chamos" class="h-48 w-48 object-contain" />
            </a>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                {{-- Cambiamos el texto y color de "Name" --}}
                <x-label for="name" value="{{ __('Nombre') }}" class="text-white" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                {{-- Cambiamos el texto y color de "Email" --}}
                <x-label for="email" value="{{ __('Correo electrónico') }}" class="text-white" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                {{-- Cambiamos el texto y color de "Password" --}}
                <x-label for="password" value="{{ __('Contraseña') }}" class="text-white" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                {{-- Cambiamos el texto y color de "Confirm Password" --}}
                <x-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" class="text-white" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- Cambiamos el texto de "Already registered?" --}}
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('¿Ya estás registrado?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

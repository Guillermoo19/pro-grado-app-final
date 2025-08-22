<x-guest-layout>
    <x-authentication-card>
        {{-- Agregamos la ranura para el logo --}}
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('images/chamos-logo.png') }}" alt="Logo de Los Chamos" class="h-48 w-48 object-contain" />
            </a>
        </x-slot>

        {{-- Cambiamos el color del texto para que se vea bien en el fondo oscuro --}}
        <div class="mb-4 text-sm text-chamos-beige">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                {{-- Cambiamos el color de la etiqueta "Email" --}}
                <x-input-label for="email" :value="__('Email')" class="text-chamos-beige" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- Mantenemos los colores del botón que ya habías configurado --}}
                <x-primary-button class="bg-chamos-amarillo text-chamos-marron-oscuro hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:ring-chamos-amarillo">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

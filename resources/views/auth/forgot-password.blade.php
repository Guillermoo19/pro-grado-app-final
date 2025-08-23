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
            {{ __('¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña que te permitirá elegir una nueva.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        {{-- Este es el bloque que maneja los errores, ya traducido --}}
        @if ($errors->any())
            <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                {{ __('¡Vaya! Algo salió mal.') }}
            </div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                {{-- Cambiamos el color de la etiqueta "Correo Electrónico" a blanco --}}
                <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                
                {{-- Aquí manejamos el mensaje de error específico para el correo electrónico --}}
                @error('email')
                    <div class="text-red-600 mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- Mantenemos los colores del botón que ya habías configurado --}}
                <x-primary-button class="bg-chamos-amarillo text-chamos-marron-oscuro hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:ring-chamos-amarillo">
                    {{ __('ENVIAR ENLACE PARA RESTABLECER CONTRASEÑA') }}
                </x-primary-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

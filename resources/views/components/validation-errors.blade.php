{{-- Este componente muestra los errores de validación si existen. --}}
@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'font-medium text-red-600']) }}>
        {{-- Mensaje general de error --}}
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        {{-- Lista de errores específicos --}}
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

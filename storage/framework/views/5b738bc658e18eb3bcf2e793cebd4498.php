<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    </head>
    
    <body class="antialiased bg-fondo-bienvenida text-chamos-beige">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-fondo-bienvenida selection:bg-chamos-marron-claro selection:text-white">
            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center">
                <h1 class="text-4xl font-bold mb-6 text-chamos-amarillo">Bienvenido al área de administración</h1>
                
                <div class="flex justify-center mb-8">
                    
                    <img src="<?php echo e(asset('images/chamos-logo.png')); ?>" alt="Logo de Los Chamos" class="h-64 w-64 object-contain">
                </div>

                <div class="flex justify-center space-x-4">
                    
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center px-6 py-3 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-sm text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-chamos-amarillo focus:ring-offset-2 transition ease-in-out duration-150">
                        Iniciar Sesión
                    </a>
                    
                    <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center px-6 py-3 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-sm text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-chamos-amarillo focus:ring-offset-2 transition ease-in-out duration-150">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH E:\Proyecto de Grado\Grado\resources\views/welcome.blade.php ENDPATH**/ ?>
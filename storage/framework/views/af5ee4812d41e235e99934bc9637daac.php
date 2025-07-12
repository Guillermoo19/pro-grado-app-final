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
    
    <body class="antialiased bg-chamos-marron-oscuro text-chamos-beige">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-chamos-marron-oscuro selection:bg-chamos-marron-claro selection:text-white">
            <?php if(Route::has('login')): ?>
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="font-semibold text-chamos-amarillo hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-chamos-amarillo">Dashboard</a>
                    <?php else: ?>
                        
                        
                        <a href="<?php echo e(route('login')); ?>" class="font-semibold text-chamos-amarillo hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-chamos-amarillo mr-4">Log in</a>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" class="ml-4 font-semibold text-chamos-amarillo hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-chamos-amarillo">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center">
                <h1 class="text-4xl font-bold mb-6 text-chamos-amarillo">¡Bienvenido a Mi Aplicación!</h1>
                <p class="mb-8 text-chamos-beige">Esta es la página de bienvenida de tu aplicación. Por favor, inicia sesión o regístrate para continuar.</p>

                <div class="flex justify-center space-x-4">
                    
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center px-6 py-3 bg-chamos-marron-claro border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-orange-600 focus:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-chamos-marron-claro focus:ring-offset-2 transition ease-in-out duration-150">
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
<?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views\welcome.blade.php ENDPATH**/ ?>
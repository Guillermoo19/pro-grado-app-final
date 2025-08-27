<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Menú de Los Chamos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-900"><?php echo e(__('Explora Nuestro Delicioso Menú')); ?></h3>

                
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>

                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <div class="mb-6">
                            <a href="<?php echo e(route('admin.productos.create')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                <?php echo e(__('Crear Nuevo Producto')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                
                <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if($categoria->productos->count() > 0): ?>
                        <div class="mb-8">
                            <h4 class="text-3xl font-extrabold text-gray-900 mb-4">
                                <?php echo e($categoria->nombre); ?>

                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php $__currentLoopData = $categoria->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden p-4 transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                        
                                        <div class="relative w-full h-48 mb-4">
                                            <?php if($producto->imagen): ?>
                                                <img src="<?php echo e(asset('storage/' . str_replace('public/', '', $producto->imagen))); ?>" alt="<?php echo e($producto->nombre); ?>" class="w-full h-full object-cover rounded-md shadow-md">
                                            <?php else: ?>
                                                <img src="https://placehold.co/400x300.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-full object-cover rounded-md shadow-md">
                                            <?php endif; ?>
                                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                                <a href="<?php echo e(route('productos.show', $producto->id)); ?>" class="text-white text-xl font-bold">Ver Detalles</a>
                                            </div>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2"><?php echo e($producto->nombre); ?></h4>
                                        <p class="text-gray-700 text-center mb-4"><?php echo e(Str::limit($producto->descripcion, 75)); ?></p>
                                        
                                        <span class="text-2xl font-bold text-gray-900">$<?php echo e(number_format($producto->precio, 2)); ?></span>
                                        <a href="<?php echo e(route('productos.show', $producto->id)); ?>" class="mt-4 block w-full text-center bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Añadir al Carrito
                                        </a>
                                        
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(Auth::user()->isAdmin()): ?>
                                                <div class="mt-4 flex justify-center space-x-2">
                                                    
                                                    <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="inline-flex items-center px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-black text-xs font-bold rounded-md transition-colors">
                                                        Editar
                                                    </a>
                                                    <form action="<?php echo e(route('admin.productos.destroy', $producto->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-md transition-colors">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-gray-500">
                        <p>No hay productos disponibles en este momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH E:\Proyecto de Grado\Grado\resources\views/productos/index.blade.php ENDPATH**/ ?>
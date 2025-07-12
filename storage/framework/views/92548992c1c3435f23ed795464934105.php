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
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e(__('Explora Nuestro Delicioso Menú')); ?></h3> 

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
                        <div class="mb-4 text-right">
                            <a href="<?php echo e(route('admin.productos.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <?php echo e(__('Crear Nuevo Producto')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if($productos->isEmpty()): ?>
                    <p class="text-gray-600"><?php echo e(__('No hay platos disponibles en el menú.')); ?></p> 
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                <?php if($producto->imagen): ?>
                                    <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>" class="w-full h-48 object-cover">
                                <?php else: ?>
                                    <img src="https://placehold.co/400x300.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-48 object-cover">
                                <?php endif; ?>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900"><?php echo e($producto->nombre); ?></h4>
                                    <p class="text-gray-600 text-sm mt-1 mb-2"><?php echo e(Str::limit($producto->descripcion, 70)); ?></p>
                                    <p class="text-xl font-bold text-gray-800 mb-4">$<?php echo e(number_format($producto->precio, 2)); ?></p>
                                    
                                    <p class="text-sm text-gray-700 mb-2">
                                        <strong>Disponibilidad:</strong> 
                                        <?php if($producto->stock > 0): ?>
                                            <span class="text-green-600">En stock (<?php echo e($producto->stock); ?> unidades)</span>
                                        <?php else: ?>
                                            <span class="text-red-600">Agotado</span>
                                        <?php endif; ?>
                                    </p>

                                    
                                    <a href="<?php echo e(route('productos.show', $producto->id)); ?>" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                        Ver Detalles
                                    </a>

                                    
                                    <?php if(auth()->guard()->check()): ?>
                                        <?php if(Auth::user()->isAdmin()): ?>
                                            <div class="mt-4 flex justify-around">
                                                <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="inline-flex items-center px-3 py-1 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-blue-300 focus:bg-blue-300 active:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">Editar</a>
                                                <form action="<?php echo e(route('admin.productos.destroy', $producto->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Eliminar</button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views\productos\index.blade.php ENDPATH**/ ?>
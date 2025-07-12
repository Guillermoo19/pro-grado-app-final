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
            <?php echo e(__('Tu Carrito de Compras')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e(__('Tu Carrito de Compras')); ?></h3>

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

                    
                    <?php if(empty($productosEnCarrito)): ?>
                        <p class="text-gray-600"><?php echo e(__('Tu carrito está vacío.')); ?></p>
                        <div class="mt-6">
                            <a href="<?php echo e(route('productos.index')); ?>" class="inline-flex items-center px-4 py-2 bg-chamos-amarillo border border-transparent rounded-md font-semibold text-xs text-chamos-marron-oscuro uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                <?php echo e(__('Ir al Menú')); ?>

                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-6">
                            <?php $__currentLoopData = $productosEnCarrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center bg-gray-50 rounded-lg shadow-sm p-4">
                                    <div class="flex-shrink-0 w-24 h-24 rounded-md overflow-hidden mr-4">
                                        <?php if($item['imagen']): ?>
                                            <img src="<?php echo e(asset('storage/' . $item['imagen'])); ?>" alt="<?php echo e($item['nombre']); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.co/100x100.png?text=Sin+Imagen" alt="Placeholder" class="w-full h-full object-cover">
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex-grow">
                                        <h4 class="text-lg font-semibold text-gray-800"><?php echo e($item['nombre']); ?></h4>
                                        
                                        
                                        <p class="text-md font-medium text-gray-700">$<?php echo e(number_format($item['precio'], 2)); ?> x <?php echo e($item['cantidad']); ?></p>
                                    </div>

                                    <div class="flex items-center space-x-3 ml-4">
                                        
                                        <form action="<?php echo e(route('carrito.update')); ?>" method="POST" class="flex items-center">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="producto_id" value="<?php echo e($item['id']); ?>">
                                            <input type="number" name="cantidad" value="<?php echo e($item['cantidad']); ?>" min="1" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center">
                                            <button type="submit" 
                                                    style="background: none; border: none; color: #007bff; text-decoration: underline; cursor: pointer; font-weight: bold; margin-left: 0.5rem;"
                                                    onmouseover="this.style.color='#0056b3'" 
                                                    onmouseout="this.style.color='#007bff'">
                                                Actualizar
                                            </button>
                                        </form>

                                        
                                        <form action="<?php echo e(route('carrito.remove')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="producto_id" value="<?php echo e($item['id']); ?>">
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <div class="flex flex-col sm:flex-row justify-between items-end mt-8 pt-4 border-t border-gray-200 relative">
                            <h4 class="text-xl font-bold text-gray-900 mb-4 sm:mb-0"><?php echo e(__('Total del Carrito:')); ?> $<?php echo e(number_format($total, 2)); ?></h4>
                            
                            
                            <div class="ml-auto relative z-10">
                                <form id="checkoutForm" action="<?php echo e(route('carrito.checkout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" 
                                            class="px-6 py-3 bg-chamos-verde text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <?php echo e(__('Proceder al Pago')); ?>

                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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
<?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views/carrito/index.blade.php ENDPATH**/ ?>
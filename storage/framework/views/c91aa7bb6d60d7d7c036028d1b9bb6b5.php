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
                <?php echo e(__('Detalles del Producto')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e($producto->nombre); ?></h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <?php if($producto->imagen): ?>
                                    <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>" class="w-full h-auto object-cover rounded-lg shadow-md">
                                <?php else: ?>
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg shadow-md">
                                        <span class="text-gray-500"><?php echo e(__('No hay imagen disponible')); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-lg text-gray-700 mb-2"><strong><?php echo e(__('Descripción:')); ?></strong> <?php echo e($producto->descripcion ?? 'N/A'); ?></p>
                                <p class="text-lg text-gray-700 mb-2"><strong><?php echo e(__('Precio:')); ?></strong> $<?php echo e(number_format($producto->precio, 2)); ?></p>
                                <p class="text-lg text-gray-700 mb-2"><strong><?php echo e(__('Stock:')); ?></strong> <?php echo e($producto->stock); ?></p>
                                <p class="text-lg text-gray-700 mb-4"><strong><?php echo e(__('Categoría:')); ?></strong> <?php echo e($producto->categoria->nombre ?? 'N/A'); ?></p>

                                <?php if($producto->ingredientes->isNotEmpty()): ?>
                                    <h4 class="font-semibold text-lg text-gray-800 mb-2"><?php echo e(__('Ingredientes:')); ?></h4>
                                    <ul class="list-disc list-inside text-gray-700">
                                        <?php $__currentLoopData = $producto->ingredientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingrediente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($ingrediente->nombre); ?> (<?php echo e($ingrediente->pivot->cantidad); ?> <?php echo e($ingrediente->pivot->unidad_medida); ?>)</li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-gray-600"><?php echo e(__('No hay ingredientes asociados a este producto.')); ?></p>
                                <?php endif; ?>

                                <div class="mt-6 flex space-x-4">
                                    <a href="<?php echo e(route('admin.productos.edit', $producto->id)); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <?php echo e(__('Editar Producto')); ?>

                                    </a>
                                    <a href="<?php echo e(route('admin.productos.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <?php echo e(__('Volver a la lista')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
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
    <?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views\admin\productos\show.blade.php ENDPATH**/ ?>
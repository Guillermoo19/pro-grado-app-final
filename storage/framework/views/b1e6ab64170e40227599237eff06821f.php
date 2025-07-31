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
            <?php echo e(__('Gestión de Pedidos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e(__('Todos los Pedidos')); ?></h3>

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

                    <?php if($pedidos->isEmpty()): ?>
                        <p class="text-gray-600"><?php echo e(__('No hay pedidos registrados.')); ?></p>
                    <?php else: ?>
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('ID Pedido')); ?></th>
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('Usuario')); ?></th>
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('Fecha')); ?></th>
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('Total')); ?></th>
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('Estado Pedido')); ?></th> 
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('Estado Pago')); ?></th>   
                                        <th scope="col" class="py-3 px-6"><?php echo e(__('Acciones')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                <?php echo e($pedido->id); ?>

                                            </th>
                                            <td class="py-4 px-6">
                                                <?php echo e($pedido->user->name ?? 'N/A'); ?>

                                            </td>
                                            <td class="py-4 px-6">
                                                <?php echo e($pedido->created_at->format('d/m/Y H:i')); ?>

                                            </td>
                                            <td class="py-4 px-6">
                                                $<?php echo e(number_format($pedido->total, 2)); ?>

                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    <?php if($pedido->estado_pedido === 'pendiente'): ?> bg-yellow-100 text-yellow-800
                                                    <?php elseif($pedido->estado_pedido === 'en_preparacion'): ?> bg-blue-100 text-blue-800
                                                    <?php elseif($pedido->estado_pedido === 'en_camino'): ?> bg-purple-100 text-purple-800
                                                    <?php elseif($pedido->estado_pedido === 'entregado'): ?> bg-green-100 text-green-800
                                                    <?php elseif($pedido->estado_pedido === 'cancelado'): ?> bg-red-100 text-red-800
                                                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado_pedido))); ?>

                                                </span>
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    <?php if($pedido->estado_pago === 'pendiente'): ?> bg-yellow-100 text-yellow-800
                                                    <?php elseif($pedido->estado_pago === 'pendiente_revision'): ?> bg-orange-100 text-orange-800
                                                    <?php elseif($pedido->estado_pago === 'pagado'): ?> bg-green-100 text-green-800
                                                    <?php elseif($pedido->estado_pago === 'rechazado'): ?> bg-red-100 text-red-800
                                                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado_pago))); ?>

                                                </span>
                                            </td>
                                            <td class="py-4 px-6">
                                                <a href="<?php echo e(route('admin.pedidos.show', $pedido->id)); ?>" class="font-medium text-blue-600 hover:underline">
                                                    <?php echo e(__('Ver Detalles')); ?>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
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
<?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views\admin\pedidos\index.blade.php ENDPATH**/ ?>
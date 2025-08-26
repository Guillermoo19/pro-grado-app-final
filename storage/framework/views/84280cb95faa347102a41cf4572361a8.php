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
        <div class="flex items-center justify-between">
            
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Volver a Inicio
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Gestión de Pedidos')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4 text-yellow-600">Pedidos Pendientes</h2>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $pedidosPendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->id); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->user->name ?? 'N/A'); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">$<?php echo e(number_format($pedido->total, 2)); ?></td>
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        <?php if($pedido->estado_pago === 'pendiente'): ?> bg-yellow-100 text-yellow-800
                                                        <?php elseif($pedido->estado_pago === 'pendiente_revision'): ?> bg-orange-100 text-orange-800
                                                        <?php elseif($pedido->estado_pago === 'pagado'): ?> bg-green-100 text-green-800
                                                        <?php elseif($pedido->estado_pago === 'rechazado'): ?> bg-red-100 text-red-800
                                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                            <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado_pago))); ?>

                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <a href="<?php echo e(route('admin.pedidos.show', $pedido->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-center text-gray-500">
                                                    No hay pedidos pendientes por revisar.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4 text-green-600">Pedidos Completados</h2>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $pedidosCompletados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->id); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->user->name ?? 'N/A'); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">$<?php echo e(number_format($pedido->total, 2)); ?></td>
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        <?php if($pedido->estado_pago === 'pendiente'): ?> bg-yellow-100 text-yellow-800
                                                        <?php elseif($pedido->estado_pago === 'pendiente_revision'): ?> bg-orange-100 text-orange-800
                                                        <?php elseif($pedido->estado_pago === 'pagado'): ?> bg-green-100 text-green-800
                                                        <?php elseif($pedido->estado_pago === 'rechazado'): ?> bg-red-100 text-red-800
                                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                            <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado_pago))); ?>

                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <a href="<?php echo e(route('admin.pedidos.show', $pedido->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-center text-gray-500">
                                                    No hay pedidos completados.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4 text-orange-600">Pedidos Cancelados (Pagados)</h2>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php $__empty_1 = true; $__currentLoopData = $pedidosCanceladosPagados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->id); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->user->name ?? 'N/A'); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">$<?php echo e(number_format($pedido->total, 2)); ?></td>
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        <?php if($pedido->estado_pago === 'pendiente'): ?> bg-yellow-100 text-yellow-800
                                                        <?php elseif($pedido->estado_pago === 'pendiente_revision'): ?> bg-orange-100 text-orange-800
                                                        <?php elseif($pedido->estado_pago === 'pagado'): ?> bg-green-100 text-green-800
                                                        <?php elseif($pedido->estado_pago === 'rechazado'): ?> bg-red-100 text-red-800
                                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                            <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado_pago))); ?>

                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <a href="<?php echo e(route('admin.pedidos.show', $pedido->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-center text-gray-500">
                                                    No hay pedidos cancelados que necesiten revisión.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-red-600">Pedidos Rechazados</h2>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                            <div class="overflow-x-auto">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                ID Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Usuario
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Total
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pedido
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Estado Pago
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $pedidosRechazados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->id); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm"><?php echo e($pedido->user->name ?? 'N/A'); ?></td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">$<?php echo e(number_format($pedido->total, 2)); ?></td>
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
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
                                                <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        <?php if($pedido->estado_pago === 'pendiente'): ?> bg-yellow-100 text-yellow-800
                                                        <?php elseif($pedido->estado_pago === 'pendiente_revision'): ?> bg-orange-100 text-orange-800
                                                        <?php elseif($pedido->estado_pago === 'pagado'): ?> bg-green-100 text-green-800
                                                        <?php elseif($pedido->estado_pago === 'rechazado'): ?> bg-red-100 text-red-800
                                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                            <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado_pago))); ?>

                                                    </span>
                                                </td>
                                                <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                                    <a href="<?php echo e(route('admin.pedidos.show', $pedido->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-center text-gray-500">
                                                    No hay pedidos rechazados.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
<?php /**PATH E:\Proyecto de Grado\Grado\resources\views/admin/pedidos/index.blade.php ENDPATH**/ ?>
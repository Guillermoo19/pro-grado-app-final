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
            <?php echo e(__('Detalles de Mi Pedido')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro">Pedido #<?php echo e($pedido->id); ?></h3>

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
                <?php if(session('info')): ?>
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo e(session('info')); ?></span>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Información del Pedido -->
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Información del Pedido')); ?></h4>
                        <p class="text-gray-700 mb-2"><strong>Fecha:</strong> <?php echo e($pedido->created_at->format('d/m/Y')); ?></p>
                        <p class="text-gray-700 mb-2"><strong>Hora:</strong> <?php echo e($pedido->created_at->format('H:i')); ?></p>
                        <p class="text-gray-700 mb-2"><strong>Total Pagado:</strong> <span class="font-bold text-green-600">$<?php echo e(number_format($pedido->total, 2)); ?></span></p>
                        <p class="text-gray-700 mb-2"><strong>Estado del Pedido:</strong> <span class="font-bold"><?php echo e(ucfirst($pedido->estado_pedido)); ?></span></p>
                        <p class="text-gray-700 mb-2"><strong>Estado del Pago:</strong> <span class="font-bold"><?php echo e(ucfirst($pedido->estado_pago)); ?></span></p>
                        <p class="text-gray-700 mb-2"><strong>Tipo de Entrega:</strong> <span class="font-bold"><?php echo e(ucfirst($pedido->tipo_entrega)); ?></span></p>
                        <?php if($pedido->tipo_entrega === 'domicilio'): ?>
                            <p class="text-gray-700 mb-2"><strong>Dirección de Entrega:</strong> <?php echo e($pedido->direccion_entrega ?? 'N/A'); ?></p>
                            <p class="text-gray-700 mb-2"><strong>Teléfono de Contacto:</strong> <?php echo e($pedido->telefono_contacto ?? 'N/A'); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Información del Cliente -->
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Información del Cliente')); ?></h4>
                        <?php if($pedido->user): ?>
                            <p class="text-gray-700 mb-2"><strong>Nombre:</strong> <?php echo e($pedido->user->name); ?></p>
                            <p class="text-gray-700 mb-2"><strong>Correo:</strong> <?php echo e($pedido->user->email); ?></p>
                            <?php if($pedido->telefono_contacto): ?>
                                <p class="text-gray-700 mb-2"><strong>Teléfono (Pedido):</strong> <?php echo e($pedido->telefono_contacto); ?></p>
                            <?php endif; ?>
                            <?php if($pedido->direccion_entrega): ?>
                                <p class="text-gray-700 mb-2"><strong>Dirección (Pedido):</strong> <?php echo e($pedido->direccion_entrega); ?></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-gray-700 mb-2">Usuario no disponible.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detalles de los Platos -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Platos en tu Pedido')); ?></h4>
                <?php if($pedido->productos->isEmpty()): ?>
                    <p class="text-gray-600">No hay platos en este pedido.</p>
                <?php else: ?>
                    <div class="border rounded-lg overflow-hidden mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plato</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $pedido->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($producto->nombre); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($producto->pivot->cantidad); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo e(number_format($producto->pivot->precio_unitario, 2)); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo e(number_format($producto->pivot->subtotal, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Comprobante de Pago -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Comprobante de Pago')); ?></h4>
                <?php if($pedido->comprobante_url): ?>
                    <div class="mb-4">
                        <img src="<?php echo e(asset('storage/' . $pedido->comprobante_url)); ?>" alt="Comprobante de Pago" class="w-64 h-auto rounded-lg shadow-md mt-2">
                        <a href="<?php echo e(asset('storage/' . $pedido->comprobante_url)); ?>" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-gray-900 uppercase tracking-widest hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition ease-in-out duration-150 mt-4">
                            <?php echo e(__('Ver comprobante en tamaño completo')); ?>

                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 mb-4">No se ha subido ningún comprobante para este pedido.</p>
                <?php endif; ?>

                <div class="mt-8 text-right">
                    <a href="<?php echo e(route('pedidos.index')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-gray-900 uppercase tracking-widest hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                        <?php echo e(__('Volver a Mis Pedidos')); ?>

                    </a>
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
<?php /**PATH E:\Proyecto de Grado\Grado\resources\views/pedidos/show.blade.php ENDPATH**/ ?>
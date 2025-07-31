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
            <?php echo e(__('Detalles del Pedido (Admin)')); ?>

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
                        <p class="text-gray-700 mb-2"><strong>Tipo de Entrega:</strong> <span class="font-bold"><?php echo e(ucfirst(str_replace('_', ' ', $pedido->tipo_entrega))); ?></span></p>
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
                        <?php else: ?>
                            <p class="text-gray-700 mb-2">Usuario no disponible.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detalles de los Platos -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Platos en el Pedido')); ?></h4>
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
                        <a href="<?php echo e(asset('storage/' . $pedido->comprobante_url)); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm mt-2 block">Ver comprobante en tamaño completo</a>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 mb-4">No se ha subido ningún comprobante para este pedido.</p>
                <?php endif; ?>

                <!-- Formulario para Actualizar Estado del Pedido -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3 mt-8"><?php echo e(__('Actualizar Estado del Pedido')); ?></h4>
                <form action="<?php echo e(route('admin.pedidos.update_estado_pedido', $pedido->id)); ?>" method="POST" class="mb-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div class="flex items-center space-x-4">
                        <select name="estado_pedido" class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pendiente" <?php echo e($pedido->estado_pedido == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                            <option value="en_preparacion" <?php echo e($pedido->estado_pedido == 'en_preparacion' ? 'selected' : ''); ?>>En Preparación</option>
                            <option value="en_camino" <?php echo e($pedido->estado_pedido == 'en_camino' ? 'selected' : ''); ?>>En Camino</option>
                            <option value="entregado" <?php echo e($pedido->estado_pedido == 'entregado' ? 'selected' : ''); ?>>Entregado</option>
                            <option value="cancelado" <?php echo e($pedido->estado_pedido == 'cancelado' ? 'selected' : ''); ?>>Cancelado</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Actualizar Estado Pedido</button>
                    </div>
                </form>

                <!-- Formulario para Actualizar Estado del Pago -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Actualizar Estado del Pago')); ?></h4>
                <form action="<?php echo e(route('admin.pedidos.update_estado_pago', $pedido->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div class="flex items-center space-x-4">
                        <select name="estado_pago" class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pendiente" <?php echo e($pedido->estado_pago == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                            <option value="pendiente_revision" <?php echo e($pedido->estado_pago == 'pendiente_revision' ? 'selected' : ''); ?>>Pendiente de Revisión</option>
                            <option value="pagado" <?php echo e($pedido->estado_pago == 'pagado' ? 'selected' : ''); ?>>Pagado</option>
                            <option value="rechazado" <?php echo e($pedido->estado_pago == 'rechazado' ? 'selected' : ''); ?>>Rechazado</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Actualizar Estado Pago</button>
                    </div>
                </form>

                <div class="mt-8 text-right">
                    <a href="<?php echo e(route('admin.pedidos.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <?php echo e(__('Volver a la Lista de Pedidos')); ?>

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
<?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views\admin\pedidos\show.blade.php ENDPATH**/ ?>
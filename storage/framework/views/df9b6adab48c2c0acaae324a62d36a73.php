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
            <?php echo e(__('Confirmación de Pedido y Pago')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e(__('Tu Pedido Ha Sido Creado')); ?></h3>

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

                
                <p class="text-lg text-gray-700 mb-4">Número de Pedido: <span class="font-bold"><?php echo e($pedido->id); ?></span></p>
                <p class="text-lg text-gray-700 mb-6">Total a Pagar: <span class="font-bold text-green-600">$<?php echo e(number_format($pedido->total, 2)); ?></span></p>

                <!-- SECCIÓN DE SELECCIÓN DEL MÉTODO DE PAGO -->
                <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Seleccionar Método de Pago')); ?></h4>
                <div class="flex items-center space-x-6 mb-8">
                    <div class="flex items-center">
                        
                        <input type="radio" name="metodo_pago" id="bank_transfer" value="bank_transfer" class="form-radio h-4 w-4 text-chamos-verde-claro transition duration-150 ease-in-out" checked onchange="togglePaymentFields()">
                        <label for="bank_transfer" class="ml-2 block text-sm leading-5 font-medium text-gray-700">
                            Transferencia Bancaria
                        </label>
                    </div>
                    <div class="flex items-center">
                        
                        <input type="radio" name="metodo_pago" id="qr_payment" value="qr_payment" class="form-radio h-4 w-4 text-chamos-verde-claro transition duration-150 ease-in-out" onchange="togglePaymentFields()">
                        <label for="qr_payment" class="ml-2 block text-sm leading-5 font-medium text-gray-700">
                            Código QR
                        </label>
                    </div>
                </div>

                <!-- CONTENIDO DINÁMICO SEGÚN EL MÉTODO DE PAGO -->
                
                <div id="bank_transfer_fields" class="bg-gray-50 p-4 rounded-lg shadow-inner mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Datos Bancarios para la Transferencia')); ?></h4>
                    <p class="text-gray-700 mb-2">Por favor, realiza la transferencia bancaria al siguiente número de cuenta y sube el comprobante.</p>
                    <p class="text-gray-700 mb-2"><strong>Banco:</strong> <?php echo e($configuracion->banco ?? 'N/A'); ?></p>
                    <p class="text-gray-700 mb-2"><strong>Número de Cuenta:</strong> <?php echo e($configuracion->numero_cuenta ?? 'N/A'); ?></p>
                    <p class="text-gray-700 mb-2"><strong>Nombre del Titular:</strong> <?php echo e($configuracion->nombre_titular ?? 'N/A'); ?></p>
                    <p class="text-gray-700 mb-2"><strong>Tipo de Cuenta:</strong> <?php echo e($configuracion->tipo_cuenta ?? 'N/A'); ?></p>
                </div>

                
                <div id="qr_payment_fields" class="hidden bg-gray-50 p-4 rounded-lg shadow-inner mb-8 text-center">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Pago por Código QR')); ?></h4>
                    <p class="text-gray-700 mb-4">
                        Por favor, escanea este código QR para realizar el pago y sube el comprobante.
                    </p>
                    
                    
                    <img src="<?php echo e($configuracion->ruta_imagen_qr ?? asset('images/QR.png')); ?>" alt="Código QR para pago" class="w-64 h-64 mx-auto rounded-lg shadow-lg">
                </div>
                
                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3"><?php echo e(__('Productos en tu Pedido')); ?></h4>
                    <ul>
                        <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="mb-2">
                                <span class="font-bold"><?php echo e($detalle->cantidad); ?>x <?php echo e($detalle->producto->nombre); ?></span> - $<?php echo e(number_format($detalle->subtotal, 2)); ?>

                                <?php if($detalle->ingredientes_adicionales): ?>
                                    <ul class="ml-4 list-disc list-inside text-gray-600">
                                        <?php $__currentLoopData = $detalle->ingredientes_adicionales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingrediente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>+ <?php echo e($ingrediente['nombre']); ?> ($<?php echo e(number_format($ingrediente['precio'], 2)); ?>)</li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e(__('Subir Comprobante de Pago y Detalles de Entrega')); ?></h3>
                <p class="text-gray-700 mb-4">Por favor, sube una imagen (JPG, PNG, GIF, SVG) o PDF de tu comprobante de pago.</p>

                <form action="<?php echo e(route('checkout.upload_proof', $pedido->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="metodo_pago" id="selected_payment_method" value="bank_transfer">

                    <div class="mb-4">
                        <label for="tipo_entrega" class="block text-sm font-medium text-gray-700">Tipo de Entrega</label>
                        
                        <select name="tipo_entrega" id="tipo_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900 bg-white" onchange="toggleDeliveryFields()">
                            <option value="recoger_local" <?php echo e(old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'recoger_local' ? 'selected' : ''); ?>>Recoger en Local</option>
                            <option value="domicilio" <?php echo e(old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'domicilio' ? 'selected' : ''); ?>>Envío a Domicilio</option>
                        </select>
                        <?php $__errorArgs = ['tipo_entrega'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div id="delivery_fields" class="<?php echo e(old('tipo_entrega', $pedido->tipo_entrega ?? '') == 'domicilio' ? '' : 'hidden'); ?>">
                        <div class="mb-4">
                            <label for="direccion_entrega" class="block text-sm font-medium text-gray-700">Dirección de Entrega</label>
                            <input type="text" name="direccion_entrega" id="direccion_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900 bg-white" value="<?php echo e(old('direccion_entrega', $pedido->direccion_entrega ?? '')); ?>">
                            <?php $__errorArgs = ['direccion_entrega'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-4">
                            <label for="telefono_contacto" class="block text-sm font-medium text-gray-700">Teléfono de Contacto</label>
                            <input type="text" name="telefono_contacto" id="telefono_contacto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900 bg-white" value="<?php echo e(old('telefono_contacto', $pedido->telefono_contacto ?? '')); ?>">
                            <?php $__errorArgs = ['telefono_contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="proof_image" class="block text-sm font-medium text-gray-700">Seleccionar Comprobante:</label>
                        
                        <input type="file" name="proof_image" id="proof_image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none">
                        <?php $__errorArgs = ['proof_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-md shadow-md hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                            <?php echo e(__('Subir Comprobante y Guardar Detalles')); ?>

                        </button>
                        
                        <a href="<?php echo e(route('pedidos.index')); ?>" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-md shadow-md hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                            <?php echo e(__('Ir a Mis Pedidos')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleDeliveryFields() {
            const tipoEntrega = document.getElementById('tipo_entrega').value;
            const deliveryFields = document.getElementById('delivery_fields');
            if (tipoEntrega === 'domicilio') {
                deliveryFields.classList.remove('hidden');
            } else {
                deliveryFields.classList.add('hidden');
            }
        }

        function togglePaymentFields() {
            const bankTransferFields = document.getElementById('bank_transfer_fields');
            const qrPaymentFields = document.getElementById('qr_payment_fields');
            const selectedPaymentMethodInput = document.getElementById('selected_payment_method');

            if (document.getElementById('bank_transfer').checked) {
                bankTransferFields.classList.remove('hidden');
                qrPaymentFields.classList.add('hidden');
                selectedPaymentMethodInput.value = 'bank_transfer';
            } else {
                bankTransferFields.classList.add('hidden');
                qrPaymentFields.classList.remove('hidden');
                selectedPaymentMethodInput.value = 'qr_payment';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleDeliveryFields();
            togglePaymentFields();
        });
    </script>
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
<?php /**PATH E:\Proyecto de Grado\Grado\resources\views/checkout/confirm.blade.php ENDPATH**/ ?>
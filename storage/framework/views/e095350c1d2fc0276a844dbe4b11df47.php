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
                <?php echo e(__('Gestión de Roles')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-2xl font-bold mb-6 text-chamos-marron-oscuro"><?php echo e(__('Lista de Roles')); ?></h3>

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

                        <div class="mb-4">
                            <a href="<?php echo e(route('admin.roles.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <?php echo e(__('Crear Nuevo Rol')); ?>

                            </a>
                        </div>

                        <?php if($roles->isEmpty()): ?>
                            <p class="text-gray-600"><?php echo e(__('No hay roles registrados en el sistema.')); ?></p>
                        <?php else: ?>
                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3 px-6"><?php echo e(__('ID')); ?></th>
                                            <th scope="col" class="py-3 px-6"><?php echo e(__('Nombre')); ?></th>
                                            <th scope="col" class="py-3 px-6"><?php echo e(__('Acciones')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    <?php echo e($role->id); ?>

                                                </th>
                                                <td class="py-4 px-6">
                                                    <?php echo e($role->nombre); ?>

                                                </td>
                                                <td class="py-4 px-6 flex items-center space-x-2">
                                                    <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>" class="font-medium text-blue-600 hover:underline">
                                                        <?php echo e(__('Editar')); ?>

                                                    </a>
                                                    <form action="<?php echo e(route('admin.roles.destroy', $role->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este rol? Esta acción es irreversible.');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="font-medium text-red-600 hover:underline ml-2">
                                                            <?php echo e(__('Eliminar')); ?>

                                                        </button>
                                                    </form>
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
    <?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views\admin\roles\index.blade.php ENDPATH**/ ?>
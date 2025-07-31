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
            <?php echo e(__('Dashboard de Administración')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php echo e(__("¡Bienvenido al Dashboard de Administración!")); ?>

                    <p class="mt-4">Aquí podrás gestionar usuarios, productos, categorías y pedidos.</p>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="<?php echo e(route('admin.roles.index')); ?>" class="block p-4 bg-blue-100 rounded-lg shadow hover:bg-blue-200 transition">
                            <h4 class="font-semibold text-lg text-blue-800">Gestionar Roles</h4>
                            <p class="text-sm text-blue-600">Asignar y editar roles de usuario.</p>
                        </a>
                        <a href="<?php echo e(route('admin.categorias.index')); ?>" class="block p-4 bg-green-100 rounded-lg shadow hover:bg-green-200 transition">
                            <h4 class="font-semibold text-lg text-green-800">Gestionar Categorías</h4>
                            <p class="text-sm text-green-600">Administrar categorías de productos.</p>
                        </a>
                        <a href="<?php echo e(route('admin.productos.index')); ?>" class="block p-4 bg-yellow-100 rounded-lg shadow hover:bg-yellow-200 transition">
                            <h4 class="font-semibold text-lg text-yellow-800">Gestionar Productos</h4>
                            <p class="text-sm text-yellow-600">Añadir, editar y eliminar productos.</p>
                        </a>
                        <a href="<?php echo e(route('admin.pedidos.index')); ?>" class="block p-4 bg-purple-100 rounded-lg shadow hover:bg-purple-200 transition">
                            <h4 class="font-semibold text-lg text-purple-800">Gestionar Pedidos</h4>
                            <p class="text-sm text-purple-600">Revisar y actualizar el estado de los pedidos.</p>
                        </a>
                        
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="block p-4 bg-orange-100 rounded-lg shadow hover:bg-orange-200 transition">
                            <h4 class="font-semibold text-lg text-orange-800">Gestionar Usuarios</h4>
                            <p class="text-sm text-orange-600">Administrar usuarios y sus roles.</p>
                        </a>
                        
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
<?php /**PATH E:\Proyecto de Grado\Laravel\pro-grado-app-final\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
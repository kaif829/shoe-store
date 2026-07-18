<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('content'); ?>
<h2 class="fw-bold mb-4">Categories</h2>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-3">
            <h6>Add Category</h6>
            <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input name="name" class="form-control mb-2" placeholder="Category name" required>
                <input name="icon" class="form-control mb-2" placeholder="Bootstrap icon class (optional)">
                <button class="btn btn-shoe-primary w-100">Add</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card"><table class="table mb-0">
            <thead><tr><th>Name</th><th>Products</th><th></th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><i class="bi <?php echo e($cat->icon); ?>"></i> <?php echo e($cat->name); ?></td>
                    <td><?php echo e($cat->products_count); ?></td>
                    <td><form action="<?php echo e(route('admin.categories.destroy', $cat)); ?>" method="POST" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>
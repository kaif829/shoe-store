<?php $__env->startSection('title','Reviews'); ?>
<?php $__env->startSection('content'); ?>

<h2 class="fw-bold mb-4">Reviews Management</h2>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Customer</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($r->product->name ?? 'Deleted'); ?></strong></td>
                <td><?php echo e($r->user->name ?? 'Deleted'); ?></td>
                <td>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star<?php echo e($i <= $r->rating ? '-fill text-warning' : ' text-muted'); ?>"></i>
                    <?php endfor; ?>
                </td>
                <td>
                    <?php echo e(strlen($r->comment) > 50 ? substr($r->comment, 0, 50).'...' : $r->comment); ?>

                </td>
                <td>
                    <span class="badge <?php echo e($r->is_approved ? 'bg-success' : 'bg-warning text-dark'); ?>">
                        <?php echo e($r->is_approved ? 'Approved' : 'Hidden'); ?>

                    </span>
                </td>
                <td><?php echo e($r->created_at->format('d M Y')); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.reviews.approve', $r)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button class="btn btn-sm btn-outline-secondary" title="Toggle Approval">
                            <i class="bi bi-<?php echo e($r->is_approved ? 'eye-slash' : 'eye'); ?>"></i>
                        </button>
                    </form>
                    <form action="<?php echo e(route('admin.reviews.destroy', $r)); ?>" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this review?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-star fs-1"></i><br>No reviews yet.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-3"><?php echo e($reviews->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Wishlist'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-heart-fill text-danger"></i> My Wishlist</h2>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3">
                <div class="card product-card">
                    <img src="<?php echo e($item->product->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/300x220'); ?>">
                    <div class="card-body">
                        <h6><?php echo e($item->product->name); ?></h6>
                        <span class="price-tag">$<?php echo e($item->product->price); ?></span>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="<?php echo e(route('products.show', $item->product)); ?>" class="btn btn-shoe-primary w-100">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted">Your wishlist is empty.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/products/wishlist.blade.php ENDPATH**/ ?>
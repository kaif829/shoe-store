<div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
            <div class="card product-card h-100">
                <img src="<?php echo e($p->image ? asset('storage/'.$p->image) : 'https://placehold.co/400x300?text='.urlencode($p->name)); ?>">
                <div class="card-body">
                    <h6><?php echo e($p->name); ?></h6>
                    <p class="text-muted small"><?php echo e($p->brand); ?></p>
                    <span class="price-tag">$<?php echo e($p->price); ?></span>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="<?php echo e(route('products.show', $p)); ?>" class="btn btn-shoe-primary w-100">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted">No matches found, try different criteria.</p>
    <?php endif; ?>
</div>
<?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/recommendation/partials/results.blade.php ENDPATH**/ ?>
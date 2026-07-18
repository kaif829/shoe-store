<div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-sm-6 col-lg-4 col-xl-3 fade-in">
            <div class="card product-card h-100">
                <a href="<?php echo e(route('products.show', $product)); ?>">
                    <img src="<?php echo e($product->image ? asset('storage/'.$product->image) : 'https://placehold.co/400x300?text='.urlencode($product->name)); ?>" alt="<?php echo e($product->name); ?>">
                </a>
                <div class="card-body">
                    <span class="badge badge-activity text-uppercase mb-2"><?php echo e($product->activity_type); ?></span>
                    <h6 class="mb-1"><a href="<?php echo e(route('products.show', $product)); ?>" class="text-decoration-none text-dark"><?php echo e($product->name); ?></a></h6>
                    <p class="text-muted small mb-2"><?php echo e($product->brand); ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">$<?php echo e(number_format($product->price, 2)); ?></span>
                        <span class="small"><i class="bi bi-star-fill text-warning"></i> <?php echo e(number_format($product->avg_rating, 1)); ?> (<?php echo e($product->review_count); ?>)</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <?php if(auth()->guard()->check()): ?>
                        <button class="btn btn-shoe-primary w-100" onclick="addToCart(<?php echo e($product->id); ?>)"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark w-100">Login to Buy</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-emoji-frown fs-1 text-muted"></i>
            <p class="text-muted mt-2">No products match your filters.</p>
        </div>
    <?php endif; ?>
</div>
<div class="mt-4"><?php echo e($products->links()); ?></div>
<?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/products/partials/grid.blade.php ENDPATH**/ ?>
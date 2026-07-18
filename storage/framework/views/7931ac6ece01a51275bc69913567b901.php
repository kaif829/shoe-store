<?php $__env->startSection('title', $product->name); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Shop</a></li>
            <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        
        <div class="col-md-5">
            <img src="<?php echo e($product->image ? asset('storage/'.$product->image) : 'https://placehold.co/500x400?text='.urlencode($product->name)); ?>"
                class="img-fluid rounded-3 shadow-sm w-100" style="object-fit:cover; max-height:420px" alt="<?php echo e($product->name); ?>">
        </div>

        
        <div class="col-md-7">
            <span class="badge badge-activity text-uppercase mb-2"><?php echo e($product->activity_type); ?></span>
            <h2 class="fw-bold"><?php echo e($product->name); ?></h2>
            <p class="text-muted mb-1"><?php echo e($product->brand); ?> &middot; <?php echo e(ucfirst($product->gender)); ?></p>
            <p class="text-muted mb-3">Sizes: <?php echo e($product->size_range ?? 'N/A'); ?></p>

            <div class="d-flex align-items-center gap-2 mb-3">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="bi bi-star<?php echo e($i <= round($product->avg_rating) ? '-fill' : ''); ?> text-warning"></i>
                <?php endfor; ?>
                <span class="text-muted">(<?php echo e($product->review_count); ?> reviews)</span>
            </div>

            <h3 class="price-tag mb-3">$<?php echo e(number_format($product->price, 2)); ?></h3>
            <p><?php echo e($product->description); ?></p>

            <p class="mb-3">
                <?php if($product->stock > 10): ?>
                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> In Stock (<?php echo e($product->stock); ?>)</span>
                <?php elseif($product->stock > 0): ?>
                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> Low Stock (<?php echo e($product->stock); ?> left)</span>
                <?php else: ?>
                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Out of Stock</span>
                <?php endif; ?>
            </p>

            <?php if(auth()->guard()->check()): ?>
                <?php if($product->stock > 0): ?>
                    <div class="d-flex gap-2 align-items-center mt-3 flex-wrap">
                        <div class="input-group" style="width:120px">
                            <button class="btn btn-outline-secondary" onclick="$('#qty').val(Math.max(1, parseInt($('#qty').val())-1))">-</button>
                            <input type="number" id="qty" value="1" min="1" max="<?php echo e($product->stock); ?>" class="form-control text-center">
                            <button class="btn btn-outline-secondary" onclick="$('#qty').val(Math.min(<?php echo e($product->stock); ?>, parseInt($('#qty').val())+1))">+</button>
                        </div>
                        <button class="btn btn-shoe-primary btn-lg px-4"
                            onclick="addToCart(<?php echo e($product->id); ?>, parseInt($('#qty').val()))">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-danger btn-lg wishlist-icon"
                            onclick="toggleWishlist(<?php echo e($product->id); ?>, this)">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark btn-lg mt-3">
                    <i class="bi bi-person"></i> Login to Purchase
                </a>
            <?php endif; ?>
        </div>
    </div>

    <hr class="my-5">

    
    <div class="row">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4">Customer Reviews
                <span class="fs-6 text-muted fw-normal">(<?php echo e($product->review_count); ?> total)</span>
            </h4>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <?php if(auth()->guard()->check()): ?>
                <?php $userReview = $product->reviews->firstWhere('user_id', auth()->id()); ?>
                <div class="card p-4 mb-4 shadow-sm">
                    <h6 class="mb-3"><?php echo e($userReview ? 'Update Your Review' : 'Write a Review'); ?></h6>
                    <form action="<?php echo e(route('reviews.store', $product)); ?>" method="POST" id="review-form">
                        <?php echo csrf_field(); ?>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Rating</label>
                            <div class="star-rating d-flex gap-1 fs-4">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <label class="star-label" data-val="<?php echo e($i); ?>">
                                        <input type="radio" name="rating" value="<?php echo e($i); ?>" class="d-none"
                                            <?php echo e(($userReview && $userReview->rating == $i) ? 'checked' : ''); ?>>
                                        <i class="bi bi-star<?php echo e(($userReview && $userReview->rating >= $i) ? '-fill text-warning' : ' text-muted'); ?>"
                                           style="cursor:pointer"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comment (optional)</label>
                            <textarea name="comment" class="form-control" rows="3"
                                placeholder="Share your experience..."><?php echo e(old('comment', $userReview->comment ?? '')); ?></textarea>
                            <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-shoe-primary">
                                <i class="bi bi-send"></i> <?php echo e($userReview ? 'Update Review' : 'Submit Review'); ?>

                            </button>
                            <?php if($userReview): ?>
                                <form action="<?php echo e(route('reviews.destroy', $userReview)); ?>" method="POST"
                                    onsubmit="return confirm('Delete your review?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <a href="<?php echo e(route('login')); ?>">Login</a> to write a review.
                </div>
            <?php endif; ?>

            
            <?php $__empty_1 = true; $__currentLoopData = $product->reviews->where('is_approved', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card p-3 mb-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong><?php echo e($review->user->name); ?></strong>
                            <div class="d-flex gap-1">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?php echo e($i <= $review->rating ? '-fill text-warning' : ' text-muted'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="mb-0 mt-2"><?php echo e($review->comment); ?></p>
                        </div>
                        <small class="text-muted"><?php echo e($review->created_at->diffForHumans()); ?></small>
                    </div>
                    <?php if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->isAdmin())): ?>
                        <form action="<?php echo e(route('reviews.destroy', $review)); ?>" method="POST" class="mt-2"
                            onsubmit="return confirm('Delete this review?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-chat-square-text fs-1"></i>
                    <p class="mt-2">No reviews yet. Be the first to review!</p>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($related->count()): ?>
        <div class="col-lg-4">
            <h5 class="fw-bold mb-3">You May Also Like</h5>
            <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3 product-card flex-row" style="height:90px">
                    <img src="<?php echo e($r->image ? asset('storage/'.$r->image) : 'https://placehold.co/90x90'); ?>"
                        style="width:90px;height:90px;object-fit:cover" class="rounded-start">
                    <div class="card-body p-2">
                        <a href="<?php echo e(route('products.show', $r)); ?>" class="text-decoration-none text-dark">
                            <p class="mb-0 fw-semibold small"><?php echo e($r->name); ?></p>
                        </a>
                        <span class="price-tag small">$<?php echo e($r->price); ?></span>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
// Interactive star rating
$('.star-label').on('mouseenter', function () {
    const val = $(this).data('val');
    $('.star-label i').each(function (i) {
        $(this).removeClass('bi-star-fill text-warning bi-star text-muted')
               .addClass(i < val ? 'bi-star-fill text-warning' : 'bi-star text-muted');
    });
}).on('click', function () {
    const val = $(this).data('val');
    $(this).find('input').prop('checked', true);
}).on('mouseleave', function () {
    const checked = $('input[name="rating"]:checked').val();
    $('.star-label i').each(function (i) {
        $(this).removeClass('bi-star-fill text-warning bi-star text-muted')
               .addClass(i < (checked || 0) ? 'bi-star-fill text-warning' : 'bi-star text-muted');
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/products/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Checkout'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-bag-check"></i> Checkout</h2>

    
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <div class="row g-5">
        
        <div class="col-md-7">
            <div class="card shadow-sm p-4">
                <h5 class="mb-4 fw-semibold"><i class="bi bi-truck"></i> Shipping Details</h5>
                <form action="<?php echo e(route('orders.place')); ?>" method="POST" id="checkout-form">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input name="shipping_name" class="form-control <?php $__errorArgs = ['shipping_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('shipping_name', auth()->user()->name)); ?>" required>
                            <?php $__errorArgs = ['shipping_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input name="shipping_phone" class="form-control <?php $__errorArgs = ['shipping_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('shipping_phone', auth()->user()->phone)); ?>" required>
                            <?php $__errorArgs = ['shipping_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                            <input name="city" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('city')); ?>" placeholder="e.g. Multan, Lahore, Karachi" required>
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Full Address <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" rows="3"
                                class="form-control <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Street, Area, Landmark..." required><?php echo e(old('shipping_address')); ?></textarea>
                            <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="card mt-4 bg-light border-0 p-3">
                        <h6 class="mb-2"><i class="bi bi-cash-coin text-success"></i> Payment Method</h6>
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-check-input" type="radio" checked disabled>
                            <span class="fw-semibold">Cash on Delivery (COD)</span>
                            <span class="badge bg-success ms-2">Available</span>
                        </div>
                        <small class="text-muted mt-1">Pay when your order is delivered.</small>
                    </div>

                    <button type="submit" class="btn btn-shoe-primary btn-lg w-100 mt-4" id="place-order-btn">
                        <i class="bi bi-check-circle"></i> Place Order
                    </button>
                </form>
            </div>
        </div>

        
        <div class="col-md-5">
            <div class="card shadow-sm p-4 sticky-top" style="top: 80px">
                <h5 class="mb-3 fw-semibold"><i class="bi bi-receipt"></i> Order Summary</h5>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <span class="fw-semibold"><?php echo e($item->product->name); ?></span>
                            <?php if($item->size): ?><br><small class="text-muted">Size: <?php echo e($item->size); ?></small><?php endif; ?>
                            <br><small class="text-muted">Qty: <?php echo e($item->quantity); ?> × $<?php echo e(number_format($item->product->price, 2)); ?></small>
                        </div>
                        <span class="fw-semibold">$<?php echo e(number_format($item->quantity * $item->product->price, 2)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Subtotal</span><span>$<?php echo e(number_format($total, 2)); ?></span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Shipping</span><span class="text-success">Free</span>
                </div>
                <div class="d-flex justify-content-between py-2 fw-bold fs-5">
                    <span>Total</span><span class="price-tag">$<?php echo e(number_format($total, 2)); ?></span>
                </div>
                <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-secondary w-100 mt-3">
                    <i class="bi bi-arrow-left"></i> Back to Cart
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
$('#checkout-form').on('submit', function () {
    $('#place-order-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Placing Order...');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/orders/checkout.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Your Cart'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-cart3"></i> Your Cart</h2>
    <?php if($items->isEmpty()): ?>
        <p class="text-muted">Your cart is empty. <a href="<?php echo e(route('products.index')); ?>">Continue shopping</a></p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle bg-white">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="cart-row-<?php echo e($item->id); ?>">
                        <td><?php echo e($item->product->name); ?> <?php if($item->size): ?><small class="text-muted">(size <?php echo e($item->size); ?>)</small><?php endif; ?></td>
                        <td>$<?php echo e(number_format($item->product->price,2)); ?></td>
                        <td><input type="number" min="1" value="<?php echo e($item->quantity); ?>" class="form-control" style="width:80px" onchange="updateCartQty(<?php echo e($item->id); ?>, this.value)"></td>
                        <td id="subtotal-<?php echo e($item->id); ?>">$<?php echo e(number_format($item->subtotal(),2)); ?></td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="removeCartItem(<?php echo e($item->id); ?>)"><i class="bi bi-trash"></i></button></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end align-items-center gap-3 mt-4">
            <h5>Total: $<span id="cart-total"><?php echo e(number_format($total,2)); ?></span></h5>
            <a href="<?php echo e(route('orders.checkout')); ?>" class="btn btn-shoe-primary btn-lg">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/cart/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'My Orders'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-bag-check"></i> My Orders</h2>

    <?php if($orders->isEmpty()): ?>
        <div class="text-center py-5">
            <i class="bi bi-bag-x fs-1 text-muted"></i>
            <h5 class="mt-3 text-muted">No orders yet.</h5>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-shoe-primary mt-2">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                        ?>
                        <tr>
                            <td><strong><?php echo e($order->order_number); ?></strong></td>
                            <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                            <td><?php echo e($order->details()->count()); ?> item(s)</td>
                            <td class="fw-bold">$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($statusColors[$order->status] ?? 'secondary'); ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3"><?php echo e($orders->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/orders/index.blade.php ENDPATH**/ ?>
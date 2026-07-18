<?php $__env->startSection('title','Orders'); ?>
<?php $__env->startSection('content'); ?>
<h2 class="fw-bold mb-4">Orders</h2>
<form class="mb-3">
<select name="status" class="form-select w-auto d-inline" onchange="this.form.submit()">
<option value="">All Statuses</option>
<?php $__currentLoopData = ['pending','processing','shipped','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')==$s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
</form>
<div class="card"><table class="table mb-0">
<thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead>
<tbody>
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php echo e($o->order_number); ?></td><td><?php echo e($o->user->name); ?></td><td>$<?php echo e($o->total_amount); ?></td>
<td><span class="badge bg-secondary"><?php echo e(ucfirst($o->status)); ?></span></td>
<td><a href="<?php echo e(route('admin.orders.show', $o)); ?>" class="btn btn-sm btn-outline-dark">View</a></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table></div>
<?php echo e($orders->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>
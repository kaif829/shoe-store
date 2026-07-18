<?php $__env->startSection('title','Reports'); ?>
<?php $__env->startSection('content'); ?>
<h2 class="fw-bold mb-4">Sales Reports</h2>
<form class="d-flex gap-2 mb-4">
<input type="date" name="from" value="<?php echo e($from); ?>" class="form-control">
<input type="date" name="to" value="<?php echo e($to); ?>" class="form-control">
<button class="btn btn-shoe-primary">Filter</button>
</form>
<div class="row g-4">
<div class="col-md-7"><div class="card p-3"><h6>Daily Sales</h6><table class="table table-sm">
<thead><tr><th>Date</th><th>Orders</th><th>Revenue</th></tr></thead>
<tbody><?php $__currentLoopData = $salesReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($s->date); ?></td><td><?php echo e($s->orders_count); ?></td><td>$<?php echo e(number_format($s->total,2)); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
</table></div></div>
<div class="col-md-5"><div class="card p-3"><h6>Best Sellers</h6><table class="table table-sm">
<thead><tr><th>Product</th><th>Units Sold</th></tr></thead>
<tbody><?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($b->name); ?></td><td><?php echo e($b->units_sold ?? 0); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
</table></div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>
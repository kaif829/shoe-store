<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<h2 class="fw-bold mb-4">Dashboard</h2>
<div class="row g-3 mb-4">
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-people fs-2 text-primary"></i><h4><?php echo e($stats['total_users']); ?></h4><small>Customers</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-bag fs-2 text-success"></i><h4><?php echo e($stats['total_products']); ?></h4><small>Products</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-receipt fs-2 text-warning"></i><h4><?php echo e($stats['total_orders']); ?></h4><small>Orders</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-cash-stack fs-2 text-danger"></i><h4>$<?php echo e(number_format($stats['total_revenue'],0)); ?></h4><small>Revenue</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-hourglass-split fs-2 text-info"></i><h4><?php echo e($stats['pending_orders']); ?></h4><small>Pending</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-exclamation-triangle fs-2 text-secondary"></i><h4><?php echo e($stats['low_stock']); ?></h4><small>Low Stock</small></div></div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-3"><h6>Sales (Last 7 Days)</h6><canvas id="salesChart" height="220"></canvas></div>
    </div>
    <div class="col-md-5">
        <div class="card p-3">
            <h6>Recent Orders</h6>
            <table class="table table-sm">
                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td><?php echo e($o->order_number); ?></td><td><?php echo e($o->user->name); ?></td><td>$<?php echo e($o->total_amount); ?></td><td><span class="badge bg-secondary"><?php echo e($o->status); ?></span></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($salesByDay->pluck('date'), 15, 512) ?>,
        datasets: [{ label: 'Revenue', data: <?php echo json_encode($salesByDay->pluck('total'), 15, 512) ?>, borderColor: '#ff6b35', tension: .3 }]
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
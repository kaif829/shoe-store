<?php $__env->startSection('title','Products'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-4"><h2 class="fw-bold">Products</h2><a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-shoe-primary"><i class="bi bi-plus"></i> Add Product</a></div>
<form class="mb-3"><input name="search" class="form-control" style="max-width:300px" placeholder="Search..." value="<?php echo e(request('search')); ?>"></form>
<div class="card"><table class="table mb-0">
<thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Rating</th><th></th></tr></thead>
<tbody>
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><img src="<?php echo e($p->image ? asset('storage/'.$p->image) : 'https://placehold.co/60'); ?>" width="50" class="rounded"></td>
<td><?php echo e($p->name); ?></td><td><?php echo e($p->category->name ?? '-'); ?></td><td>$<?php echo e($p->price); ?></td><td><?php echo e($p->stock); ?></td><td><?php echo e(number_format($p->avg_rating,1)); ?> ★</td>
<td>
<a href="<?php echo e(route('admin.products.edit', $p)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="<?php echo e(route('admin.products.destroy', $p)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table></div>
<?php echo e($products->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/products/index.blade.php ENDPATH**/ ?>
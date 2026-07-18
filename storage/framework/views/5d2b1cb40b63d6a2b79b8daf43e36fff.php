<?php $__env->startSection('title', 'Shop Shoes'); ?>
<?php $__env->startSection('content'); ?>
<div class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5">Step Into Smart Shopping</h1>
        <p class="lead">Browse our full collection or let our AI find the perfect pair for you.</p>
        <a href="<?php echo e(route('recommendation.form')); ?>" class="btn btn-shoe-primary btn-lg mt-2"><i class="bi bi-stars"></i> Get AI Recommendation</a>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3">
            <form id="filter-form" class="bg-white p-3 rounded shadow-sm">
                <input type="text" name="search" class="form-control mb-3" placeholder="Search shoes..." value="<?php echo e(request('search')); ?>">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select mb-3">
                    <option value="">All</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php if(request('category_id') == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select mb-3">
                    <option value="">Any</option>
                    <option value="male" <?php if(request('gender')=='male'): echo 'selected'; endif; ?>>Male</option>
                    <option value="female" <?php if(request('gender')=='female'): echo 'selected'; endif; ?>>Female</option>
                    <option value="unisex" <?php if(request('gender')=='unisex'): echo 'selected'; endif; ?>>Unisex</option>
                </select>
                <label class="form-label fw-semibold">Activity</label>
                <select name="activity_type" class="form-select mb-3">
                    <option value="">Any</option>
                    <?php $__currentLoopData = ['running','walking','sports','casual','gym']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($a); ?>" <?php if(request('activity_type')==$a): echo 'selected'; endif; ?>><?php echo e(ucfirst($a)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <label class="form-label fw-semibold">Price Range</label>
                <div class="d-flex gap-2 mb-3">
                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="<?php echo e(request('min_price')); ?>">
                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="<?php echo e(request('max_price')); ?>">
                </div>
            </form>
        </div>
        <div class="col-lg-9">
            <div id="product-grid"><?php echo $__env->make('products.partials.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/products/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Your Recommendations'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold mb-1">Recommended for You <i class="bi bi-stars text-warning"></i></h2>
    <p class="text-muted mb-4">Based on: <?php echo e(ucfirst($criteria['age_group'])); ?> &middot; <?php echo e(ucfirst($criteria['gender'])); ?> &middot; <?php echo e(ucfirst($criteria['activity'])); ?> &middot; <?php echo e(str_replace('_','-',$criteria['budget'])); ?></p>
    <?php echo $__env->make('recommendation.partials.results', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <a href="<?php echo e(route('recommendation.form')); ?>" class="btn btn-outline-dark mt-4"><i class="bi bi-arrow-left"></i> Try Again</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/recommendation/results.blade.php ENDPATH**/ ?>
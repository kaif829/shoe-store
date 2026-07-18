<?php $__env->startSection('title','Login'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <h3 class="mb-4 text-center">Welcome Back</h3>
                <?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?>
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required autofocus></div>
                    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="mb-3 form-check"><input type="checkbox" name="remember" class="form-check-input"><label class="form-check-label">Remember me</label></div>
                    <button class="btn btn-shoe-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3 small"><a href="<?php echo e(route('password.request')); ?>">Forgot password?</a></p>
                <p class="text-center small">No account? <a href="<?php echo e(route('register')); ?>">Sign up</a></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/auth/login.blade.php ENDPATH**/ ?>
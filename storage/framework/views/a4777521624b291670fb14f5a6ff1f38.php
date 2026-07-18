<?php $__env->startSection('title', 'AI Shoe Recommendation'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="recommend-form-card p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-stars fs-1" style="color:var(--shoe-accent)"></i>
                    <h2 class="fw-bold mt-2">Find Your Perfect Shoe</h2>
                    <p class="text-muted">Answer a few quick questions and our AI engine will recommend the best matches.</p>
                </div>
                <form action="<?php echo e(route('recommendation.submit')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Age Group</label>
                        <select name="age_group" class="form-select" required>
                            <option value="teenager">Teenager</option>
                            <option value="adult" selected>Adult</option>
                            <option value="senior">Senior</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="unisex" selected>Unisex</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Activity Type</label>
                        <select name="activity" class="form-select" required>
                            <option value="running">Running</option>
                            <option value="walking">Walking</option>
                            <option value="sports">Sports</option>
                            <option value="casual">Casual</option>
                            <option value="gym">Gym</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Budget</label>
                        <select name="budget" class="form-select" required>
                            <option value="under_50">Under $50</option>
                            <option value="50_100">$50 - $100</option>
                            <option value="100_200">$100 - $200</option>
                            <option value="above_200">Above $200</option>
                        </select>
                    </div>
                    <button class="btn btn-shoe-primary w-100 btn-lg" type="submit"><i class="bi bi-magic"></i> Recommend Shoes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/recommendation/form.blade.php ENDPATH**/ ?>
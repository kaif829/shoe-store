<?php $__env->startSection('title','Users'); ?>
<?php $__env->startSection('content'); ?>
<h2 class="fw-bold mb-4">Users Management</h2>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form class="mb-3 d-flex gap-2">
    <input name="search" class="form-control" style="max-width:300px"
        placeholder="Search name or email..." value="<?php echo e(request('search')); ?>">
    <button class="btn btn-outline-secondary">Search</button>
</form>

<div class="card shadow-sm">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($u->id); ?></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="width:36px;height:36px;font-size:14px">
                            <?php echo e(strtoupper(substr($u->name, 0, 1))); ?>

                        </div>
                        <?php echo e($u->name); ?>

                        <?php if($u->id === auth()->id()): ?>
                            <span class="badge bg-info ms-1">You</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td><?php echo e($u->email); ?></td>
                <td><?php echo e($u->phone ?? '—'); ?></td>
                <td>
                    <span class="badge bg-<?php echo e($u->role === 'admin' ? 'danger' : 'secondary'); ?>">
                        <?php echo e(ucfirst($u->role)); ?>

                    </span>
                </td>
                <td><?php echo e($u->created_at->format('d M Y')); ?></td>
                <td>
                    <?php if($u->id !== auth()->id()): ?>
                        
                        <form action="<?php echo e(route('admin.users.role', $u)); ?>" method="POST" class="d-inline"
                            onsubmit="return confirm('Change role of <?php echo e($u->name); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button class="btn btn-sm btn-outline-<?php echo e($u->role === 'admin' ? 'warning' : 'primary'); ?>"
                                title="<?php echo e($u->role === 'admin' ? 'Remove Admin' : 'Make Admin'); ?>">
                                <i class="bi bi-<?php echo e($u->role === 'admin' ? 'person-dash' : 'person-plus'); ?>"></i>
                                <?php echo e($u->role === 'admin' ? 'Remove Admin' : 'Make Admin'); ?>

                            </button>
                        </form>

                        
                        <form action="<?php echo e(route('admin.users.destroy', $u)); ?>" method="POST" class="d-inline"
                            onsubmit="return confirm('Permanently delete <?php echo e($u->name); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted small">— Your Account —</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-3"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/admin/users/index.blade.php ENDPATH**/ ?>
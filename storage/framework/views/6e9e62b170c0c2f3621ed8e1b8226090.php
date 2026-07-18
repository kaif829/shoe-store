<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'AI Shoe Store'); ?> | Premium Footwear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/css/toastr.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shoe-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo e(route('products.index')); ?>">
            <i class="bi bi-bag-heart-fill"></i> AI ShoeStore
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('products.index')); ?>">Shop</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('recommendation.form')); ?>">
                        <i class="bi bi-stars"></i> AI Recommend
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav align-items-lg-center gap-2">
                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('wishlist.index')); ?>">
                            <i class="bi bi-heart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="<?php echo e(route('cart.index')); ?>">
                            <i class="bi bi-cart3"></i>
                            <span id="cart-count" class="badge bg-danger rounded-pill">
                                <?php echo e(auth()->user()->cartItems()->sum('quantity')); ?>

                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('orders.index')); ?>">My Orders</a>
                    </li>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="<?php echo e(route('admin.dashboard')); ?>">
                                Admin Panel
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <?php echo e(auth()->user()->name); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a></li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="<?php echo e(route('register')); ?>">Sign Up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="shoe-footer text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5><i class="bi bi-bag-heart-fill"></i> AI ShoeStore</h5>
                <p class="text-light-emphasis">Your AI-powered shopping assistant for the perfect pair of shoes.</p>
            </div>
            <div class="col-md-4">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo e(route('products.index')); ?>" class="footer-link">Shop</a></li>
                    <li><a href="<?php echo e(route('recommendation.form')); ?>" class="footer-link">AI Recommendation</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Contact</h6>
                <p class="text-light-emphasis mb-0">
                    <i class="bi bi-envelope"></i> support@aishoestore.test
                </p>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="text-center text-light-emphasis mb-0">
            &copy; <?php echo e(date('Y')); ?> AI Shoe Store. All rights reserved.
        </p>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/js/toastr.min.js"></script>

<script>
    // CSRF for all AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Toastr global config
    toastr.options = {
        closeButton:       true,
        progressBar:       true,
        positionClass:     'toast-top-right',
        timeOut:           3500,
        showMethod:        'fadeIn',
        hideMethod:        'fadeOut',
        preventDuplicates: true,
    };

    // Flash session messages
    <?php if(session('success')): ?>
        toastr.success(<?php echo json_encode(session('success'), 15, 512) ?>);
    <?php endif; ?>
    <?php if(session('error')): ?>
        toastr.error(<?php echo json_encode(session('error'), 15, 512) ?>);
    <?php endif; ?>
</script>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH D:\ai-shoe-store-laravel\shoe-store\resources\views/layouts/app.blade.php ENDPATH**/ ?>
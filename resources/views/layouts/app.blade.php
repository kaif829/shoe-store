<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Shoe Store') | Premium Footwear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/css/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shoe-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
            <i class="bi bi-bag-heart-fill"></i> AI ShoeStore
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Shop</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('recommendation.form') }}">
                        <i class="bi bi-stars"></i> AI Recommend
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav align-items-lg-center gap-2">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3"></i>
                            <span id="cart-count" class="badge bg-danger rounded-pill">
                                {{ auth()->user()->cartItems()->sum('quantity') }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">My Orders</a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="{{ route('admin.dashboard') }}">
                                Admin Panel
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="{{ route('register') }}">Sign Up</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>
    @yield('content')
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
                    <li><a href="{{ route('products.index') }}" class="footer-link">Shop</a></li>
                    <li><a href="{{ route('recommendation.form') }}" class="footer-link">AI Recommendation</a></li>
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
            &copy; {{ date('Y') }} AI Shoe Store. All rights reserved.
        </p>
    </div>
</footer>

{{-- JS Libraries (order matters: jQuery first, then toastr, then app.js) --}}
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
    @if(session('success'))
        toastr.success(@json(session('success')));
    @endif
    @if(session('error'))
        toastr.error(@json(session('error')));
    @endif
</script>

<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>

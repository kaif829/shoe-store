<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Admin') | AI Shoe Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/css/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { background: #f7f7fb; }
        .admin-sidebar {
            min-height: 100vh;
            background: var(--shoe-primary);
            width: 240px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .admin-sidebar .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 1.2rem 1rem;
            display: block;
            border-bottom: 1px solid rgba(255,255,255,.1);
            text-decoration: none;
        }
        .admin-sidebar a.nav-link-item {
            color: #cfcfe0;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: .65rem 1.2rem;
            transition: all .2s;
            border-left: 3px solid transparent;
        }
        .admin-sidebar a.nav-link-item:hover,
        .admin-sidebar a.nav-link-item.active {
            background: rgba(255,255,255,.08);
            color: #fff;
            border-left-color: var(--shoe-accent);
        }
        .admin-sidebar .sidebar-divider {
            border-color: rgba(255,255,255,.1);
            margin: .5rem 1rem;
        }
        .sidebar-logout-form { padding: .5rem 1rem; }
        .sidebar-logout-btn {
            background: none;
            border: 1px solid rgba(255,255,255,.2);
            color: #cfcfe0;
            width: 100%;
            padding: .5rem 1rem;
            text-align: left;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            cursor: pointer;
        }
        .sidebar-logout-btn:hover {
            background: rgba(220,53,69,.15);
            border-color: #dc3545;
            color: #ff6b6b;
        }
        .stat-card { border-radius: 16px; border: none; }
        .admin-content { flex: 1; padding: 1.5rem; min-width: 0; }
    </style>
</head>
<body>
<div class="d-flex" style="min-height:100vh">

    {{-- Sidebar --}}
    <div class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <i class="bi bi-bag-heart-fill"></i> Admin Panel
        </a>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i> Products
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Categories
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Orders
        </a>
        <a href="{{ route('admin.reviews.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="bi bi-star"></i> Reviews
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.reports.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Reports
        </a>

        <hr class="sidebar-divider">

        <a href="{{ route('products.index') }}" class="nav-link-item" target="_blank">
            <i class="bi bi-shop"></i> View Store
        </a>

        {{-- Correct POST logout form --}}
        <div class="sidebar-logout-form mt-2">
            <form method="POST" action="{{ route('logout') }}" id="admin-logout-form">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>

        <div class="p-3 mt-auto">
            <small class="text-secondary">
                Logged in as:<br>
                <span class="text-light">{{ auth()->user()->name }}</span>
            </small>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/js/toastr.min.js"></script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3500,
    };

    @if(session('success'))
        toastr.success(@json(session('success')));
    @endif
    @if(session('error'))
        toastr.error(@json(session('error')));
    @endif
</script>
@yield('scripts')
</body>
</html>

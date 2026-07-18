@extends('layouts.app')
@section('title', 'Shop Shoes')
@section('content')
<div class="hero-section text-center">
    <div class="container">
        <h1 class="fw-bold display-5">Step Into Smart Shopping</h1>
        <p class="lead">Browse our full collection or let our AI find the perfect pair for you.</p>
        <a href="{{ route('recommendation.form') }}" class="btn btn-shoe-primary btn-lg mt-2"><i class="bi bi-stars"></i> Get AI Recommendation</a>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3">
            <form id="filter-form" class="bg-white p-3 rounded shadow-sm">
                <input type="text" name="search" class="form-control mb-3" placeholder="Search shoes..." value="{{ request('search') }}">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select mb-3">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select mb-3">
                    <option value="">Any</option>
                    <option value="male" @selected(request('gender')=='male')>Male</option>
                    <option value="female" @selected(request('gender')=='female')>Female</option>
                    <option value="unisex" @selected(request('gender')=='unisex')>Unisex</option>
                </select>
                <label class="form-label fw-semibold">Activity</label>
                <select name="activity_type" class="form-select mb-3">
                    <option value="">Any</option>
                    @foreach(['running','walking','sports','casual','gym'] as $a)
                        <option value="{{ $a }}" @selected(request('activity_type')==$a)>{{ ucfirst($a) }}</option>
                    @endforeach
                </select>
                <label class="form-label fw-semibold">Price Range</label>
                <div class="d-flex gap-2 mb-3">
                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                </div>
            </form>
        </div>
        <div class="col-lg-9">
            <div id="product-grid">@include('products.partials.grid')</div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title','Wishlist')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-heart-fill text-danger"></i> My Wishlist</h2>
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-md-3">
                <div class="card product-card">
                    <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/300x220' }}">
                    <div class="card-body">
                        <h6>{{ $item->product->name }}</h6>
                        <span class="price-tag">${{ $item->product->price }}</span>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('products.show', $item->product) }}" class="btn btn-shoe-primary w-100">View</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Your wishlist is empty.</p>
        @endforelse
    </div>
</div>
@endsection

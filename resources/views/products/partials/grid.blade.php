<div class="row g-4">
    @forelse($products as $product)
        <div class="col-sm-6 col-lg-4 col-xl-3 fade-in">
            <div class="card product-card h-100">
                <a href="{{ route('products.show', $product) }}">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://placehold.co/400x300?text='.urlencode($product->name) }}" alt="{{ $product->name }}">
                </a>
                <div class="card-body">
                    <span class="badge badge-activity text-uppercase mb-2">{{ $product->activity_type }}</span>
                    <h6 class="mb-1"><a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">{{ $product->name }}</a></h6>
                    <p class="text-muted small mb-2">{{ $product->brand }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">${{ number_format($product->price, 2) }}</span>
                        <span class="small"><i class="bi bi-star-fill text-warning"></i> {{ number_format($product->avg_rating, 1) }} ({{ $product->review_count }})</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    @auth
                        <button class="btn btn-shoe-primary w-100" onclick="addToCart({{ $product->id }})"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-dark w-100">Login to Buy</a>
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-emoji-frown fs-1 text-muted"></i>
            <p class="text-muted mt-2">No products match your filters.</p>
        </div>
    @endforelse
</div>
<div class="mt-4">{{ $products->links() }}</div>

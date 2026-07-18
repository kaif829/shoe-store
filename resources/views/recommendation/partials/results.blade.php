<div class="row g-4">
    @forelse($products as $p)
        <div class="col-md-4">
            <div class="card product-card h-100">
                <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://placehold.co/400x300?text='.urlencode($p->name) }}">
                <div class="card-body">
                    <h6>{{ $p->name }}</h6>
                    <p class="text-muted small">{{ $p->brand }}</p>
                    <span class="price-tag">${{ $p->price }}</span>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('products.show', $p) }}" class="btn btn-shoe-primary w-100">View Details</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No matches found, try different criteria.</p>
    @endforelse
</div>

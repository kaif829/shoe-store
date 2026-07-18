@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Shop</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Product Image --}}
        <div class="col-md-5">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://placehold.co/500x400?text='.urlencode($product->name) }}"
                class="img-fluid rounded-3 shadow-sm w-100" style="object-fit:cover; max-height:420px" alt="{{ $product->name }}">
        </div>

        {{-- Product Info --}}
        <div class="col-md-7">
            <span class="badge badge-activity text-uppercase mb-2">{{ $product->activity_type }}</span>
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted mb-1">{{ $product->brand }} &middot; {{ ucfirst($product->gender) }}</p>
            <p class="text-muted mb-3">Sizes: {{ $product->size_range ?? 'N/A' }}</p>

            <div class="d-flex align-items-center gap-2 mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= round($product->avg_rating) ? '-fill' : '' }} text-warning"></i>
                @endfor
                <span class="text-muted">({{ $product->review_count }} reviews)</span>
            </div>

            <h3 class="price-tag mb-3">${{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>

            <p class="mb-3">
                @if($product->stock > 10)
                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> In Stock ({{ $product->stock }})</span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> Low Stock ({{ $product->stock }} left)</span>
                @else
                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Out of Stock</span>
                @endif
            </p>

            @auth
                @if($product->stock > 0)
                    <div class="d-flex gap-2 align-items-center mt-3 flex-wrap">
                        <div class="input-group" style="width:120px">
                            <button class="btn btn-outline-secondary" onclick="$('#qty').val(Math.max(1, parseInt($('#qty').val())-1))">-</button>
                            <input type="number" id="qty" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center">
                            <button class="btn btn-outline-secondary" onclick="$('#qty').val(Math.min({{ $product->stock }}, parseInt($('#qty').val())+1))">+</button>
                        </div>
                        <button class="btn btn-shoe-primary btn-lg px-4"
                            onclick="addToCart({{ $product->id }}, parseInt($('#qty').val()))">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-danger btn-lg wishlist-icon"
                            onclick="toggleWishlist({{ $product->id }}, this)">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg mt-3">
                    <i class="bi bi-person"></i> Login to Purchase
                </a>
            @endauth
        </div>
    </div>

    <hr class="my-5">

    {{-- Reviews Section --}}
    <div class="row">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4">Customer Reviews
                <span class="fs-6 text-muted fw-normal">({{ $product->review_count }} total)</span>
            </h4>

            {{-- Success / Error alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Review Submit Form --}}
            @auth
                @php $userReview = $product->reviews->firstWhere('user_id', auth()->id()); @endphp
                <div class="card p-4 mb-4 shadow-sm">
                    <h6 class="mb-3">{{ $userReview ? 'Update Your Review' : 'Write a Review' }}</h6>
                    <form action="{{ route('reviews.store', $product) }}" method="POST" id="review-form">
                        @csrf
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                            </div>
                        @endif

                        {{-- Star Rating --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Rating</label>
                            <div class="star-rating d-flex gap-1 fs-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="star-label" data-val="{{ $i }}">
                                        <input type="radio" name="rating" value="{{ $i }}" class="d-none"
                                            {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }}>
                                        <i class="bi bi-star{{ ($userReview && $userReview->rating >= $i) ? '-fill text-warning' : ' text-muted' }}"
                                           style="cursor:pointer"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comment (optional)</label>
                            <textarea name="comment" class="form-control" rows="3"
                                placeholder="Share your experience...">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                            @error('comment')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-shoe-primary">
                                <i class="bi bi-send"></i> {{ $userReview ? 'Update Review' : 'Submit Review' }}
                            </button>
                            @if($userReview)
                                <form action="{{ route('reviews.destroy', $userReview) }}" method="POST"
                                    onsubmit="return confirm('Delete your review?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            @endif
                        </div>
                    </form>
                </div>
            @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Login</a> to write a review.
                </div>
            @endauth

            {{-- Reviews List --}}
            @forelse($product->reviews->where('is_approved', true) as $review)
                <div class="card p-3 mb-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $review->user->name }}</strong>
                            <div class="d-flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                                @endfor
                            </div>
                            <p class="mb-0 mt-2">{{ $review->comment }}</p>
                        </div>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->isAdmin()))
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="mt-2"
                            onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-chat-square-text fs-1"></i>
                    <p class="mt-2">No reviews yet. Be the first to review!</p>
                </div>
            @endforelse
        </div>

        {{-- Related Products --}}
        @if($related->count())
        <div class="col-lg-4">
            <h5 class="fw-bold mb-3">You May Also Like</h5>
            @foreach($related as $r)
                <div class="card mb-3 product-card flex-row" style="height:90px">
                    <img src="{{ $r->image ? asset('storage/'.$r->image) : 'https://placehold.co/90x90' }}"
                        style="width:90px;height:90px;object-fit:cover" class="rounded-start">
                    <div class="card-body p-2">
                        <a href="{{ route('products.show', $r) }}" class="text-decoration-none text-dark">
                            <p class="mb-0 fw-semibold small">{{ $r->name }}</p>
                        </a>
                        <span class="price-tag small">${{ $r->price }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script>
// Interactive star rating
$('.star-label').on('mouseenter', function () {
    const val = $(this).data('val');
    $('.star-label i').each(function (i) {
        $(this).removeClass('bi-star-fill text-warning bi-star text-muted')
               .addClass(i < val ? 'bi-star-fill text-warning' : 'bi-star text-muted');
    });
}).on('click', function () {
    const val = $(this).data('val');
    $(this).find('input').prop('checked', true);
}).on('mouseleave', function () {
    const checked = $('input[name="rating"]:checked').val();
    $('.star-label i').each(function (i) {
        $(this).removeClass('bi-star-fill text-warning bi-star text-muted')
               .addClass(i < (checked || 0) ? 'bi-star-fill text-warning' : 'bi-star text-muted');
    });
});
</script>
@endsection

@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-bag-check"></i> Checkout</h2>

    {{-- Error / Success Alerts --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row g-5">
        {{-- Shipping Form --}}
        <div class="col-md-7">
            <div class="card shadow-sm p-4">
                <h5 class="mb-4 fw-semibold"><i class="bi bi-truck"></i> Shipping Details</h5>
                <form action="{{ route('orders.place') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                value="{{ old('shipping_name', auth()->user()->name) }}" required>
                            @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                value="{{ old('shipping_phone', auth()->user()->phone) }}" required>
                            @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                            <input name="city" class="form-control @error('city') is-invalid @enderror"
                                value="{{ old('city') }}" placeholder="e.g. Multan, Lahore, Karachi" required>
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Full Address <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" rows="3"
                                class="form-control @error('shipping_address') is-invalid @enderror"
                                placeholder="Street, Area, Landmark..." required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="card mt-4 bg-light border-0 p-3">
                        <h6 class="mb-2"><i class="bi bi-cash-coin text-success"></i> Payment Method</h6>
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-check-input" type="radio" checked disabled>
                            <span class="fw-semibold">Cash on Delivery (COD)</span>
                            <span class="badge bg-success ms-2">Available</span>
                        </div>
                        <small class="text-muted mt-1">Pay when your order is delivered.</small>
                    </div>

                    <button type="submit" class="btn btn-shoe-primary btn-lg w-100 mt-4" id="place-order-btn">
                        <i class="bi bi-check-circle"></i> Place Order
                    </button>
                </form>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-md-5">
            <div class="card shadow-sm p-4 sticky-top" style="top: 80px">
                <h5 class="mb-3 fw-semibold"><i class="bi bi-receipt"></i> Order Summary</h5>
                @foreach($items as $item)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <span class="fw-semibold">{{ $item->product->name }}</span>
                            @if($item->size)<br><small class="text-muted">Size: {{ $item->size }}</small>@endif
                            <br><small class="text-muted">Qty: {{ $item->quantity }} × ${{ number_format($item->product->price, 2) }}</small>
                        </div>
                        <span class="fw-semibold">${{ number_format($item->quantity * $item->product->price, 2) }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Subtotal</span><span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Shipping</span><span class="text-success">Free</span>
                </div>
                <div class="d-flex justify-content-between py-2 fw-bold fs-5">
                    <span>Total</span><span class="price-tag">${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-3">
                    <i class="bi bi-arrow-left"></i> Back to Cart
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$('#checkout-form').on('submit', function () {
    $('#place-order-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Placing Order...');
});
</script>
@endsection

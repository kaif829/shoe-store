@extends('layouts.app')
@section('title', 'Your Cart')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-cart3"></i> Your Cart</h2>
    @if($items->isEmpty())
        <p class="text-muted">Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a></p>
    @else
        <div class="table-responsive">
            <table class="table align-middle bg-white">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                <tbody>
                @foreach($items as $item)
                    <tr id="cart-row-{{ $item->id }}">
                        <td>{{ $item->product->name }} @if($item->size)<small class="text-muted">(size {{ $item->size }})</small>@endif</td>
                        <td>${{ number_format($item->product->price,2) }}</td>
                        <td><input type="number" min="1" value="{{ $item->quantity }}" class="form-control" style="width:80px" onchange="updateCartQty({{ $item->id }}, this.value)"></td>
                        <td id="subtotal-{{ $item->id }}">${{ number_format($item->subtotal(),2) }}</td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="removeCartItem({{ $item->id }})"><i class="bi bi-trash"></i></button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end align-items-center gap-3 mt-4">
            <h5>Total: $<span id="cart-total">{{ number_format($total,2) }}</span></h5>
            <a href="{{ route('orders.checkout') }}" class="btn btn-shoe-primary btn-lg">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection

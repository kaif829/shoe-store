@extends('layouts.app')
@section('title', 'Order #'.$order->order_number)
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Success Banner --}}
            @if(session('success'))
            <div class="text-center mb-4">
                <div class="card p-4 bg-success bg-opacity-10 border-success">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <h4 class="mt-2 text-success">{{ session('success') }}</h4>
                </div>
            </div>
            @endif

            <div class="card shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Order #{{ $order->order_number }}</h4>
                    @php
                        $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                    @endphp
                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} fs-6">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <p class="text-muted small mb-4"><i class="bi bi-clock"></i> Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>

                {{-- Order Items --}}
                <h6 class="fw-semibold mb-3">Items Ordered</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr><th>Product</th><th>Size</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                        @foreach($order->details as $d)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $d->product->image ? asset('storage/'.$d->product->image) : 'https://placehold.co/50x50' }}"
                                            width="50" class="rounded">
                                        {{ $d->product->name }}
                                    </div>
                                </td>
                                <td>{{ $d->size ?? 'N/A' }}</td>
                                <td>{{ $d->quantity }}</td>
                                <td>${{ number_format($d->unit_price, 2) }}</td>
                                <td>${{ number_format($d->quantity * $d->unit_price, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <h5 class="fw-bold">Total: <span class="price-tag">${{ number_format($order->total_amount, 2) }}</span></h5>
                </div>

                <hr>

                {{-- Shipping Info --}}
                <h6 class="fw-semibold mb-2">Shipping Details</h6>
                <p class="mb-1"><i class="bi bi-person"></i> {{ $order->shipping_name }}</p>
                <p class="mb-1"><i class="bi bi-telephone"></i> {{ $order->shipping_phone }}</p>
                <p class="mb-1"><i class="bi bi-geo-alt"></i> {{ $order->shipping_address }}, {{ $order->city }}</p>
                <p class="mb-0"><i class="bi bi-cash-coin"></i> Payment: <strong>Cash on Delivery</strong></p>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">
                        <i class="bi bi-list-ul"></i> All Orders
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-shoe-primary">
                        <i class="bi bi-shop"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

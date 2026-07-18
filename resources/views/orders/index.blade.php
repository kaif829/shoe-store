@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-bag-check"></i> My Orders</h2>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x fs-1 text-muted"></i>
            <h5 class="mt-3 text-muted">No orders yet.</h5>
            <a href="{{ route('products.index') }}" class="btn btn-shoe-primary mt-2">Start Shopping</a>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        @php
                            $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                        @endphp
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->details()->count() }} item(s)</td>
                            <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection

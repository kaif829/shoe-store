@extends('layouts.admin')
@section('title','Order #'.$order->order_number)
@section('content')
<h2 class="fw-bold mb-3">Order #{{ $order->order_number }}</h2>
<div class="card p-4 mb-3">
<p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
<p><strong>Shipping:</strong> {{ $order->shipping_name }}, {{ $order->shipping_address }}, {{ $order->city }} - {{ $order->shipping_phone }}</p>
<form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-flex gap-2 align-items-center">
@csrf @method('PATCH')
<label>Status:</label>
<select name="status" class="form-select w-auto">
@foreach(['pending','processing','shipped','delivered','cancelled'] as $s)<option value="{{ $s }}" @selected($order->status==$s)>{{ ucfirst($s) }}</option>@endforeach
</select>
<button class="btn btn-shoe-primary btn-sm">Update</button>
</form>
</div>
<table class="table bg-white">
<thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead>
<tbody>
@foreach($order->details as $d)<tr><td>{{ $d->product->name }}</td><td>{{ $d->quantity }}</td><td>${{ $d->unit_price }}</td></tr>@endforeach
</tbody>
</table>
<h5>Total: ${{ number_format($order->total_amount,2) }}</h5>
@endsection

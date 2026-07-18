@extends('layouts.admin')
@section('title','Orders')
@section('content')
<h2 class="fw-bold mb-4">Orders</h2>
<form class="mb-3">
<select name="status" class="form-select w-auto d-inline" onchange="this.form.submit()">
<option value="">All Statuses</option>
@foreach(['pending','processing','shipped','delivered','cancelled'] as $s)<option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>@endforeach
</select>
</form>
<div class="card"><table class="table mb-0">
<thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($orders as $o)
<tr>
<td>{{ $o->order_number }}</td><td>{{ $o->user->name }}</td><td>${{ $o->total_amount }}</td>
<td><span class="badge bg-secondary">{{ ucfirst($o->status) }}</span></td>
<td><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-dark">View</a></td>
</tr>
@endforeach
</tbody>
</table></div>
{{ $orders->links() }}
@endsection

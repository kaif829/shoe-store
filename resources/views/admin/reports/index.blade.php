@extends('layouts.admin')
@section('title','Reports')
@section('content')
<h2 class="fw-bold mb-4">Sales Reports</h2>
<form class="d-flex gap-2 mb-4">
<input type="date" name="from" value="{{ $from }}" class="form-control">
<input type="date" name="to" value="{{ $to }}" class="form-control">
<button class="btn btn-shoe-primary">Filter</button>
</form>
<div class="row g-4">
<div class="col-md-7"><div class="card p-3"><h6>Daily Sales</h6><table class="table table-sm">
<thead><tr><th>Date</th><th>Orders</th><th>Revenue</th></tr></thead>
<tbody>@foreach($salesReport as $s)<tr><td>{{ $s->date }}</td><td>{{ $s->orders_count }}</td><td>${{ number_format($s->total,2) }}</td></tr>@endforeach</tbody>
</table></div></div>
<div class="col-md-5"><div class="card p-3"><h6>Best Sellers</h6><table class="table table-sm">
<thead><tr><th>Product</th><th>Units Sold</th></tr></thead>
<tbody>@foreach($bestSellers as $b)<tr><td>{{ $b->name }}</td><td>{{ $b->units_sold ?? 0 }}</td></tr>@endforeach</tbody>
</table></div></div>
</div>
@endsection

@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<h2 class="fw-bold mb-4">Dashboard</h2>
<div class="row g-3 mb-4">
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-people fs-2 text-primary"></i><h4>{{ $stats['total_users'] }}</h4><small>Customers</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-bag fs-2 text-success"></i><h4>{{ $stats['total_products'] }}</h4><small>Products</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-receipt fs-2 text-warning"></i><h4>{{ $stats['total_orders'] }}</h4><small>Orders</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-cash-stack fs-2 text-danger"></i><h4>${{ number_format($stats['total_revenue'],0) }}</h4><small>Revenue</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-hourglass-split fs-2 text-info"></i><h4>{{ $stats['pending_orders'] }}</h4><small>Pending</small></div></div>
    <div class="col-md-2"><div class="card stat-card p-3 text-center"><i class="bi bi-exclamation-triangle fs-2 text-secondary"></i><h4>{{ $stats['low_stock'] }}</h4><small>Low Stock</small></div></div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-3"><h6>Sales (Last 7 Days)</h6><canvas id="salesChart" height="220"></canvas></div>
    </div>
    <div class="col-md-5">
        <div class="card p-3">
            <h6>Recent Orders</h6>
            <table class="table table-sm">
                @foreach($recentOrders as $o)
                    <tr><td>{{ $o->order_number }}</td><td>{{ $o->user->name }}</td><td>${{ $o->total_amount }}</td><td><span class="badge bg-secondary">{{ $o->status }}</span></td></tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($salesByDay->pluck('date')),
        datasets: [{ label: 'Revenue', data: @json($salesByDay->pluck('total')), borderColor: '#ff6b35', tension: .3 }]
    }
});
</script>
@endsection

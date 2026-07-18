@extends('layouts.admin')
@section('title','Products')
@section('content')
<div class="d-flex justify-content-between mb-4"><h2 class="fw-bold">Products</h2><a href="{{ route('admin.products.create') }}" class="btn btn-shoe-primary"><i class="bi bi-plus"></i> Add Product</a></div>
<form class="mb-3"><input name="search" class="form-control" style="max-width:300px" placeholder="Search..." value="{{ request('search') }}"></form>
<div class="card"><table class="table mb-0">
<thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Rating</th><th></th></tr></thead>
<tbody>
@foreach($products as $p)
<tr>
<td><img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://placehold.co/60' }}" width="50" class="rounded"></td>
<td>{{ $p->name }}</td><td>{{ $p->category->name ?? '-' }}</td><td>${{ $p->price }}</td><td>{{ $p->stock }}</td><td>{{ number_format($p->avg_rating,1) }} ★</td>
<td>
<a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
<form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td>
</tr>
@endforeach
</tbody>
</table></div>
{{ $products->links() }}
@endsection

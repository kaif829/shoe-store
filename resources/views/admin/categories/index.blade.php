@extends('layouts.admin')
@section('title','Categories')
@section('content')
<h2 class="fw-bold mb-4">Categories</h2>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-3">
            <h6>Add Category</h6>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input name="name" class="form-control mb-2" placeholder="Category name" required>
                <input name="icon" class="form-control mb-2" placeholder="Bootstrap icon class (optional)">
                <button class="btn btn-shoe-primary w-100">Add</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card"><table class="table mb-0">
            <thead><tr><th>Name</th><th>Products</th><th></th></tr></thead>
            <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td><i class="bi {{ $cat->icon }}"></i> {{ $cat->name }}</td>
                    <td>{{ $cat->products_count }}</td>
                    <td><form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td>
                </tr>
            @endforeach
            </tbody>
        </table></div>
    </div>
</div>
@endsection

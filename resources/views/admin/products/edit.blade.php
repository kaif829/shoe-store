@extends('layouts.admin')
@section('title','Edit Product')
@section('content')
<h2 class="fw-bold mb-4">Edit Product</h2>
<div class="card p-4">
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
@include('admin.products._form')
<button class="btn btn-shoe-primary">Update Product</button>
</form>
</div>
@endsection

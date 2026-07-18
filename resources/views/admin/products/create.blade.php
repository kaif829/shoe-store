@extends('layouts.admin')
@section('title','Add Product')
@section('content')
<h2 class="fw-bold mb-4">Add Product</h2>
<div class="card p-4">
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf
@include('admin.products._form')
<button class="btn btn-shoe-primary">Create Product</button>
</form>
</div>
@endsection

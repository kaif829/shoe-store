@extends('layouts.app')
@section('content')
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
<div class="card p-4">
    <h4 class="mb-3">Reset Password</h4>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" value="{{ old('email', $request->email) }}" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="New Password" required>
        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirm Password" required>
        <button class="btn btn-shoe-primary w-100">Reset Password</button>
    </form>
</div>
</div></div></div>
@endsection

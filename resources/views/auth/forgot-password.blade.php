@extends('layouts.app')
@section('content')
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
<div class="card p-4">
    <h4 class="mb-3">Forgot Password</h4>
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" class="form-control mb-3" placeholder="Your email" required>
        <button class="btn btn-shoe-primary w-100">Send Reset Link</button>
    </form>
</div>
</div></div></div>
@endsection

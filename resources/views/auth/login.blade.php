@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <h3 class="mb-4 text-center">Welcome Back</h3>
                @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required autofocus></div>
                    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="mb-3 form-check"><input type="checkbox" name="remember" class="form-check-input"><label class="form-check-label">Remember me</label></div>
                    <button class="btn btn-shoe-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3 small"><a href="{{ route('password.request') }}">Forgot password?</a></p>
                <p class="text-center small">No account? <a href="{{ route('register') }}">Sign up</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

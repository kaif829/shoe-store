@extends('layouts.app')
@section('content')
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
<div class="card p-4">
    <h4 class="mb-3">Confirm Password</h4>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button class="btn btn-shoe-primary w-100">Confirm</button>
    </form>
</div>
</div></div></div>
@endsection

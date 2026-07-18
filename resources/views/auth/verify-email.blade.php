@extends('layouts.app')
@section('content')
<div class="container py-5 text-center">
    <i class="bi bi-envelope-check fs-1 text-warning"></i>
    <h4 class="mt-3">Verify Your Email</h4>
    <p class="text-muted">We've sent a verification link to your email address.</p>
    @if(session('status') === 'verification-link-sent')<div class="alert alert-success">A new link has been sent!</div>@endif
    <form method="POST" action="{{ route('verification.send') }}">@csrf<button class="btn btn-shoe-primary">Resend Verification Email</button></form>
</div>
@endsection

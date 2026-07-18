@extends('layouts.app')
@section('title','My Profile')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">My Profile</h2>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="mb-3">Profile Information</h5>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ $user->name }}"></div>
                    <div class="mb-3"><label class="form-label">Email</label><input name="email" class="form-control" value="{{ $user->email }}"></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ $user->phone }}"></div>
                    <button class="btn btn-shoe-primary">Save Changes</button>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="mb-3">Change Password</h5>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')
                    <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="password" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control"></div>
                    <button class="btn btn-shoe-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

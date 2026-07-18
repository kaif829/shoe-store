@extends('layouts.admin')
@section('title','Users')
@section('content')
<h2 class="fw-bold mb-4">Users Management</h2>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form class="mb-3 d-flex gap-2">
    <input name="search" class="form-control" style="max-width:300px"
        placeholder="Search name or email..." value="{{ request('search') }}">
    <button class="btn btn-outline-secondary">Search</button>
</form>

<div class="card shadow-sm">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="width:36px;height:36px;font-size:14px">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        {{ $u->name }}
                        @if($u->id === auth()->id())
                            <span class="badge bg-info ms-1">You</span>
                        @endif
                    </div>
                </td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->phone ?? '—' }}</td>
                <td>
                    <span class="badge bg-{{ $u->role === 'admin' ? 'danger' : 'secondary' }}">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td>{{ $u->created_at->format('d M Y') }}</td>
                <td>
                    @if($u->id !== auth()->id())
                        {{-- Toggle Role --}}
                        <form action="{{ route('admin.users.role', $u) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Change role of {{ $u->name }}?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-{{ $u->role === 'admin' ? 'warning' : 'primary' }}"
                                title="{{ $u->role === 'admin' ? 'Remove Admin' : 'Make Admin' }}">
                                <i class="bi bi-{{ $u->role === 'admin' ? 'person-dash' : 'person-plus' }}"></i>
                                {{ $u->role === 'admin' ? 'Remove Admin' : 'Make Admin' }}
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Permanently delete {{ $u->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @else
                        <span class="text-muted small">— Your Account —</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection

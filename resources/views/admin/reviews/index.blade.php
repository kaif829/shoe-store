@extends('layouts.admin')
@section('title','Reviews')
@section('content')

<h2 class="fw-bold mb-4">Reviews Management</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Customer</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($reviews as $r)
            <tr>
                <td><strong>{{ $r->product->name ?? 'Deleted' }}</strong></td>
                <td>{{ $r->user->name ?? 'Deleted' }}</td>
                <td>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= $r->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                    @endfor
                </td>
                <td>
                    {{ strlen($r->comment) > 50 ? substr($r->comment, 0, 50).'...' : $r->comment }}
                </td>
                <td>
                    <span class="badge {{ $r->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $r->is_approved ? 'Approved' : 'Hidden' }}
                    </span>
                </td>
                <td>{{ $r->created_at->format('d M Y') }}</td>
                <td>
                    <form action="{{ route('admin.reviews.approve', $r) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-secondary" title="Toggle Approval">
                            <i class="bi bi-{{ $r->is_approved ? 'eye-slash' : 'eye' }}"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.reviews.destroy', $r) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this review?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-star fs-1"></i><br>No reviews yet.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $reviews->links() }}</div>
@endsection

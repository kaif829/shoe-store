@extends('layouts.app')
@section('title', 'Your Recommendations')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">Recommended for You <i class="bi bi-stars text-warning"></i></h2>
    <p class="text-muted mb-4">Based on: {{ ucfirst($criteria['age_group']) }} &middot; {{ ucfirst($criteria['gender']) }} &middot; {{ ucfirst($criteria['activity']) }} &middot; {{ str_replace('_','-',$criteria['budget']) }}</p>
    @include('recommendation.partials.results')
    <a href="{{ route('recommendation.form') }}" class="btn btn-outline-dark mt-4"><i class="bi bi-arrow-left"></i> Try Again</a>
</div>
@endsection

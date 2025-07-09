@extends('layouts.app')

@section('title', 'Search Results' . (isset($query) && $query ? ' for "' . e($query) . '"' : ''))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('search') }}">
                        <input type="hidden" name="query" value="{{ $query ?? '' }}">

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (isset($category_id) && $category_id == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="e.g., City, State" value="{{ $location ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="min_price" class="form-label">Min Price ({{ config('settings.currency_symbol') }})</label>
                            <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0" value="{{ $min_price ?? '' }}" min="0">
                        </div>

                        <div class="mb-3">
                            <label for="max_price" class="form-label">Max Price ({{ config('settings.currency_symbol') }})</label>
                            <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Any" value="{{ $max_price ?? '' }}" min="0">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    @if(isset($query) && $query)
                        <h2 class="h4">Search Results for "<span class="fw-bold text-primary">{{ e($query) }}</span>"</h2>
                    @else
                        <h2 class="h4">Browse Services</h2>
                    @endif
                    <p class="text-muted mb-0">{{ $services->total() }} services found.</p>
                </div>
                <div>
                    <form method="GET" action="{{ route('search') }}" class="d-inline-block">
                        <input type="hidden" name="query" value="{{ $query ?? '' }}">
                        <input type="hidden" name="category_id" value="{{ $category_id ?? '' }}">
                        <input type="hidden" name="location" value="{{ $location ?? '' }}">
                        <input type="hidden" name="min_price" value="{{ $min_price ?? '' }}">
                        <input type="hidden" name="max_price" value="{{ $max_price ?? '' }}">
                        <select name="sort_by" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                            <option value="relevance" {{ (isset($sort_by) && $sort_by == 'relevance') ? 'selected' : '' }}>Sort by Relevance</option>
                            <option value="price_asc" {{ (isset($sort_by) && $sort_by == 'price_asc') ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ (isset($sort_by) && $sort_by == 'price_desc') ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="new_first" {{ (isset($sort_by) && $sort_by == 'new_first') ? 'selected' : '' }}>Newest First</option>
                            {{-- Add more sort options if needed --}}
                        </select>
                    </form>
                </div>
            </div>

            @if($services->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($services as $service)
                        <div class="col">
                            @include('partials.service_card', ['service' => $service])
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $services->appends(request()->query())->links() }}
                </div>
            @else
                <div class="card text-center shadow-sm">
                    <div class="card-body py-5">
                        <i class="bi bi-emoji-frown fs-1 text-warning"></i>
                        <h3 class="card-title mt-3">No Services Found</h3>
                        <p class="card-text">
                            We couldn't find any services matching your criteria. Try adjusting your search query or filters.
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-2">Back to Home</a>
                        @if(isset($query) || isset($category_id) || isset($location) || isset($min_price) || isset($max_price))
                            <a href="{{ route('search') }}" class="btn btn-outline-secondary mt-2">Clear Filters</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Basic styling to match royal theme - can be expanded in main CSS */
    .card-header.bg-primary {
        background-color: #4a00e0 !important; /* Example primary color */
    }
    .btn-primary {
        background-color: #4a00e0;
        border-color: #4a00e0;
    }
    .btn-primary:hover {
        background-color: #3a00b0;
        border-color: #3a00b0;
    }
    .text-primary {
        color: #4a00e0 !important;
    }
    .page-item.active .page-link {
        background-color: #4a00e0;
        border-color: #4a00e0;
    }
    .page-link {
        color: #4a00e0;
    }
    .page-link:hover {
        color: #3a00b0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Potential JS for enhancing filter interactions, e.g., AJAX filtering
    // For now, standard form submissions are used.
</script>
@endpush

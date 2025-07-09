@extends('layouts.app')

@section('title', __('Services in') . ' ' . ($category ?? __('All Categories')))

@section('content')
<div class="container">
    <div class="row">
        <!-- Filters Sidebar (Placeholder) -->
        <div class="col-md-3">
            <h4>@lang('Filters')</h4>
            <hr>
            {{-- Price Range Filter --}}
            <form action="{{ route('services.category', ['category' => $category]) }}" method="GET">
            <div class="mb-3">
                <h5>@lang('Price Range')</h5>
                <label for="price_from" class="form-label">@lang('From')</label>
                <input type="number" class="form-control form-control-sm mb-1" id="price_from" name="price_from" placeholder="e.g., 100" value="{{ $filters['price_from'] ?? '' }}">
                <label for="price_to" class="form-label">@lang('To')</label>
                <input type="number" class="form-control form-control-sm" id="price_to" name="price_to" placeholder="e.g., 1000" value="{{ $filters['price_to'] ?? '' }}">
            </div>

            {{-- Other Filters (e.g., location, rating) --}}
            <div class="mb-3">
                <h5>@lang('Location')</h5>
                <input type="text" class="form-control form-control-sm" name="location_filter" placeholder="@lang('Enter city or area')" value="{{ $filters['location_filter'] ?? '' }}">
            </div>

            <div class="mb-3">
                <h5>@lang('Rating')</h5>
                @for ($i = 5; $i >= 1; $i--)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $i }}" id="rating_{{ $i }}">
                    <label class="form-check-label" for="rating_{{ $i }}">
                        @for ($s = 0; $s < $i; $s++) &#9733; @endfor {{-- Solid stars --}}
                        @for ($s = $i; $s < 5; $s++) &#9734; @endfor {{-- Outline stars --}}
                        @lang('and up')
                    </label>
                </div>
                @endfor
            </div>
            <button type="submit" class="btn btn-royal w-100">@lang('Apply Filters')</button>
            </form>
        </div>

        <!-- Service Listing -->
        <div class="col-md-9">
            <h1 class="mb-4">@lang('Services in Category:') {{ $categoryTitle ?? ucfirst(str_replace('-', ' ', $category ?? __('All'))) }}</h1>
            {{-- Breadcrumbs Placeholder --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                    @if(isset($category) && $category !== 'all')
                        <li class="breadcrumb-item"><a href="{{ route('services.category', ['category' => 'all']) }}">@lang('All Services')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $categoryTitle ?? ucfirst(str_replace('-', ' ', $category)) }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">@lang('All Services')</li>
                    @endif
                </ol>
            </nav>

            {{-- Sorting Options --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    @if(isset($services) && $services->total() > 0)
                        <small class="text-muted">@lang('Showing :first - :last of :total results', ['first' => $services->firstItem(), 'last' => $services->lastItem(), 'total' => $services->total()])</small>
                    @endif
                </div>
                <select class="form-select form-select-sm w-auto" name="sort_by" onchange="this.form.submit()">
                    <option value="default" {{ ($filters['sort_by'] ?? 'default') == 'default' ? 'selected' : '' }}>@lang('Default Sorting')</option>
                    <option value="price_asc" {{ ($filters['sort_by'] ?? '') == 'price_asc' ? 'selected' : '' }}>@lang('Price: Low to High')</option>
                    <option value="price_desc" {{ ($filters['sort_by'] ?? '') == 'price_desc' ? 'selected' : '' }}>@lang('Price: High to Low')</option>
                    <option value="rating_desc" {{ ($filters['sort_by'] ?? '') == 'rating_desc' ? 'selected' : '' }}>@lang('Rating: High to Low')</option>
                </select>
            </div>
            {{-- End of form for filters and sorting --}}

            <div class="row">
                @if(isset($services) && $services->count() > 0)
                    @foreach($services as $service)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('services.show', ['slug' => $service->slug]) }}">
                                <img src="{{ $service->featured_image_url }}" class="card-img-top" alt="{{ $service->title }}" style="height: 200px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="text-decoration-none" style="color: #5D4037;">{{ Str::limit($service->title, 50) }}</a></h5>
                                @if($service->vendor)
                                <p class="card-text text-muted small">@lang('By:') <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}">{{ $service->vendor->name }}</a></p>
                                @endif
                                <p class="card-text flex-grow-1">{{ Str::limit($service->short_desc, 100) }}</p>
                                <p class="card-text fw-bold">
                                    @if($service->price_from && $service->price_to && $service->price_from != $service->price_to)
                                        ${{ number_format($service->price_from, 2) }} - ${{ number_format($service->price_to, 2) }}
                                    @elseif($service->price_from)
                                        @lang('From') ${{ number_format($service->price_from, 2) }}
                                    @else
                                        @lang('Contact for Price')
                                    @endif
                                    @if($service->unit)<small class="text-muted"> / {{ $service->unit }}</small>@endif
                                </p>
                                <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="btn btn-royal mt-auto align-self-start">@lang('View Details')</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            @lang('No services found in this category matching your criteria.')
                        </div>
                    </div>
                @endif
            </div>

            {{-- Pagination Links --}}
            <div class="d-flex justify-content-center mt-4">
                @if(isset($services))
                    {{ $services->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Placeholder for JavaScript related to filters or sorting
    console.log('Service category page loaded.');
</script>
@endpush

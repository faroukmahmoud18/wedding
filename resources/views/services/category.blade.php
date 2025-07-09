@extends('layouts.app')

@section('title', __('Services in') . ' ' . ($categoryName ?? __('All Categories')))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white" style="background-color: #4a00e0 !important;">
                    <h5 class="mb-0">@lang('Filters')</h5>
                </div>
                <div class="card-body">
                    {{-- The form action will point to the current category or 'all' services --}}
                    <form method="GET" action="{{ route('services.category', ['category' => $categorySlug ?? 'all']) }}" id="filterFormSidebar">
                        {{-- Hidden input for sort_by to persist sorting when filters change --}}
                        <input type="hidden" name="sort_by" value="{{ $sort_by ?? 'new_first' }}">

                        {{-- Category Filter (only if viewing "all" services, otherwise it's fixed by the route) --}}
                        @if(!isset($currentCategory) || $categorySlug === 'all')
                        <div class="mb-3">
                            <label for="category_filter_id" class="form-label">@lang('Category')</label>
                            <select name="category_filter_id" id="category_filter_id" class="form-select" onchange="
                                let selectedCategorySlug = this.options[this.selectedIndex].dataset.slug;
                                if (selectedCategorySlug) {
                                    window.location.href = '{{ url('services/category') }}/' + selectedCategorySlug + window.location.search.replace(/category_filter_id=[^&]*&?/, '').replace(/page=[^&]*&?/, '');
                                } else {
                                    // If "All Categories" is selected, submit the form to go to services/category/all with other filters
                                    document.getElementById('filterFormSidebar').action = '{{ route('services.category', ['category' => 'all']) }}';
                                    document.getElementById('filterFormSidebar').submit();
                                }
                            ">
                                <option value="" data-slug="all" {{ (!isset($currentCategory)) ? 'selected' : '' }}>@lang('All Categories')</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" data-slug="{{ $cat->slug }}" {{ (isset($currentCategory) && $currentCategory->id == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        {{-- If a category is selected via URL, show it as non-editable or provide a link to all categories --}}
                        <div class="mb-3">
                             <label class="form-label">@lang('Category')</label>
                             <p><strong>{{ $categoryName }}</strong><br>
                                <a href="{{ route('services.category', ['category' => 'all']) }}" class="small">@lang('View all categories')</a></p>
                        </div>
                        @endif


                        <div class="mb-3">
                            <label for="location" class="form-label">@lang('Location')</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="@lang('e.g., City, State')" value="{{ $location ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="min_price" class="form-label">@lang('Min Price') ({{ config('settings.currency_symbol', '$') }})</label>
                            <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0" value="{{ $min_price ?? '' }}" min="0">
                        </div>

                        <div class="mb-3">
                            <label for="max_price" class="form-label">@lang('Max Price') ({{ config('settings.currency_symbol', '$') }})</label>
                            <input type="number" name="max_price" id="max_price" class="form-control" placeholder="@lang('Any')" value="{{ $max_price ?? '' }}" min="0">
                        </div>
                        {{-- Add rating filter inputs if needed, similar to search page --}}

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-royal">@lang('Apply Filters')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                    @if(isset($currentCategory))
                        <li class="breadcrumb-item"><a href="{{ route('services.category', ['category' => 'all']) }}">@lang('All Services')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">@lang('All Services')</li>
                    @endif
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4">@lang('Services in') {{ $categoryName }}</h2>
                    @if($services->total() > 0)
                        <p class="text-muted mb-0">@lang('Showing :first - :last of :total results', ['first' => $services->firstItem(), 'last' => $services->lastItem(), 'total' => $services->total()])</p>
                    @else
                         <p class="text-muted mb-0">@lang('No services found.')</p>
                    @endif
                </div>
                <div>
                    <form method="GET" action="{{ route('services.category', ['category' => $categorySlug ?? 'all']) }}" id="sortForm" class="d-inline-block">
                        {{-- Persist other filters --}}
                        @if(isset($location)) <input type="hidden" name="location" value="{{ $location }}"> @endif
                        @if(isset($min_price)) <input type="hidden" name="min_price" value="{{ $min_price }}"> @endif
                        @if(isset($max_price)) <input type="hidden" name="max_price" value="{{ $max_price }}"> @endif
                        {{-- If category is filtered by URL, no need to include category_filter_id from sidebar here unless it's 'all' --}}

                        <select name="sort_by" class="form-select form-select-sm d-inline-block w-auto" onchange="document.getElementById('sortForm').submit()">
                            <option value="new_first" {{ ($sort_by ?? 'new_first') == 'new_first' ? 'selected' : '' }}>@lang('Newest First')</option>
                            <option value="price_asc" {{ ($sort_by ?? '') == 'price_asc' ? 'selected' : '' }}>@lang('Price: Low to High')</option>
                            <option value="price_desc" {{ ($sort_by ?? '') == 'price_desc' ? 'selected' : '' }}>@lang('Price: High to Low')</option>
                            {{-- Add more sort options if needed, e.g., rating --}}
                        </select>
                    </form>
                </div>
            </div>

            @if($services->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($services as $service)
                        <div class="col">
                            {{-- Assuming you have a partial for service cards similar to search results --}}
                            {{-- If not, replicate the card structure from search/results.blade.php or keep existing --}}
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
                        {{-- <i class="bi bi-emoji-frown fs-1 text-warning"></i> --}}
                        <h3 class="card-title mt-3">@lang('No Services Found')</h3>
                        <p class="card-text">
                            @lang('We couldn\'t find any services in this category matching your criteria. Try adjusting your filters or exploring other categories.')
                        </p>
                        <a href="{{ route('services.category', ['category' => 'all']) }}" class="btn btn-primary btn-royal mt-2">@lang('View All Services')</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styles from search/results.blade.php for consistency if needed, or define unique styles */
    .card-header.bg-primary {
        background-color: #4a00e0 !important; /* Example primary color from search results */
    }
    .btn-primary.btn-royal { /* More specific selector for royal theme buttons */
        background-color: #795548; /* Main action button color (brown) */
        border-color: #5D4037; /* Darker border */
        color: #FFFFFF; /* White text */
    }
    .btn-primary.btn-royal:hover {
        background-color: #5D4037;
        border-color: #4E342E;
        color: #FFFFFF;
    }
    .page-item.active .page-link {
        background-color: #795548; /* Royal theme pagination */
        border-color: #795548;
    }
    .page-link {
        color: #795548; /* Royal theme pagination link color */
    }
    .page-link:hover {
        color: #5D4037;
    }
</style>
@endpush

@push('scripts')
<script>
    // Any specific JS for this page, e.g., if enhancing filter interactions
</script>
@endpush

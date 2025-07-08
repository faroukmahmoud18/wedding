{{-- resources/views/services-category.blade.php --}}
@extends('layouts.app')

{{-- The title will be set dynamically by JavaScript based on the category --}}
@section('title', __('Service Category'))

@section('content')
<div class="container py-5">
    {{-- Page Header: Title and Description (will be populated by JS) --}}
    <div id="categoryHeader" class="text-center mb-5" style="display: none;"> {{-- Initially hidden --}}
        <div class="d-inline-block mb-3" id="categoryIconContainer" style="color: var(--royal-gold); font-size: 3.5rem; opacity:0.8;">
            {{-- Icon will be injected here by JS --}}
        </div>
        <h1 class="font-serif display-4 fw-bold mb-3" id="categoryTitle" style="color: var(--royal-deep-brown);"></h1>
        <p class="lead mx-auto" id="categoryDescription" style="color: var(--muted-text); max-width: 700px;"></p>
        <div class="d-flex justify-content-center mt-4">
            <div class="royal-border-element" style="width: 150px;"></div>
        </div>
    </div>
    <div id="categoryLoading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">{{ __('Loading...') }}</span>
        </div>
        <p class="mt-3 font-serif">{{ __('Loading category details...') }}</p>
    </div>
     <div id="categoryNotFound" class="text-center py-5" style="display: none;">
        <svg class="royal-motif mx-auto mb-3" width="60" height="60" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); opacity: 0.5;">
            <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" opacity="0.8"/>
            <circle cx="12" cy="12" r="3" />
        </svg>
        <h2 class="font-serif h3" style="color: var(--royal-deep-brown);">{{__('Category Not Found')}}</h2>
        <p style="color: var(--muted-text);">{{__('The category you are looking for does not exist or is unavailable.')}}</p>
        <a href="{{ url('/') }}" class="btn btn-royal mt-3">{{__('Go to Homepage')}}</a>
    </div>


    {{-- Filters Section (Static HTML, JS can interact if needed later) --}}
    <div id="filtersSection" class="mb-5 p-3 p-md-4 card card-royal shadow-sm" style="display: none;">
        <div class="row g-3 align-items-end">
            <div class="col-md-6 col-lg-3">
                <label for="sortBy" class="form-label small fw-semibold">{{ __('Sort by') }}</label>
                <select id="sortBy" class="form-select">
                    <option value="popularity" selected>{{ __('Popularity') }}</option>
                    <option value="price_asc">{{ __('Price: Low to High') }}</option>
                    <option value="price_desc">{{ __('Price: High to Low') }}</option>
                    <option value="rating">{{ __('Rating') }}</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-4">
                <label for="priceRange" class="form-label small fw-semibold">{{ __('Price Range ($)') }}</label>
                <div class="d-flex align-items-center">
                    <input type="number" id="priceMin" class="form-control me-2" placeholder="{{ __('Min') }}" value="0">
                    <span class="mx-1">-</span>
                    <input type="number" id="priceMax" class="form-control ms-2" placeholder="{{ __('Max') }}" value="10000">
                </div>
                {{-- Future: could use a noUiSlider or similar for better UX --}}
            </div>
            <div class="col-md-6 col-lg-3">
                <label for="minRating" class="form-label small fw-semibold">{{ __('Minimum Rating') }}</label>
                <select id="minRating" class="form-select">
                    <option value="0" selected>{{ __('Any Rating') }}</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">
                            @for ($s = 0; $s < $i; $s++)&#x2605;@endfor {{ __(' & Up') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-6 col-lg-2 d-grid">
                <button id="applyFiltersBtn" class="btn btn-royal">{{ __('Apply Filters') }}</button>
            </div>
        </div>
    </div>

    {{-- Service Listing Area (will be populated by JS) --}}
    <div id="serviceListing" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        {{-- Service cards will be injected here by JS --}}
    </div>
    <div id="noServicesFound" class="text-center py-5" style="display: none;">
         <svg class="royal-motif mx-auto mb-3" width="50" height="50" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); opacity: 0.4;">
            <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p class="lead" style="color: var(--muted-text);">{{ __('No services found in this category matching your criteria.') }}</p>
        <a href="{{ url('/') }}" class="btn btn-royal-outline mt-3">{{ __('Explore Other Categories') }}</a>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/data.js') }}"></script> {{-- Will create this next --}}
<script src="{{ asset('js/service-category.js') }}"></script> {{-- Will create this next --}}
@endpush

@push('styles')
{{-- Add any page-specific CSS for services-category.blade.php here if needed --}}
<style>
    /* Styles for service cards are in main style.css */
    /* Add specific styles for this page if required */
    #categoryHeader, #filtersSection {
        display: none; /* Initially hidden, shown by JS */
    }
</style>
@endpush

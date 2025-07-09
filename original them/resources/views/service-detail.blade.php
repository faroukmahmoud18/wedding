{{-- resources/views/service-detail.blade.php --}}
@extends('layouts.app')

{{-- Title will be set by JavaScript --}}
@section('title', __('Service Details'))

@section('content')
<div class="container py-5 service-detail-page">

    {{-- Loading State --}}
    <div id="serviceDetailLoading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">{{ __('Loading...') }}</span>
        </div>
        <p class="mt-3 font-serif">{{ __('Loading service details...') }}</p>
    </div>

    {{-- Not Found State --}}
    <div id="serviceNotFound" class="text-center py-5" style="display: none;">
        <svg class="royal-motif mx-auto mb-3" width="60" height="60" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); opacity: 0.5;">
            <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" opacity="0.8"/>
            <circle cx="12" cy="12" r="3" />
        </svg>
        <h2 class="font-serif h3" style="color: var(--royal-deep-brown);">{{__('Service Not Found')}}</h2>
        <p style="color: var(--muted-text);">{{__('The service you are looking for does not exist or is currently unavailable.')}}</p>
        <a href="{{ url('/') }}" class="btn btn-royal mt-3">{{__('Go to Homepage')}}</a>
    </div>

    {{-- Main Content Area (Populated by JS) --}}
    <div id="serviceDetailContent" style="display: none;">
        {{-- Breadcrumbs (populated by JS) --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" id="breadcrumbsContainer">
                {{-- Breadcrumb items will be injected here --}}
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            {{-- Left Column: Image Gallery & Main Description --}}
            <div class="col-lg-8">
                {{-- Image Gallery (Simplified: just primary image for now) --}}
                <div class="card card-royal shadow-sm mb-4 service-gallery">
                    <img src="" id="primaryServiceImage" alt="Service Image" class="card-img-top" style="max-height: 550px; object-fit: cover;">
                    {{-- Future: Add carousel controls if multiple images --}}
                    <div class="card-footer bg-transparent border-0 p-2 text-end">
                         <button class="btn btn-sm btn-outline-secondary me-2 hover-lift">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart me-1" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.281 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/></svg>
                            {{ __('Favorite') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary hover-lift">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill me-1" viewBox="0 0 16 16"><path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z"/></svg>
                            {{ __('Share') }}
                        </button>
                    </div>
                </div>

                {{-- Service Description Card --}}
                <div class="card card-royal shadow-sm mb-4">
                    <div class="card-header bg-transparent position-relative">
                        <h1 class="font-serif h2 mb-0" id="serviceTitle" style="color: var(--royal-deep-brown);"></h1>
                        <div class="position-absolute top-50 end-0 translate-middle-y me-3" style="opacity: 0.3;">
                            <svg class="royal-motif" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold);"><path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 align-items-center mb-3 text-sm text-muted">
                            <span id="serviceRating"></span>
                            <span id="serviceLocation"></span>
                        </div>
                        <p class="lh-lg" id="serviceLongDescription" style="white-space: pre-line;"></p>

                        <div class="mt-4 pt-4 border-top">
                            <h3 class="font-serif h5 fw-semibold mb-3" style="color: var(--royal-deep-brown);">{{ __('Key Features') }}</h3>
                            <ul class="list-unstyled space-y-2" id="serviceFeaturesList">
                                {{-- Features will be injected here --}}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Vendor Info Card --}}
                <div class="card card-royal shadow-sm">
                    <div class="card-header bg-transparent">
                        <h3 class="font-serif h5 mb-0" style="color: var(--royal-deep-brown);">{{ __('About the Vendor') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div id="vendorLogoPlaceholder" class="me-3" style="width: 64px; height: 64px; background-color: var(--warm-gray); border-radius: 50%; display:flex; align-items:center; justify-content:center; color: var(--royal-gold);">
                                <svg class="royal-motif" width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="4" r="1"/><circle cx="12" cy="8" r="1"/><circle cx="15" cy="4" r="1"/><path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z"/></svg>
                            </div>
                            <div>
                                <a href="#" id="vendorProfileLink" class="h5 font-serif text-decoration-none stretched-link" style="color: var(--royal-gold-dark);">
                                    <span id="vendorName"></span>
                                </a>
                                <div id="vendorVerifiedBadge"></div>
                            </div>
                        </div>
                        <p class="small text-muted" id="vendorAbout"></p>
                        {{-- <a href="#" id="fullVendorProfileLink" class="btn btn-sm btn-outline-secondary">{{ __('View Full Vendor Profile') }}</a> --}}
                    </div>
                </div>
            </div>

            {{-- Right Column: Booking Card --}}
            <div class="col-lg-4">
                <div class="card card-royal shadow-lg sticky-top" style="top: 2rem;"> {{-- Sticky for desktop --}}
                    <div class="card-header bg-transparent text-center position-relative py-3">
                        <h2 class="font-serif h4 mb-0" style="color: var(--royal-deep-brown);">{{ __('Book This Service') }}</h2>
                         <div class="position-absolute top-50 end-0 translate-middle-y me-3" style="opacity:0.2;">
                            <svg class="royal-motif" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold);"><path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="0.5" opacity="0.8"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <p class="small text-muted mb-1">{{ __('Starting from') }}</p>
                        <p class="display-5 font-serif fw-bold mb-1" id="servicePrice" style="color: var(--royal-gold-dark);"></p>
                        <p class="small text-muted mb-3" id="serviceUnit"></p>

                        <div class="d-grid mb-3">
                            <button type="button" class="btn btn-royal btn-lg" data-bs-toggle="modal" data-bs-target="#bookingModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-calendar2-check-fill me-2" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.545-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/></svg>
                                {{ __('Request Booking') }}
                            </button>
                        </div>
                         <div class="d-flex align-items-center justify-content-center text-sm text-muted mb-3" id="serviceCategoryLinkContainer">
                            {{-- Category link populated by JS --}}
                        </div>
                        <p class="small text-muted" style="font-size: 0.8rem;">
                            {{ __('Submitting this form does not guarantee booking. The vendor will contact you to confirm availability.') }}
                        </p>
                        <div class="mt-3 royal-border-element mx-auto" style="width: 100px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Booking Modal Partial (will be created) --}}
@include('partials.booking-modal')

@endsection

@push('scripts')
<script src="{{ asset('js/data.js') }}"></script>
<script src="{{ asset('js/booking-form.js') }}"></script> {{-- For modal form handling --}}
<script src="{{ asset('js/service-detail.js') }}"></script>
@endpush

@push('styles')
<style>
    .service-detail-page .breadcrumb-item a {
        color: var(--royal-gold);
        text-decoration: none;
    }
    .service-detail-page .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    .service-detail-page .breadcrumb-item.active {
        color: var(--muted-text);
    }
    .service-features-list li {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .service-features-list .icon-feature {
        color: var(--royal-gold);
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
</style>
@endpush

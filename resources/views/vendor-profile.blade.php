{{-- resources/views/vendor-profile.blade.php --}}
@extends('layouts.app')

{{-- Title will be set by JavaScript --}}
@section('title', __('Vendor Profile'))

@section('content')
<div class="container py-5 vendor-profile-page">

    {{-- Loading State --}}
    <div id="vendorProfileLoading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">{{ __('Loading...') }}</span>
        </div>
        <p class="mt-3 font-serif">{{ __('Loading vendor profile...') }}</p>
    </div>

    {{-- Not Found State --}}
    <div id="vendorNotFound" class="text-center py-5" style="display: none;">
        <svg class="royal-motif mx-auto mb-3" width="60" height="60" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); opacity: 0.5;">
             <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor"/>
             <circle cx="9" cy="4" r="1" fill="currentColor" /><circle cx="12" cy="8" r="1" fill="currentColor" /><circle cx="15" cy="4" r="1" fill="currentColor" />
             <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z" fill="currentColor" />
        </svg>
        <h2 class="font-serif h3" style="color: var(--royal-deep-brown);">{{__('Vendor Not Found')}}</h2>
        <p style="color: var(--muted-text);">{{__('The vendor you are looking for does not exist.')}}</p>
        <a href="{{ url('/') }}" class="btn btn-royal mt-3">{{__('Go to Homepage')}}</a>
    </div>

    {{-- Main Content Area (Populated by JS) --}}
    <div id="vendorProfileContent" style="display: none;">
        {{-- Vendor Info Card Area --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 col-xl-7" id="vendorInfoCardContainer">
                {{-- VendorInfoCard HTML structure will be injected by JS --}}
            </div>
        </div>

        {{-- Services by this Vendor Section --}}
        <div class="text-center mb-5">
            <h2 class="font-serif display-5 fw-bold mb-3" id="vendorServicesTitle" style="color: var(--royal-deep-brown);"></h2>
            <div class="d-flex justify-content-center">
                <div class="royal-border-element" style="width: 150px;"></div>
            </div>
        </div>

        <div id="vendorServiceListing" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            {{-- Service cards will be injected here by JS --}}
        </div>
        <div id="noVendorServicesFound" class="text-center py-5" style="display: none;">
            <svg class="royal-motif mx-auto mb-3" width="50" height="50" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); opacity: 0.4;">
               <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
           </svg>
            <p class="lead" id="noVendorServicesText" style="color: var(--muted-text);"></p>
        </div>

        {{-- Optional Contact/Review section could be added here later --}}

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/data.js') }}"></script>
<script src="{{ asset('js/vendor-profile.js') }}"></script>
@endpush

@push('styles')
<style>
    .vendor-profile-page .icon-contact { /* From contact page, useful here too */
        color: var(--royal-gold-dark);
    }
    .vendor-profile-page .contact-link {
        color: var(--deep-brown);
        font-weight: 500;
    }
    .vendor-profile-page .contact-link:hover {
        color: var(--royal-gold);
    }
    /* Vendor Info Card specific styles if needed beyond card-royal */
    .vendor-info-display-card { /* This class will be added by JS to the injected card */
        /* potential custom styles */
    }
    .vendor-info-display-card .vendor-logo-placeholder {
        width: 100px;
        height: 100px;
        background-color: var(--warm-gray);
        border: 3px solid var(--royal-gold-light);
        color: var(--royal-gold-dark);
    }
    .vendor-info-display-card .vendor-name {
        color: var(--royal-deep-brown);
    }
    .vendor-info-display-card .vendor-verified-badge {
        background-color: var(--royal-gold) !important; /* Bootstrap override */
        color: var(--deep-brown) !important;
        font-size: 0.8rem;
    }
    .vendor-info-display-card .contact-item svg {
        color: var(--royal-gold);
    }
</style>
@endpush

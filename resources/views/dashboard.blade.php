{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', __('User Dashboard'))

@section('content')
<div class="container py-5 dashboard-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="font-serif display-5 fw-bold" style="color: var(--royal-deep-brown);">
            <span id="dashboardUserRoleTitle"></span> {{-- Populated by JS --}}
            {{ __('Dashboard') }}
        </h1>
        {{-- Placeholder for future actions like "Settings" or "Add New" depending on role --}}
        {{-- <button class="btn btn-royal btn-sm mt-2 mt-md-0">Account Settings</button> --}}
    </div>

    {{-- Role-based tab navigation --}}
    {{-- The active tab and content will be controlled by JS based on a simulated role --}}
    <ul class="nav nav-tabs nav-fill royal-tabs mb-4" id="dashboardTab" role="tablist">
        {{-- Tabs will be dynamically added here by JS based on role --}}
        {{-- Example structure for a tab link:
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Profile</button>
        </li>
        --}}
    </ul>

    <div class="tab-content" id="dashboardTabContent">
        {{-- Tab panes will be dynamically added here by JS --}}
        {{-- Example structure for a tab pane:
        <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            ... content for profile tab ...
        </div>
        --}}
    </div>

    {{-- Loading/Default state before JS populates tabs --}}
    <div id="dashboardLoading" class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">{{ __('Loading dashboard content...') }}</span>
        </div>
        <p class="mt-2 font-serif">{{ __('Loading dashboard...') }}</p>
    </div>

</div>
@endsection

@push('styles')
<style>
    .dashboard-page .royal-tabs .nav-link {
        color: var(--muted-text);
        font-weight: 500;
        border-bottom: 3px solid transparent;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    .dashboard-page .royal-tabs .nav-link.active,
    .dashboard-page .royal-tabs .nav-link:hover {
        color: var(--royal-gold-dark);
        border-color: transparent transparent var(--royal-gold) transparent;
        background-color: var(--warm-ivory); /* Slight highlight for active/hover tab */
    }
    .dashboard-page .tab-content {
        background-color: var(--warm-ivory);
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        border-top: none; /* As bottom border of tabs acts as top border */
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        min-height: 300px; /* Ensure some height for tab content */
    }
    .dashboard-page .card-royal { /* Ensure cards within dashboard tabs also get the style */
        background-color: var(--ivory); /* Slightly different from page bg for contrast */
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/data.js') }}"></script> {{-- For sample data if needed by dashboard views --}}
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush

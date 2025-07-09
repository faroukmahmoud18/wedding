@extends('layouts.vendor')

@section('title', __('My Dashboard'))

@section('content')
<div class="container-fluid">
    <h1 class="h2 mb-4" style="color: #4A3B31;">@lang('Vendor Dashboard')</h1>
    <p>@lang('Welcome back,' {{ $vendor->name ?? Auth::user()->name ?? 'Vendor' }}!</p>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-royal-vendor h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('My Active Services')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['active_services'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                             <span style="font-size: 2rem;">&#128221;</span>
                        </div>
                    </div>
                    <a href="{{ route('vendor.services.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-royal-vendor h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('Pending Service Approvals')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['pending_services'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <span style="font-size: 2rem;">&#9203;</span>
                        </div>
                    </div>
                     <a href="{{ route('vendor.services.index', ['status' => 'pending']) }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-royal-vendor h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('Total Bookings Received')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['total_bookings'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <span style="font-size: 2rem;">&#128197;</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('vendor.bookings.index') }}" class="stretched-link"></a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions or Recent Activity -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card card-royal-vendor">
                <div class="card-header">
                    @lang('Quick Actions')
                </div>
                <div class="card-body">
                    <a href="{{ route('vendor.services.create') }}" class="btn btn-royal btn-sm mb-2">@lang('Add New Service')</a>
                    <a href="{{ route('vendor.services.index') }}" class="btn btn-outline-secondary btn-sm mb-2">@lang('Manage My Services')</a>
                    {{-- <a href="#" class="btn btn-outline-secondary btn-sm mb-2">@lang('View My Bookings')</a> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card card-royal-vendor">
                <div class="card-header">
                    @lang('Recent Booking Requests')
                </div>
                <ul class="list-group list-group-flush">
                    {{-- Placeholder - loop through recent bookings --}}
                    @for($i=0; $i<3; $i++)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Booking for "Service X" on Nov') {{10+$i}}, 2023</span>
                        <span class="badge bg-warning text-dark">@lang('Pending')</span>
                    </li>
                    @endfor
                    @if(!isset($recent_bookings) || count($recent_bookings ?? []) == 0)
                         <li class="list-group-item text-center">@lang('No recent booking requests.')</li>
                    @endif
                </ul>
                {{-- <div class="card-footer text-center">
                    <a href="#">@lang('View all bookings') &rarr;</a>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- Alert for profile completion if needed --}}
    {{-- @if(empty($vendor->profile_complete_flag))
    <div class="alert alert-info mt-4">
        @lang('Your vendor profile is incomplete. Please') <a href="#">@lang('click here')</a> @lang('to complete it and attract more customers.')
    </div>
    @endif --}}
</div>
@endsection

@push('scripts')
{{-- Add any JS for this page --}}
@endpush

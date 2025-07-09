@extends('layouts.vendor')

@section('title', __('Dashboard'))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">@lang('Vendor Dashboard')</h1>

    @if(!$vendor->is_approved && !$vendor->is_suspended)
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">@lang('Account Pending Approval')</h4>
        <p>@lang('Your vendor account is currently awaiting approval from our admin team. During this time, you can set up your services, but they will not be live on the site until your account is approved.')</p>
        <hr>
        <p class="mb-0">@lang('Please ensure your profile information is complete and accurate to expedite the approval process. You will be notified once a decision is made.')</p>
    </div>
    @elseif($vendor->is_suspended)
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">@lang('Account Suspended')</h4>
        <p>@lang('Your vendor account has been suspended.')</p>
        @if($vendor->suspension_reason)
        <p><strong>@lang('Reason:')</strong> {{ $vendor->suspension_reason }}</p>
        @endif
        <hr>
        <p class="mb-0">@lang('Please contact support if you believe this is an error or wish to appeal the decision.')</p>
    </div>
    @endif


    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 card-royal-vendor">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('Total Services')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['total_services'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-concierge-bell fa-2x text-muted"></i>
                        </div>
                    </div>
                    <a href="{{ route('vendor.services.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-royal-vendor">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">@lang('Live Services')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['live_services'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-broadcast-tower fa-2x text-muted"></i>
                        </div>
                    </div>
                     <a href="{{ route('vendor.services.index', ['status' => 'approved', 'live' => 'true']) }}" class="stretched-link"></a> {{-- Adjust filter params as needed --}}
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 card-royal-vendor">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">@lang('Pending Approval Services')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['pending_services'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-muted"></i>
                        </div>
                    </div>
                    <a href="{{ route('vendor.services.index', ['status' => 'pending_approval']) }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-royal-vendor">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@lang('Total Bookings Received')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['total_bookings'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-muted"></i>
                        </div>
                    </div>
                    <a href="{{ route('vendor.bookings.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        {{-- Add more stats like total earnings if implemented --}}
    </div>

    <!-- Quick Actions / Recent Activity -->
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">@lang('Recent Bookings')</h6>
                    @if(isset($stats['total_bookings']) && $stats['total_bookings'] > 0)
                        <a href="{{ route('vendor.bookings.index') }}" class="btn btn-sm btn-outline-secondary">@lang('View All Bookings')</a>
                    @endif
                </div>
                <div class="card-body">
                    @if(isset($recentBookings) && $recentBookings->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($recentBookings as $booking)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('vendor.bookings.show', $booking) }}"><strong>#{{$booking->id}}</strong> - {{ Str::limit($booking->service->title, 25) }}</a><br>
                                    <small class="text-muted">@lang('By:') {{ $booking->user->name ?? __('Guest') }} - @lang('On:') {{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    @if($booking->status == 'confirmed') <span class="badge bg-success">@lang('Confirmed')</span>
                                    @elseif($booking->status == 'pending') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                    @elseif($booking->status == 'cancelled') <span class="badge bg-danger">@lang('Cancelled')</span>
                                    @else <span class="badge bg-secondary">{{ Str::title($booking->status) }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center text-muted py-3">@lang('No recent bookings found.')</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">@lang('Recently Updated Services')</h6>
                     @if(isset($stats['total_services']) && $stats['total_services'] > 0)
                        <a href="{{ route('vendor.services.index') }}" class="btn btn-sm btn-outline-secondary">@lang('Manage Services')</a>
                    @endif
                </div>
                <div class="card-body">
                     @if(isset($recentServices) && $recentServices->count() > 0)
                     <ul class="list-group list-group-flush">
                        @foreach($recentServices as $service)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('vendor.services.show', $service) }}">{{ Str::limit($service->title, 30) }}</a><br>
                                    <small class="text-muted">@lang('Last Updated:') {{ $service->updated_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    @if($service->status == 'approved') <span class="badge bg-success">@lang('Approved') {{ $service->is_live ? ' (Live)' : '(Offline)'}}</span>
                                    @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                    @elseif($service->status == 'rejected') <span class="badge bg-danger">@lang('Rejected')</span>
                                    @else <span class="badge bg-secondary">{{ Str::title(str_replace('_', ' ', $service->status)) }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center text-muted py-3">@lang('You haven\'t added any services yet.')</p>
                     <div class="text-center">
                        <a href="{{ route('vendor.services.create') }}" class="btn btn-primary btn-royal">@lang('Add Your First Service')</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<!-- Add Font Awesome for icons (if not already included globally) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
/* Styles for vendor dashboard cards, can reuse or extend from admin if similar */
.card-royal-vendor .border-left-primary { border-left: .25rem solid #4e73df!important; }
.card-royal-vendor .text-primary { color: #4e73df!important; }
.card-royal-vendor .border-left-success { border-left: .25rem solid #1cc88a!important; }
.card-royal-vendor .text-success { color: #1cc88a!important; }
.card-royal-vendor .border-left-info { border-left: .25rem solid #36b9cc!important; }
.card-royal-vendor .text-info { color: #36b9cc!important; }
.card-royal-vendor .border-left-warning { border-left: .25rem solid #f6c23e!important; }
.card-royal-vendor .text-warning { color: #f6c23e!important; }

.text-muted { color: #858796!important; }
.text-gray-800 { color: #4A3B31!important; } /* Vendor theme dark text */

.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}
</style>
@endpush

@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">@lang('Admin Dashboard')</h1>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-royal-admin">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@lang('Total Users')</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i> <!-- Placeholder icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-royal-admin">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">@lang('Total Vendors')</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_vendors'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i> <!-- Placeholder icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 card-royal-admin">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('Pending Vendors')</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_vendors'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-gray-300"></i> <!-- Placeholder icon -->
                        </div>
                    </div>
                     @if(($stats['pending_vendors'] ?? 0) > 0)
                        <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}" class="stretched-link"></a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 card-royal-admin">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">@lang('Total Services')</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_services'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-concierge-bell fa-2x text-gray-300"></i> <!-- Placeholder icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 card-royal-admin">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">@lang('Pending Services')</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_services'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    @if(($stats['pending_services'] ?? 0) > 0)
                        <a href="{{ route('admin.services.index', ['status' => 'pending_approval']) }}" class="stretched-link"></a>
                    @endif
                </div>
            </div>
        </div>
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2 card-royal-admin">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">@lang('Total Bookings')</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_bookings'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Recent Activity -->
    <div class="row">
        @if(isset($recentPendingVendors) && $recentPendingVendors->count() > 0)
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Recent Pending Vendors')</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($recentPendingVendors as $vendor)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('admin.vendors.show', $vendor) }}">{{ $vendor->name }}</a><br>
                                    <small class="text-muted">{{ $vendor->contact_email }} - {{ $vendor->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-primary me-1">@lang('Review')</a>
                                     <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">@lang('Approve')</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @if($stats['pending_vendors'] > $recentPendingVendors->count())
                         <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-secondary mt-2">@lang('View All Pending Vendors')</a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if(isset($recentPendingServices) && $recentPendingServices->count() > 0)
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Recent Pending Services')</h6>
                </div>
                <div class="card-body">
                     <ul class="list-group list-group-flush">
                        @foreach($recentPendingServices as $service)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('admin.services.show', $service) }}">{{ Str::limit($service->title, 40) }}</a><br>
                                    <small class="text-muted">@lang('By:') {{ $service->vendor->name ?? 'N/A' }} - {{ $service->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary me-1">@lang('Review')</a>
                                    <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">@lang('Approve')</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                     @if($stats['pending_services'] > $recentPendingServices->count())
                         <a href="{{ route('admin.services.index', ['status' => 'pending_approval']) }}" class="btn btn-sm btn-outline-secondary mt-2">@lang('View All Pending Services')</a>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('styles')
<!-- Add Font Awesome for icons (if not already included globally) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.card-royal-admin .border-left-primary { border-left: .25rem solid #4e73df!important; }
.card-royal-admin .text-primary { color: #4e73df!important; }
.card-royal-admin .border-left-success { border-left: .25rem solid #1cc88a!important; }
.card-royal-admin .text-success { color: #1cc88a!important; }
.card-royal-admin .border-left-info { border-left: .25rem solid #36b9cc!important; }
.card-royal-admin .text-info { color: #36b9cc!important; }
.card-royal-admin .border-left-warning { border-left: .25rem solid #f6c23e!important; }
.card-royal-admin .text-warning { color: #f6c23e!important; }
.card-royal-admin .border-left-danger { border-left: .25rem solid #e74a3b!important; }
.card-royal-admin .text-danger { color: #e74a3b!important; }
.card-royal-admin .border-left-secondary { border-left: .25rem solid #858796!important; }
.card-royal-admin .text-secondary { color: #858796!important; }

.text-gray-300 { color: #dddfeb!important; }
.text-gray-800 { color: #5a5c69!important; } /* Ensure this matches your theme's dark text */

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

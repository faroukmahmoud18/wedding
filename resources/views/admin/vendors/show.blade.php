@extends('layouts.admin')

@section('title', __('Vendor Details:') . ' ' . $vendor->name)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Vendor Details:') <span class="text-primary">{{ $vendor->name }}</span></h1>
        <div>
            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-primary shadow-sm me-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> @lang('Edit Vendor')
            </a>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Vendor Info Column -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">@lang('Vendor Information')</h6>
                </div>
                <div class="card-body">
                    @if($vendor->logo_url)
                        <div class="text-center mb-3">
                            <img src="{{ $vendor->logo_url }}" alt="{{ $vendor->name }} Logo" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #E1C699;">
                        </div>
                    @endif
                    <h4 class="text-center">{{ $vendor->name }}</h4>
                    <hr>
                    <strong>@lang('Contact Email:')</strong>
                    <p class="text-muted">{{ $vendor->contact_email }}</p>
                    <strong>@lang('Phone Number:')</strong>
                    <p class="text-muted">{{ $vendor->phone_number ?? __('N/A') }}</p>
                    <strong>@lang('Address:')</strong>
                    <p class="text-muted">{{ $vendor->address ?? __('N/A') }}</p>
                    <strong>@lang('City:')</strong>
                    <p class="text-muted">{{ $vendor->city ?? __('N/A') }}</p>
                    <strong>@lang('Country:')</strong>
                    <p class="text-muted">{{ $vendor->country ?? __('N/A') }}</p>
                    <strong>@lang('Registered On:')</strong>
                    <p class="text-muted">{{ $vendor->created_at->format('M d, Y H:i A') }}</p>
                    <strong>@lang('Status:')</strong>
                    <p>
                        @if($vendor->is_suspended)
                            <span class="badge bg-danger fs-6">@lang('Suspended')</span>
                            @if($vendor->suspension_reason)
                                <small class="d-block text-muted">@lang('Reason:') {{ $vendor->suspension_reason }}</small>
                            @endif
                        @elseif($vendor->is_approved)
                            <span class="badge bg-success fs-6">@lang('Approved')</span>
                        @else
                            <span class="badge bg-warning text-dark fs-6">@lang('Pending Approval')</span>
                        @endif
                    </p>
                    <hr>
                    <strong>@lang('Description:')</strong>
                    <p class="text-muted">{{ $vendor->description ?? __('No description provided.') }}</p>
                </div>
            </div>

            <div class="card shadow mb-4 card-royal-admin">
                 <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Associated User Account')</h6>
                </div>
                <div class="card-body">
                    @if($vendor->user)
                        <strong>@lang('User Name:')</strong>
                        <p class="text-muted">{{ $vendor->user->name }}</p>
                        <strong>@lang('User Email:')</strong>
                        <p class="text-muted">{{ $vendor->user->email }}</p>
                        <strong>@lang('User Role:')</strong>
                        <p class="text-muted"><span class="badge bg-secondary">{{ ucfirst($vendor->user->role) }}</span></p>
                    @else
                        <p class="text-danger">@lang('No user account linked to this vendor.')</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Services and Bookings Column -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Services by') {{ $vendor->name }} ({{ $vendor->services->count() }})</h6>
                </div>
                <div class="card-body">
                    @if($vendor->services->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Live')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendor->services as $service)
                                <tr>
                                    <td><a href="{{ route('admin.services.show', $service) }}">{{ Str::limit($service->title, 30) }}</a></td>
                                    <td>{{ $service->category->name ?? __('N/A')}}</td>
                                    <td>{{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }}</td>
                                    <td>
                                        @if($service->status == 'approved') <span class="badge bg-success">@lang('Approved')</span>
                                        @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                        @elseif($service->status == 'rejected') <span class="badge bg-danger">@lang('Rejected')</span>
                                        @else <span class="badge bg-secondary">{{ Str::title(str_replace('_', ' ', $service->status)) }}</span>
                                        @endif
                                    </td>
                                    <td>{!! $service->is_live ? '<span class="badge bg-success">'.__('Yes').'</span>' : '<span class="badge bg-secondary">'.__('No').'</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>@lang('This vendor has not listed any services yet.')</p>
                    @endif
                </div>
            </div>

            {{-- Placeholder for Bookings related to this vendor's services --}}
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Recent Bookings for') {{ $vendor->name }}@lang("'s Services")</h6>
                </div>
                <div class="card-body">
                    @php
                        $bookings = $vendor->services->flatMap->bookings->sortByDesc('created_at')->take(10);
                    @endphp
                    @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('Booking ID')</th>
                                    <th>@lang('Service')</th>
                                    <th>@lang('Customer')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td><a href="{{ route('admin.services.show', $booking->service) }}">{{ Str::limit($booking->service->title, 25) }}</a></td>
                                    <td>{{ $booking->user->name ?? __('Guest') }}</td>
                                    <td>{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($booking->status == 'confirmed') <span class="badge bg-success">@lang('Confirmed')</span>
                                        @elseif($booking->status == 'pending') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                        @elseif($booking->status == 'cancelled') <span class="badge bg-danger">@lang('Cancelled')</span>
                                        @else <span class="badge bg-secondary">{{ Str::title($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>@lang('No bookings found for this vendor\'s services yet.')</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.badge.fs-6 { font-size: 0.9rem; }
.btn-xs { padding: 0.125rem 0.25rem; font-size: 0.75rem; }
</style>
@endpush

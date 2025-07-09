@extends('layouts.vendor')

@section('title', __('My Services'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('My Services')</h1>
        <a href="{{ route('vendor.services.create') }}" class="btn btn-sm btn-primary btn-royal shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> @lang('Add New Service')
        </a>
    </div>

    @if(!$vendor->is_approved && !$vendor->is_suspended)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        @lang('Your vendor account is pending approval. Services you add will not be live until your account is approved by an admin.')
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter/Search Form -->
    <div class="card shadow mb-4 card-royal-vendor">
        <div class="card-body">
            <form method="GET" action="{{ route('vendor.services.index') }}" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search by title...')" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select form-select-sm">
                        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>@lang('All Statuses')</option>
                        <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>@lang('Approved')</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>@lang('Rejected')</option>
                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>@lang('On Hold by Admin')</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-info w-100">@lang('Filter')</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4 card-royal-vendor">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">@lang('Your Service List')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="vendorServicesDataTable" width="100%" cellspacing="0">
                    <thead class="table-dark" style="background-color: #5D4037; color: #E1C699;">
                        <tr>
                            <th>@lang('Title')</th>
                            <th>@lang('Category')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Live')</th>
                            <th>@lang('Last Updated')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>
                                <a href="{{ route('vendor.services.show', $service) }}">{{ Str::limit($service->title, 40) }}</a>
                                @if($service->featured_image_url)
                                   <a href="{{ $service->featured_image_url }}" target="_blank" class="ms-1"><i class="fas fa-image text-muted"></i></a>
                                @endif
                            </td>
                            <td>{{ $service->category->name ?? __('N/A') }}</td>
                            <td>{{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }}</td>
                            <td>
                                @if($service->status == 'approved') <span class="badge bg-success">@lang('Approved')</span>
                                @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark">@lang('Pending Review')</span>
                                @elseif($service->status == 'rejected')
                                    <span class="badge bg-danger">@lang('Rejected')</span>
                                    @if($service->rejection_reason)
                                        <i class="fas fa-info-circle text-danger ms-1" data-bs-toggle="tooltip" title="{{ $service->rejection_reason }}"></i>
                                    @endif
                                @elseif($service->status == 'on_hold') <span class="badge bg-secondary">@lang('On Hold by Admin')</span>
                                @else <span class="badge bg-light text-dark">{{ Str::title(str_replace('_', ' ', $service->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                {!! $service->is_live ? '<span class="badge bg-success">'.__('Yes').'</span>' : '<span class="badge bg-secondary">'.__('No').'</span>' !!}
                            </td>
                            <td>{{ $service->updated_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('vendor.services.show', $service) }}" class="btn btn-sm btn-info" title="@lang('View')"><i class="fas fa-eye"></i></a>
                                    @if(in_array($service->status, ['pending_approval', 'rejected', 'on_hold']) || ($service->status == 'approved' && !$service->is_live) )
                                        {{-- Allow edit if pending, rejected, on_hold, or approved but offline --}}
                                        <a href="{{ route('vendor.services.edit', $service) }}" class="btn btn-sm btn-primary" title="@lang('Edit')"><i class="fas fa-edit"></i></a>
                                    @else
                                        {{-- For Approved & Live services, edit might be restricted or have a different flow --}}
                                         <button class="btn btn-sm btn-primary" title="@lang('Edit (Service is Live - contact admin for major changes)')" disabled><i class="fas fa-edit"></i></button>
                                    @endif
                                    {{-- Delete action might be restricted based on status or bookings --}}
                                    @if(!in_array($service->status, ['approved']) || !$service->is_live)
                                    <form action="{{ route('vendor.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to delete this service? This action cannot be undone.')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="@lang('Delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @else
                                     <button class="btn btn-sm btn-danger" title="@lang('Delete (Cannot delete live service)')" disabled><i class="fas fa-trash"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="mb-2">@lang('You haven\'t added any services yet.')</p>
                                <a href="{{ route('vendor.services.create') }}" class="btn btn-primary btn-royal"><i class="fas fa-plus"></i> @lang('Add Your First Service')</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="d-flex justify-content-center">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.table-dark { background-color: #5D4037 !important; color: #E1C699; } /* Vendor theme table head */
.btn-group .btn { margin-right: 2px; }
.fa-info-circle { cursor: help; }
</style>
@endpush

@push('scripts')
<script>
    // Initialize Bootstrap tooltips for rejection reasons
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush

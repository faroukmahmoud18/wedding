@extends('layouts.admin')

@section('title', __('Manage Vendors'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Manage Vendors')</h1>
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> @lang('Add New Vendor')
        </a>
    </div>

    <!-- Filter/Search Form -->
    <div class="card shadow mb-4 card-royal-admin">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.vendors.index') }}" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search by name, email...')" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">@lang('All Statuses')</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>@lang('Approved')</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>@lang('Suspended')</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-info w-100">@lang('Filter')</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card shadow mb-4 card-royal-admin">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">@lang('Vendor List')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Logo')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Contact Email')</th>
                            <th>@lang('User Email')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Registered On')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->id }}</td>
                            <td>
                                @if($vendor->logo_url)
                                    <img src="{{ $vendor->logo_url }}" alt="{{ $vendor->name }} Logo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <span class="text-muted">@lang('No Logo')</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.vendors.show', $vendor) }}">{{ $vendor->name }}</a>
                            </td>
                            <td>{{ $vendor->contact_email }}</td>
                            <td>{{ $vendor->user->email ?? __('N/A') }}</td>
                            <td>
                                @if($vendor->is_suspended)
                                    <span class="badge bg-danger">@lang('Suspended')</span>
                                @elseif($vendor->is_approved)
                                    <span class="badge bg-success">@lang('Approved')</span>
                                @else
                                    <span class="badge bg-warning text-dark">@lang('Pending Approval')</span>
                                @endif
                            </td>
                            <td>{{ $vendor->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-sm btn-info" title="@lang('View')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-primary" title="@lang('Edit')"><i class="fas fa-edit"></i></a>
                                    @if(!$vendor->is_approved && !$vendor->is_suspended)
                                        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to approve this vendor?')');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="@lang('Approve')"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                    @if(!$vendor->is_suspended)
                                    <button type="button" class="btn btn-sm btn-warning" title="@lang('Suspend')" data-bs-toggle="modal" data-bs-target="#suspendVendorModal-{{ $vendor->id }}"><i class="fas fa-ban"></i></button>
                                    @else
                                    <form action="{{ route('admin.vendors.unsuspend', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to unsuspend this vendor?')');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-secondary" title="@lang('Unsuspend')"><i class="fas fa-undo"></i></button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to delete this vendor? This action cannot be undone.')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="@lang('Delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- Suspend Modal --}}
                        <div class="modal fade" id="suspendVendorModal-{{ $vendor->id }}" tabindex="-1" aria-labelledby="suspendVendorModalLabel-{{ $vendor->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="{{ route('admin.vendors.suspend', $vendor) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="suspendVendorModalLabel-{{ $vendor->id }}">@lang('Suspend Vendor:') {{ $vendor->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="suspension_reason-{{ $vendor->id }}" class="form-label">@lang('Reason for Suspension')</label>
                                        <textarea class="form-control" id="suspension_reason-{{ $vendor->id }}" name="suspension_reason" rows="3" required></textarea>
                                    </div>
                                    <input type="hidden" name="is_suspended" value="1">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                                    <button type="submit" class="btn btn-warning">@lang('Suspend Vendor')</button>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">@lang('No vendors found.')</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Add any specific styles for this page, e.g., for table icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.table-dark { background-color: #4A3B31 !important; color: #E1C699; }
.btn-group .btn { margin-right: 2px; }
</style>
@endpush

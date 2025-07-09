@extends('layouts.admin')

@section('title', __('Manage Services'))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">@lang('Manage Services')</h1>
    <p class="mb-4">@lang('Oversee and manage all services offered on the platform.')</p>

    <!-- Filter/Search Form -->
    <div class="card shadow mb-4 card-royal-admin">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.services.index') }}" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search title, vendor...')" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">@lang('All Categories')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="vendor_id" class="form-select form-select-sm">
                        <option value="">@lang('All Vendors')</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>@lang('All Statuses')</option>
                        <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>@lang('Approved')</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>@lang('Rejected')</option>
                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>@lang('On Hold')</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-sm btn-info w-100">@lang('Filter')</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4 card-royal-admin">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">@lang('Service List')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="servicesDataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Title')</th>
                            <th>@lang('Vendor')</th>
                            <th>@lang('Category')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Live')</th>
                            <th>@lang('Created')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                <a href="{{ route('admin.services.show', $service) }}">{{ Str::limit($service->title, 35) }}</a>
                                @if($service->featured_image_url)
                                   <a href="{{ $service->featured_image_url }}" target="_blank" class="ms-1"><i class="fas fa-image text-muted"></i></a>
                                @endif
                            </td>
                            <td>
                                @if($service->vendor)
                                <a href="{{ route('admin.vendors.show', $service->vendor) }}">{{ Str::limit($service->vendor->name, 20) }}</a>
                                @else
                                <span class="text-muted">@lang('N/A')</span>
                                @endif
                            </td>
                            <td>{{ $service->category->name ?? __('N/A') }}</td>
                            <td>{{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }}</td>
                            <td>
                                @if($service->status == 'approved') <span class="badge bg-success">@lang('Approved')</span>
                                @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                @elseif($service->status == 'rejected') <span class="badge bg-danger">@lang('Rejected')</span>
                                @elseif($service->status == 'on_hold') <span class="badge bg-secondary">@lang('On Hold')</span>
                                @else <span class="badge bg-light text-dark">{{ Str::title(str_replace('_', ' ', $service->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                {!! $service->is_live ? '<span class="badge bg-success">'.__('Yes').'</span>' : '<span class="badge bg-secondary">'.__('No').'</span>' !!}
                                @if($service->status === 'approved')
                                <form action="{{ route('admin.services.toggleLive', $service) }}" method="POST" class="d-inline ms-1" title="{{ $service->is_live ? __('Set Offline') : __('Set Live') }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-xs p-0 border-0">
                                        <i class="fas {{ $service->is_live ? 'fa-toggle-on text-success' : 'fa-toggle-off text-secondary' }}"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                            <td>{{ $service->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-info" title="@lang('View')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-primary" title="@lang('Edit')"><i class="fas fa-edit"></i></a>
                                    @if($service->status == 'pending_approval')
                                        <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to approve this service?')');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="@lang('Approve')"><i class="fas fa-check"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger" title="@lang('Reject')" data-bs-toggle="modal" data-bs-target="#rejectServiceModal-{{ $service->id }}"><i class="fas fa-times"></i></button>
                                    @elseif($service->status == 'approved' && !$service->is_live)
                                        {{-- Can re-approve to make live or use toggle --}}
                                    @elseif($service->status == 'rejected' || $service->status == 'on_hold')
                                         <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to re-approve this service?')');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="@lang('Re-Approve')"><i class="fas fa-check-circle"></i></button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to delete this service? This action cannot be undone.')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="@lang('Delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- Reject Modal --}}
                        @if($service->status == 'pending_approval')
                        <div class="modal fade" id="rejectServiceModal-{{ $service->id }}" tabindex="-1" aria-labelledby="rejectServiceModalLabel-{{ $service->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="{{ route('admin.services.reject', $service) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="rejectServiceModalLabel-{{ $service->id }}">@lang('Reject Service:') {{ Str::limit($service->title, 30) }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="rejection_reason-{{ $service->id }}" class="form-label">@lang('Reason for Rejection')</label>
                                        <textarea class="form-control" id="rejection_reason-{{ $service->id }}" name="rejection_reason" rows="3" required></textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                                    <button type="submit" class="btn btn-danger">@lang('Reject Service')</button>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                        @endif
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">@lang('No services found matching your criteria.')</td>
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
.table-dark { background-color: #4A3B31 !important; color: #E1C699; }
.btn-group .btn, .btn-group .btn-xs { margin-right: 2px; }
.btn-xs { padding: 0.125rem 0.25rem; font-size: 0.75rem; line-height: 1; }
.fa-toggle-on, .fa-toggle-off { font-size: 1.25rem; vertical-align: middle;}
</style>
@endpush

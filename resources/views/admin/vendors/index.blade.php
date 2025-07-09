@extends('layouts.admin')

@section('title', __('Manage Vendors'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #4A3B31;">@lang('Manage Vendors')</h1>
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary btn-sm">
            <span style="font-size: 1.2em;">&#43;</span> @lang('Add New Vendor')
        </a>
    </div>

    <div class="card card-royal-admin shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            @lang('All Vendors List')
            {{-- Search/Filter Form Placeholder --}}
            <form action="{{ route('admin.vendors.index') }}" method="GET" class="d-inline-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="@lang('Search vendors...')" value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm me-2">
                    <option value="">@lang('All Statuses')</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>@lang('Approved')</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>@lang('Suspended')</option>
                </select>
                <button type="submit" class="btn btn-info btn-sm">@lang('Filter')</button>
            </form>
        </div>
        <div class="card-body">
            @if(isset($vendors) && $vendors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Phone')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Services')</th>
                            <th>@lang('Registered')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->id }}</td>
                            <td>
                                <img src="{{ $vendor->logo_url ?? 'https://via.placeholder.com/40x40.png?text='.substr($vendor->name,0,1) }}" alt="{{$vendor->name}}" class="rounded-circle me-2" width="40" height="40">
                                {{ $vendor->name }}
                            </td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone ?? 'N/A' }}</td>
                            <td>
                                @if($vendor->is_approved && !$vendor->is_suspended)
                                    <span class="badge bg-success">@lang('Approved')</span>
                                @elseif($vendor->is_suspended)
                                    <span class="badge bg-danger">@lang('Suspended')</span>
                                @else
                                    <span class="badge bg-warning text-dark">@lang('Pending Approval')</span>
                                @endif
                            </td>
                            <td>{{ $vendor->services_count ?? 0 }}</td> {{-- Assuming services_count is eager loaded --}}
                            <td>{{ $vendor->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="btn btn-sm btn-outline-primary me-1" title="@lang('Edit')">&#9998;</a> {{-- Edit icon --}}
                                {{-- Placeholder for Approve/Suspend actions --}}
                                @if(!$vendor->is_approved && !$vendor->is_suspended)
                                    <form action="{{ route('admin.vendors.updateStatus', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to approve this vendor?')');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approve">
                                        <button type="submit" class="btn btn-sm btn-outline-success me-1" title="@lang('Approve')">&#10004;</button> {{-- Checkmark --}}
                                    </form>
                                @endif
                                @if($vendor->is_approved && !$vendor->is_suspended)
                                     <form action="{{ route('admin.vendors.updateStatus', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to suspend this vendor?')');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="suspend">
                                        <button type="submit" class="btn btn-sm btn-outline-warning me-1" title="@lang('Suspend')">&#128683;</button> {{-- No entry sign --}}
                                    </form>
                                @elseif($vendor->is_suspended)
                                    <form action="{{ route('admin.vendors.updateStatus', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to unsuspend this vendor?')');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="unsuspend"> {{-- or 'approve' --}}
                                        <button type="submit" class="btn btn-sm btn-outline-info me-1" title="@lang('Unsuspend')">&#128994;</button> {{-- Green circle --}}
                                    </form>
                                @endif
                                <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to delete this vendor? This action cannot be undone.')');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="@lang('Delete')">&#128465;</button> {{-- Trash can --}}
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                {{-- {{ $vendors->appends(request()->query())->links() }} --}}
                 <nav><ul class="pagination"><li class="page-item disabled"><span class="page-link">@lang('Prev')</span></li> <li class="page-item active"><span class="page-link">1</span></li> <li class="page-item"><a class="page-link" href="#">2</a></li> <li class="page-item"><a class="page-link" href="#">@lang('Next')</a></li></ul></nav>
            </div>
            @else
                <p class="text-center">@lang('No vendors found matching your criteria.')</p>
                @if(!request('search') && !request('status'))
                    <p class="text-center"><a href="{{ route('admin.vendors.create') }}">@lang('Add the first vendor!')</a></p>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any JS for this page, e.g., confirmation dialogs (already inline for simplicity)
</script>
@endpush

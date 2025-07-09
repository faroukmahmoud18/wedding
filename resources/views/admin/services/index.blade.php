@extends('layouts.admin')

@section('title', __('Manage Services'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #4A3B31;">@lang('Manage Services')</h1>
        {{-- <a href="#" class="btn btn-primary btn-sm">@lang('Add New Service (Admin)')</a> --}}
        {{-- Admin typically doesn't add services directly, but might edit/approve --}}
    </div>

    <div class="card card-royal-admin shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            @lang('All Services List')
            {{-- Search/Filter Form Placeholder --}}
            <form action="#" method="GET" class="d-inline-flex"> {{-- Replace # with admin services index route --}}
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="@lang('Search services...')" value="{{ request('search') }}">
                <select name="vendor_id" class="form-select form-select-sm me-2">
                    <option value="">@lang('All Vendors')</option>
                    {{-- @foreach ($vendors as $vendor) <option value="{{ $vendor->id }}">{{ $vendor->name }}</option> @endforeach --}}
                </select>
                <select name="category" class="form-select form-select-sm me-2">
                    <option value="">@lang('All Categories')</option>
                    {{-- @foreach ($categories as $category) <option value="{{ $category->slug }}">{{ $category->name }}</option> @endforeach --}}
                </select>
                <select name="status" class="form-select form-select-sm me-2">
                    <option value="">@lang('All Statuses')</option>
                    <option value="active">@lang('Active')</option>
                    <option value="inactive">@lang('Inactive')</option>
                    <option value="pending_approval">@lang('Pending Approval')</option>
                </select>
                <button type="submit" class="btn btn-info btn-sm">@lang('Filter')</button>
            </form>
        </div>
        <div class="card-body">
            @if(isset($services) && $services->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Title')</th>
                            <th>@lang('Vendor')</th>
                            <th>@lang('Category')</th>
                            <th>@lang('Price Range')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Created At')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service) {{-- Loop through services passed from controller --}}
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->title }}</td>
                            <td><a href="{{ route('admin.vendors.edit', $service->vendor_id) }}">{{ $service->vendor->name ?? 'N/A' }}</a></td>
                            <td>{{ $service->category_name ?? ucfirst($service->category) }}</td>
                            <td>
                                @if($service->price_from || $service->price_to)
                                    ${{ number_format($service->price_from ?? 0, 2) }} - ${{ number_format($service->price_to ?? 0, 2) }}
                                @else
                                    @lang('On Request')
                                @endif
                            </td>
                            <td>
                                @if($service->is_active && $service->status === 'approved') {{-- Assuming 'status' field for approval --}}
                                    <span class="badge bg-success">@lang('Active & Approved')</span>
                                @elseif(!$service->is_active)
                                    <span class="badge bg-secondary">@lang('Inactive')</span>
                                @elseif($service->status === 'pending_approval')
                                    <span class="badge bg-warning text-dark">@lang('Pending Approval')</span>
                                @else
                                     <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $service->status ?? '')) }}</span>
                                @endif
                            </td>
                            <td>{{ $service->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary me-1" title="@lang('Edit')">&#9998;</a> {{-- Link to admin edit service page --}}
                                {{-- Placeholder for Approve/Feature actions --}}
                                @if($service->status === 'pending_approval')
                                    <button class="btn btn-sm btn-outline-success me-1" title="@lang('Approve')">&#10004;</button>
                                @endif
                                <button class="btn btn-sm btn-outline-danger" title="@lang('Delete')">&#128465;</button> {{-- Admin delete service --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                {{-- {{ $services->links() }} --}}
                <nav><ul class="pagination"><li class="page-item disabled"><span class="page-link">@lang('Prev')</span></li> <li class="page-item active"><span class="page-link">1</span></li> <li class="page-item"><a class="page-link" href="#">@lang('Next')</a></li></ul></nav>
            </div>
            @else
                 @for($i=0; $i<3; $i++) {{-- Placeholder rows --}}
                 <tr>
                    <td>{{ $i+1 }}</td>
                    <td>Sample Service {{ $i+1 }}</td>
                    <td>Sample Vendor {{ $i+1 }}</td>
                    <td>Photography</td>
                    <td>$500 - $1000</td>
                    <td><span class="badge bg-warning text-dark">@lang('Pending Approval')</span></td>
                    <td>Oct 2{{ $i+1 }}, 2023</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-primary me-1" title="@lang('Edit')">&#9998;</a>
                        <button class="btn btn-sm btn-outline-success me-1" title="@lang('Approve')">&#10004;</button>
                        <button class="btn btn-sm btn-outline-danger" title="@lang('Delete')">&#128465;</button>
                    </td>
                </tr>
                @endfor
                @if(!isset($services))
                <p class="text-center p-3">@lang('Loading services data...')</p>
                @else
                <p class="text-center p-3">@lang('No services found matching your criteria.')</p>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

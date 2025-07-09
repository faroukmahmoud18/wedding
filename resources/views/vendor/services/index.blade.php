@extends('layouts.vendor')

@section('title', __('My Services'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #4A3B31;">@lang('My Services')</h1>
        <a href="{{ route('vendor.services.create') }}" class="btn btn-royal btn-sm">
             <span style="font-size: 1.2em;">&#43;</span> @lang('Add New Service')
        </a>
    </div>

    <div class="card card-royal-vendor shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            @lang('All My Services List')
            {{-- Filter Form Placeholder --}}
            <form action="{{ route('vendor.services.index') }}" method="GET" class="d-inline-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="@lang('Search my services...')" value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm me-2">
                    <option value="">@lang('All Statuses')</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>@lang('Active')</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>@lang('Inactive')</option>
                    <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>@lang('Draft')</option>
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
                            <th>@lang('Category')</th>
                            <th>@lang('Price Range')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Bookings')</th> {{-- Placeholder --}}
                            <th>@lang('Created At')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service) {{-- Loop through services passed from controller --}}
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                <img src="{{ $service->featured_image_url ?? 'https://via.placeholder.com/40x30.png?text='.substr($service->title,0,1) }}" alt="{{$service->title}}" class="me-2" style="width:40px; height:auto; border-radius:3px;">
                                {{ $service->title }}
                            </td>
                            <td>{{ $service->category_name ?? ucfirst($service->category) }}</td>
                            <td>
                                @if($service->price_from || $service->price_to)
                                    ${{ number_format($service->price_from ?? 0, 2) }} - ${{ number_format($service->price_to ?? 0, 2) }}
                                @else
                                    @lang('On Request')
                                @endif
                                <small class="text-muted d-block">{{ $service->unit ?? ''}}</small>
                            </td>
                            <td>
                                @if($service->is_active && $service->status === 'approved')
                                    <span class="badge bg-success">@lang('Active & Approved')</span>
                                @elseif(!$service->is_active && $service->status !== 'draft')
                                    <span class="badge bg-secondary">@lang('Inactive')</span>
                                @elseif($service->status === 'pending_approval')
                                    <span class="badge bg-warning text-dark">@lang('Pending Approval')</span>
                                @elseif($service->status === 'draft')
                                    <span class="badge bg-light text-dark border">@lang('Draft')</span>
                                @else
                                     <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $service->status ?? '')) }}</span>
                                @endif
                            </td>
                            <td>{{ $service->bookings_count ?? 0 }}</td> {{-- Assuming bookings_count is eager loaded --}}
                            <td>{{ $service->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('vendor.services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary me-1" title="@lang('Edit')">&#9998;</a>
                                <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="@lang('View Public Page')">&#128269;</a> {{-- Magnifying glass --}}
                                <form action="{{ route('vendor.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to delete this service? This action cannot be undone.')');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="@lang('Delete')">&#128465;</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                {{-- {{ $services->appends(request()->query())->links() }} --}}
                 <nav><ul class="pagination"><li class="page-item disabled"><span class="page-link">@lang('Prev')</span></li> <li class="page-item active"><span class="page-link">1</span></li> <li class="page-item"><a class="page-link" href="#">@lang('Next')</a></li></ul></nav>
            </div>
            @else
                <p class="text-center">@lang('You haven\'t added any services yet, or no services match your current filter.')</p>
                @if(!request('search') && !request('status'))
                    <p class="text-center"><a href="{{ route('vendor.services.create') }}">@lang('Add your first service!')</a></p>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any JS for this page
</script>
@endpush

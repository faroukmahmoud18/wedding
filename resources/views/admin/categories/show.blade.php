@extends('layouts.admin')

@section('title', __('Category Details:') . ' ' . $category->name)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Category Details:') <span class="text-primary">{{ $category->name }}</span></h1>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary shadow-sm me-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> @lang('Edit Category')
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Category Information')</h6>
                </div>
                <div class="card-body">
                     {{-- @if($category->image_url)
                        <div class="text-center mb-3">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }} Image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    @endif --}}
                    <dl class="row">
                        <dt class="col-sm-4">@lang('ID:')</dt>
                        <dd class="col-sm-8">{{ $category->id }}</dd>

                        <dt class="col-sm-4">@lang('Name:')</dt>
                        <dd class="col-sm-8">{{ $category->name }}</dd>

                        <dt class="col-sm-4">@lang('Slug:')</dt>
                        <dd class="col-sm-8">{{ $category->slug }}</dd>

                        {{-- <dt class="col-sm-4">@lang('Parent Category:')</dt>
                        <dd class="col-sm-8">{{ $category->parent->name ?? __('None') }}</dd> --}}

                        <dt class="col-sm-4">@lang('Services Count:')</dt>
                        <dd class="col-sm-8">{{ $category->services_count }}</dd>

                        <dt class="col-sm-4">@lang('Created At:')</dt>
                        <dd class="col-sm-8">{{ $category->created_at->format('M d, Y H:i A') }}</dd>

                        <dt class="col-sm-4">@lang('Updated At:')</dt>
                        <dd class="col-sm-8">{{ $category->updated_at->format('M d, Y H:i A') }}</dd>
                    </dl>
                    <hr>
                    <strong>@lang('Description:')</strong>
                    <p class="text-muted">{{ $category->description ?? __('No description provided.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Services in') "{{ $category->name }}" (@lang('Top 10 recent'))</h6>
                </div>
                <div class="card-body">
                    @php
                        // Manually load services if not eager loaded or if specific query is needed
                        $servicesInCategory = $category->services()->with('vendor')->orderBy('created_at', 'desc')->take(10)->get();
                    @endphp
                    @if($servicesInCategory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Vendor')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Live')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicesInCategory as $service)
                                <tr>
                                    <td><a href="{{ route('admin.services.show', $service) }}">{{ Str::limit($service->title, 30) }}</a></td>
                                    <td>{{ $service->vendor->name ?? __('N/A') }}</td>
                                    <td>
                                        @if($service->status == 'approved') <span class="badge bg-success">@lang('Approved')</span>
                                        @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark">@lang('Pending')</span>
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
                     @if($category->services_count > 10)
                        <a href="{{ route('admin.services.index', ['category_id' => $category->id]) }}" class="btn btn-sm btn-outline-info mt-2">@lang('View All Services in this Category') ({{ $category->services_count }})</a>
                    @endif
                    @else
                    <p>@lang('No services currently listed under this category.')</p>
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
.btn-xs { padding: 0.125rem 0.25rem; font-size: 0.75rem; }
</style>
@endpush

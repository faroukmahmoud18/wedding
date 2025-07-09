@extends('layouts.admin')

@section('title', __('Manage Categories'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Manage Categories')</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> @lang('Add New Category')
        </a>
    </div>

    <div class="card shadow mb-4 card-royal-admin">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3 align-items-center">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search by name or slug...')" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-info w-100">@lang('Search')</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4 card-royal-admin">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">@lang('Category List')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="categoriesDataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Slug')</th>
                            <th>@lang('Services Count')</th>
                            <th>@lang('Created At')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}">{{ $category->name }}</a>
                                {{-- Display parent category if hierarchical --}}
                                {{-- @if($category->parent) <small class="d-block text-muted">Parent: {{ $category->parent->name }}</small> @endif --}}
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->services_count }}</td>
                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info" title="@lang('View')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary" title="@lang('Edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('Are you sure you want to delete this category? This might affect associated services if not handled properly.')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="@lang('Delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">@lang('No categories found.')</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.table-dark { background-color: #4A3B31 !important; color: #E1C699; }
.btn-group .btn { margin-right: 2px; }
</style>
@endpush

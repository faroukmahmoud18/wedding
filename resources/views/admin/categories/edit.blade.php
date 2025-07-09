@extends('layouts.admin')

@section('title', __('Edit Category:') . ' ' . $category->name)

@section('content')
<div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Edit Category:') <span class="text-primary">{{ $category->name }}</span></h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
        </a>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.categories._form', [
            'category' => $category,
            // 'parentCategories' => $parentCategories ?? []
        ])
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

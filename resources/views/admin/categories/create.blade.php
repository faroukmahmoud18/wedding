@extends('layouts.admin')

@section('title', __('Add New Category'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Add New Category')</h1>
         <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
        </a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        {{-- Pass empty category and potentially empty parentCategories if needed by the form partial --}}
        @include('admin.categories._form', [
            'category' => new \App\Models\Category(),
            // 'parentCategories' => $parentCategories ?? []
        ])
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

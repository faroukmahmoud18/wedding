@extends('layouts.admin')

@section('title', __('Edit Service:') . ' ' . Str::limit($service->title, 30))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Edit Service:') <span class="text-primary">{{ Str::limit($service->title, 50) }}</span></h1>
        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
        </a>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.services._form', ['service' => $service, 'categories' => $categories, 'vendors' => $vendors])
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

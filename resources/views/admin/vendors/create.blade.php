@extends('layouts.admin')

@section('title', __('Add New Vendor'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Add New Vendor')</h1>
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
        </a>
    </div>

    <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.vendors._form', ['vendor' => new \App\Models\Vendor()]) {{-- Pass an empty vendor model for form consistency --}}
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

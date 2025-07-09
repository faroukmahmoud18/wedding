@extends('layouts.vendor')

@section('title', __('Add New Service'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Add New Service')</h1>
         <a href="{{ route('vendor.services.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to My Services')
        </a>
    </div>

    @if(!$vendor->is_approved && !$vendor->is_suspended)
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        @lang('Your vendor account is pending approval. Services you add now will be reviewed by an admin once your account is approved. They will not be live on the site until then.')
    </div>
    @endif

    <form action="{{ route('vendor.services.store') }}" method="POST" enctype="multipart/form-data">
        @include('vendor.services._form', [
            'service' => new \App\Models\Service(), // Pass empty service model
            'categories' => $categories,
            'vendor' => $vendor
        ])
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

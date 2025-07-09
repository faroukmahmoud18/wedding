@extends('layouts.vendor')

@section('title', __('Edit Service:') . ' ' . Str::limit($service->title, 30))

@section('content')
<div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Edit Service:') <span class="text-primary">{{ Str::limit($service->title, 50) }}</span></h1>
        <a href="{{ route('vendor.services.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to My Services')
        </a>
    </div>

    @if($service->status == 'approved' && $service->is_live)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-1"></i>
            @lang('This service is currently live and approved. Significant changes may require re-approval from admin and temporarily take the service offline. For minor text updates, it might remain live. Contact support for clarity on major changes.')
        </div>
    @elseif($service->status == 'rejected')
         <div class="alert alert-danger">
             <i class="fas fa-times-circle me-1"></i>
            @lang('This service was rejected by admin.') @if($service->rejection_reason) <strong>@lang('Reason:')</strong> {{ $service->rejection_reason }} @endif
            @lang('Editing and saving will resubmit it for approval.')
        </div>
    @elseif($service->status == 'on_hold')
         <div class="alert alert-secondary">
             <i class="fas fa-pause-circle me-1"></i>
            @lang('This service is currently on hold by admin. Editing and saving will resubmit it for approval.')
        </div>
    @endif


    <form action="{{ route('vendor.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('vendor.services._form', [
            'service' => $service,
            'categories' => $categories,
            'vendor' => $vendor
        ])
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

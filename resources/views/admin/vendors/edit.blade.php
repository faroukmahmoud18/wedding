@extends('layouts.admin')

@section('title', __('Edit Vendor') . ': ' . ($vendor->name ?? 'N/A'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #4A3B31;">@lang('Edit Vendor:') <em class="fw-normal">{{ $vendor->name ?? 'N/A' }}</em></h1>
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; @lang('Back to Vendors List')
        </a>
    </div>

    @if(isset($vendor))
    <div class="card card-royal-admin shadow-sm">
        <div class="card-header">
            @lang('Vendor Details')
        </div>
        <div class="card-body">
            <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Link to User Account (Display only or allow change if complex logic handled) --}}
                {{-- <div class="row mb-3">
                    <label for="user_id_display" class="col-md-3 col-form-label text-md-end">@lang('Linked User Account')</label>
                    <div class="col-md-7">
                        <input type="text" readonly class="form-control-plaintext" id="user_id_display" value="{{ $vendor->user ? $vendor->user->name . ' (' . $vendor->user->email . ')' : 'None' }}">
                        <! -- Logic to change linked user would be more complex (detach old, attach new) -->
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <label for="name" class="col-md-3 col-form-label text-md-end">@lang('Vendor Name') <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $vendor->name) }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-3 col-form-label text-md-end">@lang('Email Address') <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $vendor->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-md-3 col-form-label text-md-end">@lang('Phone Number')</label>
                    <div class="col-md-7">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $vendor->phone) }}">
                        @error('phone')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-md-3 col-form-label text-md-end">@lang('Address')</label>
                    <div class="col-md-7">
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address', $vendor->address) }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="city" class="col-md-3 col-form-label text-md-end">@lang('City')</label>
                    <div class="col-md-7">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $vendor->city) }}">
                        @error('city')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="country" class="col-md-3 col-form-label text-md-end">@lang('Country')</label>
                    <div class="col-md-7">
                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country', $vendor->country) }}">
                        @error('country')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="about" class="col-md-3 col-form-label text-md-end">@lang('About Vendor')</label>
                    <div class="col-md-7">
                        <textarea id="about" class="form-control @error('about') is-invalid @enderror" name="about" rows="5">{{ old('about', $vendor->about) }}</textarea>
                        @error('about')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="logo" class="col-md-3 col-form-label text-md-end">@lang('Vendor Logo')</label>
                    <div class="col-md-7">
                        <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                        @error('logo')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <small class="form-text text-muted">@lang('Recommended size: 300x200px. Max 2MB. Leave blank to keep current logo.')</small>
                        @if($vendor->logo_url)
                            <div class="mt-2">
                                <img src="{{ $vendor->logo_url }}" alt="{{ $vendor->name }} Logo" style="max-height: 100px; border: 1px solid #ddd; padding: 5px;">
                                <br><small>@lang('Current Logo')</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="is_approved" class="col-md-3 col-form-label text-md-end">@lang('Approval Status')</label>
                    <div class="col-md-7">
                        <select id="is_approved" name="is_approved" class="form-select @error('is_approved') is-invalid @enderror">
                            <option value="1" {{ old('is_approved', $vendor->is_approved ? '1' : '0') == '1' ? 'selected' : '' }}>@lang('Approved')</option>
                            <option value="0" {{ old('is_approved', $vendor->is_approved ? '1' : '0') == '0' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                        </select>
                        @error('is_approved')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="is_suspended" class="col-md-3 col-form-label text-md-end">@lang('Account Status')</label>
                    <div class="col-md-7">
                        <select id="is_suspended" name="is_suspended" class="form-select @error('is_suspended') is-invalid @enderror">
                            <option value="0" {{ old('is_suspended', $vendor->is_suspended ? '1' : '0') == '0' ? 'selected' : '' }}>@lang('Active')</option>
                            <option value="1" {{ old('is_suspended', $vendor->is_suspended ? '1' : '0') == '1' ? 'selected' : '' }}>@lang('Suspended')</option>
                        </select>
                        @error('is_suspended')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-7 offset-md-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Update Vendor')
                        </button>
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                            @lang('Cancel')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="alert alert-danger">@lang('Vendor not found.')</div>
    @endif
</div>
@endsection

@push('scripts')
{{-- Add any JS for this page --}}
@endpush

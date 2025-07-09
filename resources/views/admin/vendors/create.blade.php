@extends('layouts.admin')

@section('title', __('Add New Vendor'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #4A3B31;">@lang('Add New Vendor')</h1>
        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; @lang('Back to Vendors List')
        </a>
    </div>

    <div class="card card-royal-admin shadow-sm">
        <div class="card-header">
            @lang('Vendor Details')
        </div>
        <div class="card-body">
            <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Link to User Account (Optional) --}}
                {{-- <div class="row mb-3">
                    <label for="user_id" class="col-md-3 col-form-label text-md-end">@lang('Link to User Account (Optional)')</label>
                    <div class="col-md-7">
                        <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">@lang('None - Create as standalone vendor')</option>
                            @ foreach ($users as $user) users should be passed from controller
                                <option value="{ { $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @ endforeach
                        </select>
                        @error('user_id')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <small class="form-text text-muted">@lang('If this vendor should log in, select their user account. Otherwise, their account might need manual setup or they manage via admin.')</small>
                    </div>
                </div> --}}


                <div class="row mb-3">
                    <label for="name" class="col-md-3 col-form-label text-md-end">@lang('Vendor Name') <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-3 col-form-label text-md-end">@lang('Email Address') <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-md-3 col-form-label text-md-end">@lang('Phone Number')</label>
                    <div class="col-md-7">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-md-3 col-form-label text-md-end">@lang('Address')</label>
                    <div class="col-md-7">
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                 <div class="row mb-3">
                    <label for="city" class="col-md-3 col-form-label text-md-end">@lang('City')</label>
                    <div class="col-md-7">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">
                        @error('city')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="country" class="col-md-3 col-form-label text-md-end">@lang('Country')</label>
                    <div class="col-md-7">
                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}">
                        {{-- Consider a select dropdown for countries --}}
                        @error('country')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="about" class="col-md-3 col-form-label text-md-end">@lang('About Vendor')</label>
                    <div class="col-md-7">
                        <textarea id="about" class="form-control @error('about') is-invalid @enderror" name="about" rows="5">{{ old('about') }}</textarea>
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
                        <small class="form-text text-muted">@lang('Recommended size: 300x200px. Max 2MB.')</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="is_approved" class="col-md-3 col-form-label text-md-end">@lang('Status')</label>
                    <div class="col-md-7">
                        <select id="is_approved" name="is_approved" class="form-select @error('is_approved') is-invalid @enderror">
                            <option value="1" {{ old('is_approved', '1') == '1' ? 'selected' : '' }}>@lang('Approved')</option>
                            <option value="0" {{ old('is_approved') == '0' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                        </select>
                        @error('is_approved')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-0">
                    <div class="col-md-7 offset-md-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Create Vendor')
                        </button>
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                            @lang('Cancel')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Add any JS for this page, e.g., for rich text editor for 'about' field --}}
@endpush

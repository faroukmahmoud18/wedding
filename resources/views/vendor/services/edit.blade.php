@extends('layouts.vendor')

@section('title', __('Edit Service') . ': ' . ($service->title ?? 'N/A'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #4A3B31;">@lang('Edit Service:') <em class="fw-normal">{{ $service->title ?? 'N/A' }}</em></h1>
        <a href="{{ route('vendor.services.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; @lang('Back to My Services')
        </a>
    </div>

    @if(isset($service))
    <div class="card card-royal-vendor shadow-sm">
        <div class="card-header">
            @lang('Service Details')
        </div>
        <div class="card-body">
            <form action="{{ route('vendor.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="title" class="col-md-3 col-form-label text-md-end">@lang('Service Title') <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $service->title) }}" required autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="category" class="col-md-3 col-form-label text-md-end">@lang('Category') <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">@lang('-- Select Category --')</option>
                            <option value="photography" {{ old('category', $service->category) == 'photography' ? 'selected' : '' }}>@lang('Photography')</option>
                            <option value="videography" {{ old('category', $service->category) == 'videography' ? 'selected' : '' }}>@lang('Videography')</option>
                            <option value="venues" {{ old('category', $service->category) == 'venues' ? 'selected' : '' }}>@lang('Venues')</option>
                            <option value="catering" {{ old('category', $service->category) == 'catering' ? 'selected' : '' }}>@lang('Catering')</option>
                            <option value="music_band" {{ old('category', $service->category) == 'music_band' ? 'selected' : '' }}>@lang('Music Band')</option>
                            <option value="dj_services" {{ old('category', $service->category) == 'dj_services' ? 'selected' : '' }}>@lang('DJ Services')</option>
                            <option value="decorations" {{ old('category', $service->category) == 'decorations' ? 'selected' : '' }}>@lang('Decorations')</option>
                            <option value="bridal_wear" {{ old('category', $service->category) == 'bridal_wear' ? 'selected' : '' }}>@lang('Bridal Wear')</option>
                            <option value="groom_wear" {{ old('category', $service->category) == 'groom_wear' ? 'selected' : '' }}>@lang('Groom Wear')</option>
                            <option value="makeup_hair" {{ old('category', $service->category) == 'makeup_hair' ? 'selected' : '' }}>@lang('Makeup & Hair')</option>
                            <option value="invitations" {{ old('category', $service->category) == 'invitations' ? 'selected' : '' }}>@lang('Invitations')</option>
                            <option value="favors_gifts" {{ old('category', $service->category) == 'favors_gifts' ? 'selected' : '' }}>@lang('Favors & Gifts')</option>
                            <option value="transportation" {{ old('category', $service->category) == 'transportation' ? 'selected' : '' }}>@lang('Transportation')</option>
                            <option value="other" {{ old('category', $service->category) == 'other' ? 'selected' : '' }}>@lang('Other')</option>
                        </select>
                        @error('category')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="short_desc" class="col-md-3 col-form-label text-md-end">@lang('Short Description') <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <textarea id="short_desc" class="form-control @error('short_desc') is-invalid @enderror" name="short_desc" rows="3" required>{{ old('short_desc', $service->short_desc) }}</textarea>
                        <small class="form-text text-muted">@lang('Max 255 characters. A brief summary shown in listings.')</small>
                        @error('short_desc')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="long_desc" class="col-md-3 col-form-label text-md-end">@lang('Full Description')</label>
                    <div class="col-md-8">
                        <textarea id="long_desc" class="form-control @error('long_desc') is-invalid @enderror" name="long_desc" rows="8">{{ old('long_desc', $service->long_desc) }}</textarea>
                        <small class="form-text text-muted">@lang('Detailed information about the service.')</small>
                        @error('long_desc')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="price_from" class="col-md-3 col-form-label text-md-end">@lang('Price From')</label>
                    <div class="col-md-4">
                         <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input id="price_from" type="number" step="0.01" class="form-control @error('price_from') is-invalid @enderror" name="price_from" value="{{ old('price_from', $service->price_from) }}" placeholder="e.g., 500.00">
                        </div>
                        @error('price_from')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="price_to" class="col-md-3 col-form-label text-md-end">@lang('Price To (Optional)')</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input id="price_to" type="number" step="0.01" class="form-control @error('price_to') is-invalid @enderror" name="price_to" value="{{ old('price_to', $service->price_to) }}" placeholder="e.g., 1500.00">
                        </div>
                        <small class="form-text text-muted">@lang('Use for price ranges. Leave blank if single price or "on request".')</small>
                        @error('price_to')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="unit" class="col-md-3 col-form-label text-md-end">@lang('Price Unit')</label>
                    <div class="col-md-4">
                        <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit', $service->unit) }}" placeholder="@lang('e.g., per hour, per event, per person')">
                        @error('unit')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                 <div class="row mb-3">
                    <label for="location_text" class="col-md-3 col-form-label text-md-end">@lang('Service Location/Area')</label>
                    <div class="col-md-8">
                        <input id="location_text" type="text" class="form-control @error('location_text') is-invalid @enderror" name="location_text" value="{{ old('location_text', $service->location_text) }}" placeholder="@lang('e.g., Serves Tri-City Area, On-site at your venue')">
                        <small class="form-text text-muted">@lang('Describe where the service is provided or areas covered.')</small>
                        @error('location_text')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tags" class="col-md-3 col-form-label text-md-end">@lang('Tags/Keywords')</label>
                    <div class="col-md-8">
                        <input id="tags" type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" value="{{ old('tags', is_array($service->tags) ? implode(', ', $service->tags) : $service->tags) }}" placeholder="@lang('e.g., rustic, outdoor, modern, budget-friendly')">
                        <small class="form-text text-muted">@lang('Comma-separated list of tags.')</small>
                        @error('tags')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="images" class="col-md-3 col-form-label text-md-end">@lang('Service Images')</label>
                    <div class="col-md-8">
                        <input id="images" type="file" class="form-control @error('images.*') is-invalid @enderror @error('images') is-invalid @enderror" name="images[]" multiple accept="image/*">
                        @error('images.*')<span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        @error('images')<span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        <small class="form-text text-muted">@lang('Upload new images to add or replace. Max 2MB per image. Leave blank to keep current images.')</small>

                        {{-- Display current images --}}
                        @if($service->images && $service->images->count() > 0)
                            <div class="mt-3">
                                <p><strong>@lang('Current Images:')</strong></p>
                                <div class="row">
                                @foreach($service->images as $image)
                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ $image->path_url ?? 'https://via.placeholder.com/150.png?text=Image' }}" alt="{{ $image->alt ?? $service->title }}" class="img-thumbnail">
                                            {{-- Add a way to delete specific images if needed, e.g., a checkbox --}}
                                            {{-- <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="position-absolute top-0 start-0 m-1" title="Mark to delete"> --}}
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="is_active" class="col-md-3 col-form-label text-md-end">@lang('Status')</label>
                    <div class="col-md-8">
                        <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', $service->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>@lang('Active')</option>
                            <option value="0" {{ old('is_active', $service->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>@lang('Inactive/Draft')</option>
                        </select>
                        @error('is_active')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                         <small class="form-text text-muted">
                            @lang('Current approval status:')
                            @if($service->status === 'approved') <span class="badge bg-success">@lang('Approved')</span>
                            @elseif($service->status === 'pending_approval') <span class="badge bg-warning text-dark">@lang('Pending Approval')</span>
                            @elseif($service->status === 'rejected') <span class="badge bg-danger">@lang('Rejected')</span>
                            @else <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $service->status ?? 'Unknown')) }}</span>
                            @endif
                        </small>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-3">
                        <button type="submit" class="btn btn-royal">
                            @lang('Update Service')
                        </button>
                         @if($service->status !== 'approved')
                         <button type="submit" name="resubmit_for_approval" value="1" class="btn btn-outline-success">
                            @lang('Save & Resubmit for Approval')
                        </button>
                        @endif
                        <a href="{{ route('vendor.services.index') }}" class="btn btn-link">
                            @lang('Cancel')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="alert alert-danger">@lang('Service not found or you do not have permission to edit it.')</div>
    @endif
</div>
@endsection

@push('scripts')
{{-- Add any JS for this page --}}
@endpush

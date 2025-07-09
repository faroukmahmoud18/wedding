@csrf
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4 card-royal-vendor">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">{{ isset($service) ? __('Edit Service') : __('Create New Service') }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">@lang('Service Title') <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">@lang('Category') <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">@lang('Select Category')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $service->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="short_desc" class="form-label">@lang('Short Description / Teaser') (@lang('Max 255 characters'))</label>
                    <textarea name="short_desc" id="short_desc" class="form-control @error('short_desc') is-invalid @enderror" rows="2" maxlength="255">{{ old('short_desc', $service->short_desc ?? '') }}</textarea>
                    @error('short_desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">@lang('Full Description') <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">@lang('Price') ({{ config('settings.currency_symbol', '$') }}) <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $service->price ?? '') }}" required step="0.01" min="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price_unit" class="form-label">@lang('Price Unit') (@lang('e.g., per hour, per event, per item'))</label>
                        <input type="text" name="price_unit" id="price_unit" class="form-control @error('price_unit') is-invalid @enderror" value="{{ old('price_unit', $service->price_unit ?? '') }}" placeholder="@lang('e.g., per hour')">
                        @error('price_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location_text" class="form-label">@lang('Service Location')</label>
                    <input type="text" name="location_text" id="location_text" class="form-control @error('location_text') is-invalid @enderror" value="{{ old('location_text', $service->location_text ?? '') }}" placeholder="@lang('e.g., Specific Venue, City, State or "Online")">
                    @error('location_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">@lang('Tags / Keywords') (@lang('Comma separated, helps in search'))</label>
                     @php
                        $tagsValue = old('tags', $service->tags ?? '');
                        if (is_array($tagsValue)) {
                            $tagsValue = implode(', ', $tagsValue);
                        }
                    @endphp
                    <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ $tagsValue }}" placeholder="@lang('e.g. outdoor, rustic, modern')">
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4 card-royal-vendor">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">@lang('Media & Status')</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="featured_image" class="form-label">@lang('Featured Image')</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                    @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if(isset($service) && $service->featured_image_url)
                        <div class="mt-2">
                            <img src="{{ $service->featured_image_url }}" alt="@lang('Current Featured Image')" style="max-height: 120px; border-radius: 5px; border: 1px solid #ddd;">
                            <small class="d-block text-muted">@lang('Current image. Upload a new file to replace it.')</small>
                        </div>
                    @endif
                </div>

                {{-- Placeholder for multiple additional images - more complex implementation needed
                <div class="mb-3">
                    <label for="additional_images" class="form-label">@lang('Additional Images (Optional)')</label>
                    <input type="file" name="additional_images[]" id="additional_images" class="form-control @error('additional_images.*') is-invalid @enderror" multiple accept="image/*">
                     @error('additional_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                     {{-- Display existing additional images here if any --}}
                {{-- </div> --}}

                @if(isset($service))
                <hr>
                <div class="mb-3">
                    <label class="form-label">@lang('Current Admin Status:')</label>
                    <p>
                        @if($service->status == 'approved') <span class="badge bg-success fs-6">@lang('Approved')</span>
                        @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark fs-6">@lang('Pending Review')</span>
                        @elseif($service->status == 'rejected')
                            <span class="badge bg-danger fs-6">@lang('Rejected')</span>
                            @if($service->rejection_reason) <small class="d-block text-muted mt-1">@lang('Reason:') {{ $service->rejection_reason }}</small> @endif
                        @elseif($service->status == 'on_hold') <span class="badge bg-secondary fs-6">@lang('On Hold by Admin')</span>
                        @else <span class="badge bg-light text-dark fs-6">{{ Str::title(str_replace('_', ' ', $service->status)) }}</span>
                        @endif
                    </p>
                    @if(in_array($service->status, ['rejected', 'on_hold']))
                        <p class="small text-muted">@lang('If you edit and save this service, it will be resubmitted for admin approval.')</p>
                    @elseif($service->status == 'approved')
                         <p class="small text-muted">@lang('If you make significant changes, this service might require re-approval by admin and will be taken offline temporarily.')</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
        <div class="card shadow card-royal-vendor">
             <div class="card-body">
                <button type="submit" class="btn btn-success btn-lg w-100 btn-royal">
                    <i class="fas fa-save"></i> {{ isset($service) ? __('Save Changes') : __('Submit for Approval') }}
                </button>
                <a href="{{ isset($service) ? route('vendor.services.show', $service) : route('vendor.services.index') }}" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-times"></i> @lang('Cancel')
                </a>
             </div>
        </div>
    </div>
</div>

@push('scripts')
{{-- Add any specific JS for this form, e.g., for image previews or rich text editor --}}
@endpush

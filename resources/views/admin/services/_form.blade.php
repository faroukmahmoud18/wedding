@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4 card-royal-admin">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">@lang('Service Information')</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">@lang('Service Title') <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
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
                    <div class="col-md-6 mb-3">
                        <label for="vendor_id" class="form-label">@lang('Vendor') <span class="text-danger">*</span></label>
                        <select name="vendor_id" id="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                            <option value="">@lang('Select Vendor')</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id', $service->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="short_desc" class="form-label">@lang('Short Description / Teaser')</label>
                    <textarea name="short_desc" id="short_desc" class="form-control @error('short_desc') is-invalid @enderror" rows="2">{{ old('short_desc', $service->short_desc ?? '') }}</textarea>
                    @error('short_desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">@lang('Full Description') <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $service->description ?? '') }}</textarea>
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
                        <label for="price_unit" class="form-label">@lang('Price Unit') (@lang('e.g., per hour, per person'))</label>
                        <input type="text" name="price_unit" id="price_unit" class="form-control @error('price_unit') is-invalid @enderror" value="{{ old('price_unit', $service->price_unit ?? '') }}">
                        @error('price_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location_text" class="form-label">@lang('Location Text') (@lang('e.g., Venue Name, City, Online'))</label>
                    <input type="text" name="location_text" id="location_text" class="form-control @error('location_text') is-invalid @enderror" value="{{ old('location_text', $service->location_text ?? '') }}">
                    @error('location_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">@lang('Tags / Keywords') (@lang('Comma separated'))</label>
                    @php
                        $tagsValue = old('tags', $service->tags ?? '');
                        if (is_array($tagsValue)) {
                            $tagsValue = implode(', ', $tagsValue);
                        }
                    @endphp
                    <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ $tagsValue }}">
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Placeholder for image uploads - This would require more complex handling in controller and possibly a separate ServiceImage model --}}
                {{-- <div class="mb-3">
                    <label for="featured_image" class="form-label">@lang('Featured Image')</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                    @if(isset($service) && $service->featured_image_url)
                        <img src="{{ $service->featured_image_url }}" alt="Current Featured Image" style="max-height: 100px; margin-top: 10px;">
                    @endif
                    @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="additional_images" class="form-label">@lang('Additional Images')</label>
                    <input type="file" name="additional_images[]" id="additional_images" class="form-control @error('additional_images.*') is-invalid @enderror" multiple accept="image/*">
                     @error('additional_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> --}}

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow mb-4 card-royal-admin">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">@lang('Status & Visibility')</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="status" class="form-label">@lang('Service Status') <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending_approval" {{ old('status', $service->status ?? 'pending_approval') == 'pending_approval' ? 'selected' : '' }}>@lang('Pending Approval')</option>
                        <option value="approved" {{ old('status', $service->status ?? '') == 'approved' ? 'selected' : '' }}>@lang('Approved')</option>
                        <option value="rejected" {{ old('status', $service->status ?? '') == 'rejected' ? 'selected' : '' }}>@lang('Rejected')</option>
                        <option value="on_hold" {{ old('status', $service->status ?? '') == 'on_hold' ? 'selected' : '' }}>@lang('On Hold')</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="rejection_reason_group" style="{{ old('status', $service->status ?? '') == 'rejected' ? '' : 'display:none;' }}">
                    <label for="rejection_reason" class="form-label">@lang('Rejection Reason')</label>
                    <textarea name="rejection_reason" id="rejection_reason" class="form-control @error('rejection_reason') is-invalid @enderror" rows="3">{{ old('rejection_reason', $service->rejection_reason ?? '') }}</textarea>
                    @error('rejection_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_live" id="is_live" value="1" {{ old('is_live', isset($service) && $service->is_live) ? 'checked' : '' }} {{ (old('status', $service->status ?? '') != 'approved') ? 'disabled' : '' }}>
                    <label class="form-check-label" for="is_live">
                        @lang('Is Live')
                    </label>
                    <small class="form-text text-muted d-block">@lang('Service must be "Approved" to be set live. Uncheck to take offline.')</small>
                </div>
                <hr>
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-save"></i> {{ __('Update Service') }}
                </button>
                 <a href="{{ route('admin.services.show', $service) }}" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-times"></i> @lang('Cancel')
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status');
    const rejectionReasonGroup = document.getElementById('rejection_reason_group');
    const rejectionReasonTextarea = document.getElementById('rejection_reason');
    const isLiveCheckbox = document.getElementById('is_live');

    function toggleRejectionReason() {
        if (statusSelect.value === 'rejected') {
            rejectionReasonGroup.style.display = 'block';
            rejectionReasonTextarea.required = true;
        } else {
            rejectionReasonGroup.style.display = 'none';
            rejectionReasonTextarea.required = false;
        }
    }

    function toggleIsLiveCheckbox() {
        if (statusSelect.value === 'approved') {
            isLiveCheckbox.disabled = false;
        } else {
            isLiveCheckbox.disabled = true;
            isLiveCheckbox.checked = false; // Uncheck if not approved
        }
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', function () {
            toggleRejectionReason();
            toggleIsLiveCheckbox();
        });
        // Initial check
        toggleRejectionReason();
        toggleIsLiveCheckbox();
    }
});
</script>
@endpush

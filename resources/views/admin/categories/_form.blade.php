@csrf
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4 card-royal-admin">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">{{ isset($category) ? __('Edit Category') : __('Create New Category') }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">@lang('Category Name') <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">@lang('Slug') (@lang('Auto-generated if blank'))</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug ?? '') }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Uncomment for hierarchical categories
                <div class="mb-3">
                    <label for="parent_id" class="form-label">@lang('Parent Category')</label>
                    <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">@lang('None (Top Level Category)')</option>
                        @foreach($parentCategories ?? [] as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                --}}

                <div class="mb-3">
                    <label for="description" class="form-label">@lang('Description')</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Uncomment for category image upload
                <div class="mb-3">
                    <label for="image" class="form-label">@lang('Category Image')</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($category) && $category->image_url)
                        <div class="mt-2">
                            <img src="{{ $category->image_url }}" alt="@lang('Current Image')" style="max-height: 100px; border-radius: 5px;">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">
                                    @lang('Remove current image')
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
                --}}
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times"></i> @lang('Cancel')
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> {{ isset($category) ? __('Update Category') : __('Create Category') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Script to auto-generate slug if needed, or provide a toggle for manual override.
// For simplicity, relying on backend Str::slug for now if slug is empty.
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    if (nameInput && slugInput && !slugInput.value) { // Only if slug is empty
        nameInput.addEventListener('keyup', function() {
            // Basic slug generation (replace spaces with hyphens, lowercase)
            // For more robust slugification, a library or more complex regex might be used.
            // Laravel's Str::slug on the backend is more reliable.
            // This is just for immediate user feedback.
            // slugInput.value = this.value.toString().toLowerCase()
            //     .replace(/\s+/g, '-')           // Replace spaces with -
            //     .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            //     .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            //     .replace(/^-+/, '')             // Trim - from start of text
            //     .replace(/-+$/, '');            // Trim - from end of text
        });
    }
});
</script>
@endpush

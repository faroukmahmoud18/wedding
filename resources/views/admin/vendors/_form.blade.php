@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4 card-royal-admin">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">@lang('Vendor Details')</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="vendor_name" class="form-label">@lang('Vendor Name') <span class="text-danger">*</span></label>
                    <input type="text" name="vendor_name" id="vendor_name" class="form-control @error('vendor_name') is-invalid @enderror" value="{{ old('vendor_name', $vendor->name ?? '') }}" required>
                    @error('vendor_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contact_email" class="form-label">@lang('Vendor Contact Email') <span class="text-danger">*</span></label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $vendor->contact_email ?? '') }}" required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">@lang('Phone Number')</label>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $vendor->phone_number ?? '') }}">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">@lang('Address')</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $vendor->address ?? '') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">@lang('City')</label>
                        <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $vendor->city ?? '') }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="country" class="form-label">@lang('Country')</label>
                        <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $vendor->country ?? '') }}">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">@lang('Description')</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $vendor->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="mb-3">
                    <label for="logo" class="form-label">@lang('Vendor Logo')</label>
                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($vendor) && $vendor->logo_url)
                        <div class="mt-2">
                            <img src="{{ $vendor->logo_url }}" alt="@lang('Current Logo')" style="max-height: 100px; border-radius: 5px;">
                            <br><small>@lang('Current logo shown above. Upload a new file to replace it.')</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 card-royal-admin">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">@lang('Associated User Account')</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="user_name" class="form-label">@lang('User Full Name') <span class="text-danger">*</span></label>
                        <input type="text" name="user_name" id="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name', $vendor->user->name ?? '') }}" required {{ isset($vendor) && $vendor->user ? '' : '' }}>
                        @error('user_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">@lang('User Login Email') <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $vendor->user->email ?? '') }}" required {{ isset($vendor) && $vendor->user ? '' : '' }}>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">@lang('Password') {{ isset($vendor) ? '' : __('(Required)') }}</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" {{ !isset($vendor) ? 'required' : '' }}>
                        @if(isset($vendor))<small class="form-text text-muted">@lang('Leave blank to keep current password.')</small>@endif
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">@lang('Confirm Password')</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow mb-4 card-royal-admin">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">@lang('Status & Actions')</h6>
            </div>
            <div class="card-body">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_approved" id="is_approved" value="1" {{ old('is_approved', isset($vendor) && $vendor->is_approved) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_approved">
                        @lang('Approved')
                    </label>
                    <small class="form-text text-muted d-block">@lang('If checked, the vendor can log in and manage their services.')</small>
                </div>

                @if(isset($vendor))
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_suspended" id="is_suspended" value="1" {{ old('is_suspended', $vendor->is_suspended) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_suspended">
                        @lang('Suspended')
                    </label>
                     <small class="form-text text-muted d-block">@lang('If checked, the vendor account will be temporarily disabled.')</small>
                </div>
                 <div class="mb-3" id="suspension_reason_group" style="{{ old('is_suspended', isset($vendor) && $vendor->is_suspended) ? '' : 'display:none;' }}">
                    <label for="suspension_reason" class="form-label">@lang('Suspension Reason')</label>
                    <textarea name="suspension_reason" id="suspension_reason" class="form-control @error('suspension_reason') is-invalid @enderror" rows="3">{{ old('suspension_reason', $vendor->suspension_reason ?? '') }}</textarea>
                    @error('suspension_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endif
                <hr>
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-save"></i> {{ isset($vendor) ? __('Update Vendor') : __('Create Vendor') }}
                </button>
                 @if(isset($vendor))
                <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-times"></i> @lang('Cancel')
                </a>
                @else
                 <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-times"></i> @lang('Cancel')
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isSuspendedCheckbox = document.getElementById('is_suspended');
    const suspensionReasonGroup = document.getElementById('suspension_reason_group');
    const suspensionReasonTextarea = document.getElementById('suspension_reason');

    if (isSuspendedCheckbox) {
        isSuspendedCheckbox.addEventListener('change', function () {
            if (this.checked) {
                suspensionReasonGroup.style.display = 'block';
                suspensionReasonTextarea.required = true;
            } else {
                suspensionReasonGroup.style.display = 'none';
                suspensionReasonTextarea.required = false;
            }
        });
        // Trigger change on load to set initial state
        isSuspendedCheckbox.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

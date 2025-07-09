{{-- resources/views/partials/booking-modal.blade.php --}}
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-royal">
            <div class="modal-header border-0 position-relative">
                <h1 class="modal-title font-serif h4 w-100 text-center ps-4" id="bookingModalLabel" style="color:var(--royal-deep-brown);">
                    <svg class="royal-motif me-2" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold-dark); margin-bottom: 4px;">
                        <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="4" r="1"/><circle cx="12" cy="8" r="1"/><circle cx="15" cy="4" r="1"/>
                        <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z"/>
                    </svg>
                    {{ __('Book Service:') }} <span id="bookingModalServiceTitle" class="fw-normal"></span>
                </h1>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body p-4 p-lg-5">
                <p class="text-muted text-center small mb-4">{{ __('Fill in your details below to request a booking. The vendor will contact you to confirm availability and details.') }}</p>

                <form id="bookingServiceForm" class="needs-validation" novalidate>
                    {{-- CSRF token for Laravel if this form were to submit directly via Blade --}}
                    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                    <input type="hidden" id="bookingServiceIdField" name="service_id">

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="bookingName" class="form-label fw-semibold">{{ __('Full Name') }}</label>
                            <input type="text" class="form-control form-control-lg" id="bookingName" name="name" placeholder="{{ __('e.g., Princess Aurora') }}" required>
                            <div class="invalid-feedback">{{ __('Please enter your full name.') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bookingEmail" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control form-control-lg" id="bookingEmail" name="email" placeholder="{{ __('e.g., aurora@palace.com') }}" required>
                            <div class="invalid-feedback">{{ __('Please enter a valid email address.') }}</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="bookingPhone" class="form-label fw-semibold">{{ __('Phone Number') }} <span class="text-muted small">({{__('Optional')}})</span></label>
                            <input type="tel" class="form-control form-control-lg" id="bookingPhone" name="phone" placeholder="{{ __('e.g., (555) 123-4567') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bookingEventDate" class="form-label fw-semibold">{{ __('Preferred Event Date') }}</label>
                            <input type="date" class="form-control form-control-lg" id="bookingEventDate" name="event_date" required>
                            <div class="invalid-feedback">{{ __('Please select a preferred event date.') }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bookingNotes" class="form-label fw-semibold">{{ __('Additional Notes') }} <span class="text-muted small">({{__('Optional')}})</span></label>
                        <textarea class="form-control form-control-lg" id="bookingNotes" name="notes" rows="3" placeholder="{{ __('Any specific requests or details for the vendor...') }}" maxlength="500"></textarea>
                        <div class="form-text small">{{ __('Max 500 characters.') }}</div>
                    </div>

                    <div id="bookingFormFeedback" class="mt-3"></div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-royal btn-lg">{{ __('Send Booking Request') }}</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

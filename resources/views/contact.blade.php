{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('title', __('Contact Royal Vows'))

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <div class="d-inline-block mb-3" style="color: var(--royal-gold);">
            {{-- RoyalOrnament SVG --}}
            <svg class="royal-motif" width="60" height="60" viewBox="0 0 24 24" fill="none">
                <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.8"/>
                <circle cx="12" cy="12" r="3" fill="currentColor" />
            </svg>
        </div>
        <h1 class="font-serif display-4 fw-bold mb-3" style="color: var(--royal-deep-brown);">
            {{ __('Contact Royal Vows') }}
        </h1>
        <p class="lead mx-auto" style="color: var(--muted-text); max-width: 700px;">
            {{ __("We're here to assist you with any inquiries. Reach out to us through the form below or via our contact details. Your dream wedding planning starts with a conversation.") }}
        </p>
        <div class="d-flex justify-content-center mt-4">
            <div class="royal-border-element" style="width: 150px;"></div>
        </div>
    </div>

    <div class="row gy-5 gx-lg-5 justify-content-center">
        <div class="col-lg-7">
            <div class="mb-4 d-flex align-items-center">
                <svg class="royal-motif me-2" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold-dark);">
                    <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h2 class="font-serif h3 mb-0" style="color: var(--royal-deep-brown);">{{ __('Send Us a Message') }}</h2>
            </div>
            <div class="card card-royal shadow-elegant p-4 p-lg-5">
                <form id="contactForm" action="{{-- {{ route('contact.submit') }} --}}" method="POST" class="needs-validation" novalidate>
                    @csrf {{-- Important for Laravel POST forms --}}

                    <div class="mb-3">
                        <label for="contactName" class="form-label fw-semibold">{{ __('Full Name') }}</label>
                        <input type="text" class="form-control form-control-lg" id="contactName" name="name" placeholder="{{ __('e.g., Lord Stardust') }}" required>
                        <div class="invalid-feedback">{{ __('Please enter your name.') }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="contactEmail" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                        <input type="email" class="form-control form-control-lg" id="contactEmail" name="email" placeholder="{{ __('e.g., stardust@castle.com') }}" required>
                        <div class="invalid-feedback">{{ __('Please enter a valid email address.') }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="contactInquiryType" class="form-label fw-semibold">{{ __('Reason for Contact') }}</label>
                        <select class="form-select form-select-lg" id="contactInquiryType" name="inquiryType" required>
                            <option value="" selected disabled>{{ __('Select an inquiry type...') }}</option>
                            <option value="general">{{ __('General Inquiry') }}</option>
                            <option value="vendor_support">{{ __('Vendor Support') }}</option>
                            <option value="technical_issue">{{ __('Technical Issue') }}</option>
                            <option value="feedback">{{ __('Feedback & Suggestions') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ __('Please select a reason for your inquiry.') }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="contactSubject" class="form-label fw-semibold">{{ __('Subject') }}</label>
                        <input type="text" class="form-control form-control-lg" id="contactSubject" name="subject" placeholder="{{ __('e.g., Question about Royal Balls') }}" required minlength="5">
                        <div class="invalid-feedback">{{ __('Subject must be at least 5 characters.') }}</div>
                    </div>

                    <div class="mb-4">
                        <label for="contactMessage" class="form-label fw-semibold">{{ __('Your Message') }}</label>
                        <textarea class="form-control form-control-lg" id="contactMessage" name="message" rows="5" placeholder="{{ __('Please describe your inquiry in detail...') }}" required minlength="10" maxlength="1000"></textarea>
                        <div class="form-text">{{ __('Max 1000 characters.') }}</div>
                        <div class="invalid-feedback">{{ __('Message must be at least 10 characters.') }}</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-royal btn-lg">{{ __('Send Message') }}</button>
                    </div>
                     <div id="formSubmissionFeedback" class="mt-3"></div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
             <div class="mb-4 d-flex align-items-center mt-lg-0 mt-4">
                 <svg class="royal-motif me-2" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold-dark);">
                    <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h2 class="font-serif h3 mb-0" style="color: var(--royal-deep-brown);">{{ __('Our Royal Address') }}</h2>
            </div>
            <div class="bg-warm-ivory p-4 rounded shadow-sm contact-details">
                <div class="d-flex align-items-start mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt-fill flex-shrink-0 me-3 mt-1 icon-contact" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                    <div>
                        <h5 class="font-serif h6 mb-0">{{ __('Royal Vows Headquarters') }}</h5>
                        <p class="mb-0 small">{{ __('123 Coronation Street,') }}<br>{{ __('Majestic City, Kingdom of Bliss, 12345') }}</p>
                    </div>
                </div>
                <hr style="border-color: var(--border-color);">
                <div class="d-flex align-items-center mb-3">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-telephone-fill flex-shrink-0 me-3 icon-contact" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>
                    <a href="tel:+1234567890" class="text-decoration-none contact-link">{{ __('(123) 456-7890') }}</a>
                </div>
                 <hr style="border-color: var(--border-color);">
                <div class="d-flex align-items-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-envelope-fill flex-shrink-0 me-3 icon-contact" viewBox="0 0 16 16"><path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/></svg>
                    <a href="mailto:contact@royalvows.com" class="text-decoration-none contact-link">{{ __('contact@royalvows.com') }}</a>
                </div>
                 <hr style="border-color: var(--border-color);">
                 <div>
                    <h5 class="font-serif h6 mb-1 mt-2">{{ __('Office Hours') }}</h5>
                    <p class="small mb-0">{{ __('Monday - Friday: 9:00 AM - 6:00 PM') }}</p>
                    <p class="small mb-0">{{ __('Saturday: 10:00 AM - 4:00 PM (By Appointment)') }}</p>
                    <p class="small mb-0">{{ __('Sunday: Closed for Royal Festivities') }}</p>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .contact-details .icon-contact {
        color: var(--royal-gold-dark);
    }
    .contact-details .contact-link {
        color: var(--deep-brown);
        font-weight: 500;
    }
    .contact-details .contact-link:hover {
        color: var(--royal-gold);
    }
    .form-control-lg, .form-select-lg {
        font-size: 1rem; /* Bootstrap default is 1.25rem, making it a bit smaller */
        padding: .6rem 1rem;
    }
    .needs-validation input:invalid,
    .needs-validation textarea:invalid,
    .needs-validation select:invalid {
        border-color: var(--bs-danger-border-subtle);
    }
    .needs-validation input:valid,
    .needs-validation textarea:valid,
    .needs-validation select:valid {
        border-color: var(--bs-success-border-subtle);
    }

</style>
@endpush

@push('scripts')
<script src="{{ asset('js/contact-form.js') }}"></script>
@endpush

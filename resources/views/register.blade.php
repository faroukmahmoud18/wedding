{{-- resources/views/register.blade.php --}}
@extends('layouts.app')

@section('title', __('Create Your Royal Account'))

@section('content')
<div class="container py-5 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6"> {{-- Slightly wider for more fields --}}
            <div class="text-center mb-4">
                 <div class="d-inline-block mb-3" style="color: var(--royal-gold);">
                    {{-- RoyalOrnament SVG --}}
                    <svg class="royal-motif" width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.8"/>
                        <circle cx="12" cy="12" r="3" fill="currentColor" />
                    </svg>
                </div>
                <h1 class="font-serif display-5 fw-bold" style="color: var(--royal-deep-brown);">{{ __('Join Royal Vows') }}</h1>
                <p class="lead" style="color: var(--muted-text);">{{ __('Create your account to begin planning or offering services.') }}</p>
                 <div class="d-flex justify-content-center mt-3">
                    <div class="royal-border-element" style="width: 100px;"></div>
                </div>
            </div>

            <div class="card card-royal shadow-lg p-4 p-lg-5">
                <div class="card-body">
                    <h2 class="font-serif h3 text-center mb-4" style="color: var(--royal-deep-brown);">{{ __('Create Account') }}</h2>

                    <form id="registerFormPage" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div id="registerFormFeedback" class="mb-3"></div>

                        <div class="mb-3">
                            <label for="registerName" class="form-label fw-semibold">{{ __('Full Name') }}</label>
                            <input type="text" class="form-control form-control-lg" id="registerName" name="name" placeholder="{{ __('e.g., Lady Seraphina Moon') }}" required minlength="2">
                            <div class="invalid-feedback">{{ __('Name must be at least 2 characters.') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="registerEmail" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control form-control-lg" id="registerEmail" name="email" placeholder="{{ __('e.g., seraphina@royalvows.com') }}" required>
                            <div class="invalid-feedback">{{ __('Please enter a valid email address.') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="registerRole" class="form-label fw-semibold">{{ __('Account Type') }}</label>
                            <select class="form-select form-select-lg" id="registerRole" name="role" required>
                                <option value="" selected disabled>{{ __('I am a...') }}</option>
                                <option value="user">{{ __('Couple / Guest (Planning a wedding)') }}</option>
                                <option value="vendor">{{ __('Wedding Vendor (Offering services)') }}</option>
                            </select>
                            <div class="invalid-feedback">{{ __('Please select an account type.') }}</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="registerPassword" class="form-label fw-semibold">{{ __('Password') }}</label>
                                <input type="password" class="form-control form-control-lg" id="registerPassword" name="password" placeholder="{{ __('Create a strong password') }}" required minlength="8">
                                <div class="invalid-feedback">{{ __('Password must be at least 8 characters.') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="registerConfirmPassword" class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control form-control-lg" id="registerConfirmPassword" name="password_confirmation" placeholder="{{ __('Re-enter your password') }}" required>
                                <div class="invalid-feedback" id="confirmPasswordFeedback">{{ __('Please confirm your password.') }}</div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="agreeTerms" name="terms" required>
                            <label class="form-check-label small" for="agreeTerms">
                                {{ __('I agree to the') }} <a href="{{url('/terms')}}" target="_blank" style="color: var(--royal-gold);">{{__('Terms & Conditions')}}</a> {{__('and')}} <a href="{{url('/privacy')}}" target="_blank" style="color: var(--royal-gold);">{{__('Privacy Policy')}}</a>.
                            </label>
                            <div class="invalid-feedback">{{ __('You must agree to the terms and conditions.') }}</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-royal btn-lg">{{ __('Create Account') }}</button>
                        </div>
                    </form>
                     <div class="text-center mt-4">
                        <p class="small text-muted">
                            {{ __('Already have an account?') }}
                            <a href="{{ url('/login') }}" class="fw-medium text-decoration-none" style="color: var(--royal-gold);">{{ __('Sign In') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- <script src="{{ asset('js/config.js') }}"></script> --}} {{-- If not global --}}
<script src="{{ asset('js/auth.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerFormPage');
    const feedbackDiv = document.getElementById('registerFormFeedback');
    const confirmPasswordInput = document.getElementById('registerConfirmPassword');
    const passwordInput = document.getElementById('registerPassword');
    const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback');


    if (registerForm && confirmPasswordInput && passwordInput && confirmPasswordFeedback) {

        // Custom validation for password match
        const validatePasswordMatch = () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity("Passwords do not match.");
                confirmPasswordFeedback.textContent = "Passwords do not match.";
            } else {
                confirmPasswordInput.setCustomValidity("");
                confirmPasswordFeedback.textContent = "{{ __('Please confirm your password.') }}"; // Default message
            }
        };
        passwordInput.addEventListener('input', validatePasswordMatch);
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);

        registerForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            event.stopPropagation();

            if (feedbackDiv) feedbackDiv.innerHTML = '';
            validatePasswordMatch(); // Ensure custom validation runs on submit

            if (!registerForm.checkValidity()) {
                registerForm.classList.add('was-validated');
                 if (feedbackDiv) {
                    feedbackDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please fill in all required fields correctly.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                return;
            }
            registerForm.classList.add('was-validated');

            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const role = document.getElementById('registerRole').value;
            const password = passwordInput.value;
            const password_confirmation = confirmPasswordInput.value; // For Laravel validation

            const submitButton = registerForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("Creating Account...") }}';
            submitButton.disabled = true;

            const result = await registerUser({ name, email, password, password_confirmation, role }); // from auth.js

            if (result.success) {
                if (feedbackDiv) {
                    feedbackDiv.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">${result.message || 'Registration successful! Please check your email or login.'} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                }
                registerForm.reset();
                registerForm.classList.remove('was-validated');
                // Redirect to login or a "check your email" page after a delay
                setTimeout(() => {
                    window.location.href = '{{ url("/login") }}';
                }, 2500);
            } else {
                if (feedbackDiv) {
                    // Error message might contain HTML for validation errors list
                    feedbackDiv.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">${result.message || 'Registration failed.'}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                }
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                // Don't remove 'was-validated' on server error, so user can see which fields might be an issue
                // registerForm.classList.remove('was-validated');
            }
        });
    }
});
</script>
@endpush
</tbody>
</table>
            </div>
            <button class="btn btn-royal mt-3"><i class="bi bi-plus-circle-fill me-2"></i>Add New Vendor</button>
        `;
    }

    function getAdminManageServicesContent() {
        let serviceCards = '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">';
         if (typeof sampleServices !== 'undefined') {
            sampleServices.slice(0,6).forEach(service => { // Show a few examples
                serviceCards += `
                <div class="col">
                    <div class="card card-royal h-100 shadow-sm">
                        <img src="${service.images[0]?.path || 'https://placehold.co/300x200'}" class="card-img-top" alt="${service.title}" style="height:150px; object-fit:cover;">
                        <div class="card-body py-2 px-3">
                            <h6 class="card-title font-serif small mb-1">${service.title}</h6>
                            <p class="card-text text-muted small mb-1">By: ${service.vendor?.name || 'N/A'}</p>
                            <span class="badge ${service.isActive ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis'}">${service.isActive ? 'Active' : 'Inactive'}</span>
                            ${service.featured ? '<span class="badge bg-primary-subtle text-primary-emphasis ms-1">Featured</span>' : ''}
                        </div>
                        <div class="card-footer bg-transparent border-0 py-2 px-3 text-end">
                            <button class="btn btn-sm btn-outline-secondary" title="Toggle Status"><i class="bi bi-toggles"></i></button>
                        </div>
                    </div>
                </div>`;
            });
        }
        serviceCards += '</div>';
        return `
            <h4 class="font-serif mb-3">Manage Services</h4>
            ${serviceCards || '<p>No services to display.</p>'}
        `;
    }
    function getAdminSiteBookingsContent() { return `<h4 class="font-serif">Site-wide Bookings Overview</h4><p>Content for all site bookings will go here (e.g., charts, recent bookings table).</p>`; }

    // Vendor Content Functions
    function getVendorMyServicesContent() { return `<h4 class="font-serif">My Services</h4><p>Content for vendor's services (CRUD interface) will go here.</p><button class="btn btn-royal"><i class="bi bi-plus-circle-fill me-2"></i>Add New Service</button>`; }
    function getVendorBookingsContent() { return `<h4 class="font-serif">My Booking Requests</h4><p>Table/list of booking requests for this vendor's services.</p>`; }
    function getVendorProfileContent() { return `<h4 class="font-serif">My Vendor Profile</h4><p>Form to edit vendor profile details.</p>`; }

    // User Content Functions
    function getUserMyBookingsContent() { return `<h4 class="font-serif">My Bookings</h4><p>List of user's current and past bookings. <a href="/bookings" class="btn btn-sm btn-royal-outline">View All Bookings</a></p>`; }
    function getUserFavoritesContent() { return `<h4 class="font-serif">My Favorite Services</h4><p>Grid of user's favorited services.</p>`; }
    function getUserProfileContent() { return `<h4 class="font-serif">My Profile</h4><p>Form to edit user profile information.</p>`; }

    // --- Initialize ---
    initDashboard();
});

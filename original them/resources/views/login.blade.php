{{-- resources/views/login.blade.php --}}
@extends('layouts.app')

@section('title', __('Sign In to Royal Vows'))

@section('content')
<div class="container py-5 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="text-center mb-4">
                <div class="d-inline-block mb-3" style="color: var(--royal-gold);">
                    {{-- RoyalOrnament SVG --}}
                    <svg class="royal-motif" width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.8"/>
                        <circle cx="12" cy="12" r="3" fill="currentColor" />
                    </svg>
                </div>
                <h1 class="font-serif display-5 fw-bold" style="color: var(--royal-deep-brown);">{{ __('Welcome Back') }}</h1>
                <p class="lead" style="color: var(--muted-text);">{{ __('Sign in to continue your royal journey.') }}</p>
                <div class="d-flex justify-content-center mt-3">
                    <div class="royal-border-element" style="width: 100px;"></div>
                </div>
            </div>

            <div class="card card-royal shadow-lg p-4 p-lg-5">
                <div class="card-body">
                    <h2 class="font-serif h3 text-center mb-4" style="color: var(--royal-deep-brown);">{{ __('Sign In') }}</h2>

                    <form id="loginFormPage" class="needs-validation" novalidate>
                        {{-- CSRF not strictly needed for API token auth if separate domain, but good if same-site --}}
                        {{-- @csrf --}}

                        <div id="loginFormFeedback" class="mb-3"></div> {{-- For error messages --}}

                        <div class="mb-3">
                            <label for="loginEmail" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control form-control-lg" id="loginEmail" name="email" placeholder="{{ __('e.g., yourmajesty@royalvows.com') }}" required>
                            <div class="invalid-feedback">{{ __('Please enter your email address.') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="loginPassword" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input type="password" class="form-control form-control-lg" id="loginPassword" name="password" placeholder="{{ __('Enter your password') }}" required>
                            <div class="invalid-feedback">{{ __('Please enter your password.') }}</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                <label class="form-check-label small" for="rememberMe">{{ __('Remember me') }}</label>
                            </div>
                            <a href="{{-- {{ route('password.request') }} --}}" class="small text-decoration-none" style="color: var(--royal-gold);">{{ __('Forgot password?') }}</a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-royal btn-lg">{{ __('Sign In') }}</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            {{ __("Don't have an account?") }}
                            <a href="{{ url('/register') }}" class="fw-medium text-decoration-none" style="color: var(--royal-gold);">{{ __('Sign Up Here') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- API_BASE_URL is defined in public/js/config.js which should be loaded globally via app.blade.php OR defined via window.APP_CONFIG --}}
{{-- <script src="{{ asset('js/config.js') }}"></script> --}} {{ If not global }}
<script src="{{ asset('js/auth.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginFormPage');
    const feedbackDiv = document.getElementById('loginFormFeedback');

    if (loginForm) {
        loginForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            event.stopPropagation();

            if (feedbackDiv) feedbackDiv.innerHTML = ''; // Clear previous feedback

            if (!loginForm.checkValidity()) {
                loginForm.classList.add('was-validated');
                if (feedbackDiv) {
                    feedbackDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please fill in all required fields correctly.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                return;
            }
            loginForm.classList.add('was-validated');

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const submitButton = loginForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("Signing In...") }}';
            submitButton.disabled = true;

            const result = await loginUser(email, password); // From auth.js

            if (result.success) {
                if (feedbackDiv) {
                     feedbackDiv.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">${result.message || 'Login successful! Redirecting...'} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                }
                // Redirect after a short delay, or let auth.js handle it if it does
                // Check if 'from' location exists in state for redirect after login
                const queryParams = new URLSearchParams(window.location.search);
                const redirectTo = queryParams.get('redirect') || '{{ url("/dashboard") }}'; // Default redirect

                setTimeout(() => {
                    window.location.href = redirectTo;
                }, 1500);
            } else {
                if (feedbackDiv) {
                    feedbackDiv.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">${result.message || 'Login failed.'}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                }
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                loginForm.classList.remove('was-validated'); // Allow re-validation attempt
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

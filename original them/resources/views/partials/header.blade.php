{{-- resources/views/partials/header.blade.php --}}
@php
    // This data would ideally come from a View Composer or be passed by controllers in a real Laravel app
    // For now, mimicking the structure from the original React component
    // In a real Laravel app, this might come from a View Composer or a service.
    // Using named routes (e.g., route('home')) is best practice if they are defined in web.php or api.php.
    // For now, using url() helper and request()->is() for active state.

    $navLinks = [
        ['name' => __('Home'), 'url' => url('/'), 'active_pattern' => '/'],
        // Assuming category pages will follow /services/{category_slug}
        // These could be dynamically generated from a Category model in a real app
        ['name' => __('Photography'), 'url' => url('/services/photography'), 'active_pattern' => 'services/photography*'],
        ['name' => __('Venues'), 'url' => url('/services/venues'), 'active_pattern' => 'services/venues*'],
        ['name' => __('Dresses'), 'url' => url('/services/dresses'), 'active_pattern' => 'services/dresses*'],
        ['name' => __('Makeup'), 'url' => url('/services/makeup'), 'active_pattern' => 'services/makeup*'],
        ['name' => __('About'), 'url' => url('/about'), 'active_pattern' => 'about*'],
        ['name' => __('Contact'), 'url' => url('/contact'), 'active_pattern' => 'contact*'],
    ];

    // Auth status - this would come from Laravel's Auth facade
    // For Blade, it's better to use @auth, @guest directives directly in the HTML part.
@endphp

<header class="site-header sticky-top shadow-sm">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                {{-- SVG RoyalCrown (from RoyalMotifs.tsx) - converted to inline SVG --}}
                <svg class="royal-motif me-2" width="32" height="32" viewBox="0 0 24 24" fill="none" style="color: var(--royal-gold-dark);">
                    <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" />
                    <circle cx="9" cy="4" r="1" fill="currentColor" />
                    <circle cx="12" cy="8" r="1" fill="currentColor" />
                    <circle cx="15" cy="4" r="1" fill="currentColor" />
                    <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z" fill="currentColor" />
                </svg>
                <span style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: bold; color: var(--royal-gold-dark);">
                    {{ __('Royal Vows') }}
                </span>
                {{-- FleurDeLis as a small accent (optional) --}}
                <svg class="royal-motif ms-1" width="16" height="16" viewBox="0 0 24 24" fill="none" style="color: var(--royal-gold-dark); opacity: 0.7; transform: translateY(-8px);">
                    {{-- Simplified FleurDeLis paths for brevity, ensure correct paths if using original --}}
                    <path d="M12 3L10 8L12 12L14 8L12 3Z" fill="currentColor"/>
                    <path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" fill="currentColor"/>
                    <path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" fill="currentColor"/>
                    <path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor"/>
                </svg>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavRoyal" aria-controls="mainNavRoyal" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span> {{-- Styled by style.css --}}
            </button>
            <div class="collapse navbar-collapse" id="mainNavRoyal">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    @foreach ($navLinks as $link)
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is(ltrim($link['active_pattern'], '/'))) active fw-semibold @endif" href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex align-items-center navbar-actions">
                    {{-- Search Input (simplified) --}}
                    <form class="d-none d-lg-flex me-3 position-relative" role="search" action="{{ url('/search-results') }}" method="GET"> {{-- Actual search route needed --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <input class="form-control form-control-sm search-input ps-5" type="search" name="query" placeholder="{{ __('Search services...') }}" aria-label="{{ __('Search') }}">
                    </form>

                    {{-- Auth-dependent actions --}}
                    <div id="navUserActions" class="d-flex align-items-center" style="display: none;"> {{-- Initially hidden, shown by JS if authenticated --}}
                        <a href="{{ url('/dashboard/favorites') }}" class="btn btn-sm btn-royal-outline me-2 text-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-heart me-1" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.281 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                            </svg>
                            {{ __('Favorites') }}
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-royal dropdown-toggle text-nowrap" type="button" id="userDropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                                <span id="navUserName">{{ __('User') }}</span> {{-- Name populated by JS --}}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li><a class="dropdown-item" href="{{ url('/bookings') }}">{{ __('My Bookings') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                     <a class="dropdown-item" href="#" id="logoutButton">{{ __('Logout') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="navGuestActions" class="d-flex align-items-center" style="display: none;"> {{-- Initially hidden, shown by JS if guest --}}
                        <a href="{{ url('/login') }}" class="btn btn-sm btn-royal-outline me-2 text-nowrap">{{ __('Sign In') }}</a>
                        <a href="{{ url('/register') }}" class="btn btn-sm btn-royal text-nowrap">{{ __('Sign Up') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
{{-- Styles for this header are in public/css/style.css under .site-header --}}
{{-- The navbar-toggler-icon is also styled in style.css to use the theme color --}}

{{-- JavaScript for mobile menu toggle is handled by Bootstrap 5's native JS --}}
{{-- Ensure Bootstrap JS is included in layouts/app.blade.php --}}

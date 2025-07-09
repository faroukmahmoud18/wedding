<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - @lang('Vendor Dashboard') - @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom Vendor Theme CSS (can use elements from main royal theme) -->
    {{-- <link href="{{ asset('css/vendor-theme.css') }}" rel="stylesheet"> --}}
     <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #FFF8F0; /* Ivory - same as main site */
            color: #4A3B31; /* Dark Brown - same as main site */
        }
        .vendor-sidebar {
            background-color: #795548; /* Lighter Brown from main theme for vendor sidebar */
            color: #FFFFFF;
            min-height: 100vh;
            padding-top: 1rem;
        }
        .vendor-sidebar .nav-link {
            color: #E1C699; /* Gold/beige for links */
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
        }
        .vendor-sidebar .nav-link:hover,
        .vendor-sidebar .nav-link.active {
            color: #FFFFFF;
            background-color: #5D4037; /* Darker brown for hover/active */
        }
         .vendor-header { /* Shared with admin, or can be distinct */
            background-color: #FFFFFF;
            border-bottom: 1px solid #DEE2E6;
            padding: 0.75rem 1rem;
            color: #4A3B31;
        }
        .vendor-header .navbar-brand {
            color: #4A3B31;
        }
        .card-royal-vendor { /* Similar to admin but can be different if needed */
            border: 1px solid #B08D57;
        }
        .card-royal-vendor .card-header {
            background-color: #E1C699;
            color: #4A3B31;
            font-weight: bold;
        }
        .btn-royal { /* Re-use from app.blade.php or define here if different context */
            background-color: #795548;
            border-color: #5D4037;
            color: #FFFFFF;
        }
        .btn-royal:hover {
            background-color: #5D4037;
            border-color: #4E342E;
            color: #FFFFFF;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="vendor-sidebar d-none d-md-block col-md-3 col-lg-2">
            <div class="position-sticky">
                <h4 class="text-center mb-4" style="color: #E1C699;">@lang('Vendor Panel')</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('vendor.dashboard') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
                            @lang('Dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('vendor.services.*') ? 'active' : '' }}" href="{{ route('vendor.services.index') }}">
                            @lang('My Services')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('vendor.bookings.*') ? 'active' : '' }}" href="{{ route('vendor.bookings.index') }}">
                            @lang('My Bookings')
                        </a>
                    </li>
                    {{-- Add more vendor navigation links: Profile settings etc. --}}
                    {{-- <li class="nav-item"><a class="nav-link" href="#">@lang('Profile Settings')</a></li> --}}

                    <li class="nav-item mt-auto">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">@lang('View Main Site')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-vendor').submit();">
                            @lang('Logout')
                        </a>
                        <form id="logout-form-vendor" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <div class="flex-grow-1">
             <header class="vendor-header d-flex justify-content-between align-items-center d-md-none">
                <a class="navbar-brand" href="{{ route('vendor.dashboard') }}">@lang('Vendor')</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#vendorSidebarMobile" aria-controls="vendorSidebarMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </header>
            {{-- Mobile Sidebar (hidden by default, shown on toggle) --}}
            <div class="collapse d-md-none" id="vendorSidebarMobile">
                 <nav class="vendor-sidebar">
                    <ul class="nav flex-column">
                         <li class="nav-item"><a class="nav-link {{ Route::is('vendor.dashboard') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">@lang('Dashboard')</a></li>
                         <li class="nav-item"><a class="nav-link {{ Route::is('vendor.services.*') ? 'active' : '' }}" href="{{ route('vendor.services.index') }}">@lang('My Services')</a></li>
                         <li class="nav-item"><a class="nav-link {{ Route::is('vendor.bookings.*') ? 'active' : '' }}" href="{{ route('vendor.bookings.index') }}">@lang('My Bookings')</a></li>
                         <li class="nav-item mt-auto"><a class="nav-link" href="{{ route('home') }}" target="_blank">@lang('View Main Site')</a></li>
                         <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-vendor-mobile').submit();">@lang('Logout')</a><form id="logout-form-vendor-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form></li>
                    </ul>
                </nav>
            </div>
            <main class="p-4">
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
                 @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>

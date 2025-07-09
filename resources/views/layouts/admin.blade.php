<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - @lang('Admin') - @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom Admin Theme CSS (can extend or be separate from main site's royal theme) -->
    {{-- <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet"> --}}
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #F5F5F5; /* Light grey for admin background */
            color: #333;
        }
        .admin-sidebar {
            background-color: #4A3B31; /* Dark Brown from main theme */
            color: #FFFFFF;
            min-height: 100vh;
            padding-top: 1rem;
        }
        .admin-sidebar .nav-link {
            color: #E1C699; /* Gold/beige for links */
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #FFFFFF;
            background-color: #795548; /* Lighter brown for hover/active */
        }
        .admin-header {
            background-color: #FFFFFF;
            border-bottom: 1px solid #DEE2E6;
            padding: 0.75rem 1rem;
            color: #4A3B31;
        }
        .admin-header .navbar-brand {
            color: #4A3B31;
        }
        .card-royal-admin {
            border: 1px solid #B08D57; /* Gold/bronze border */
        }
        .card-royal-admin .card-header {
            background-color: #E1C699; /* Gold/beige header */
            color: #4A3B31;
            font-weight: bold;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="admin-sidebar d-none d-md-block col-md-3 col-lg-2">
            <div class="position-sticky">
                <h4 class="text-center mb-4" style="color: #E1C699;">@lang('Admin Panel')</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            @lang('Dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.vendors.*') ? 'active' : '' }}" href="{{ route('admin.vendors.index') }}">
                            @lang('Manage Vendors')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.services.*') ? 'active' : '' }}" href="#"> {{-- Replace # with route('admin.services.index') when ready --}}
                            @lang('Manage Services')
                        </a>
                    </li>
                    {{-- Add more admin navigation links here: Bookings, Reviews, Users etc. --}}
                    <li class="nav-item mt-auto">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">@lang('View Main Site')</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                            @lang('Logout')
                        </a>
                        <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <div class="flex-grow-1">
            <header class="admin-header d-flex justify-content-between align-items-center d-md-none">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">@lang('Admin')</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminSidebarMobile" aria-controls="adminSidebarMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </header>
            {{-- Mobile Sidebar (hidden by default, shown on toggle) --}}
            <div class="collapse d-md-none" id="adminSidebarMobile">
                 <nav class="admin-sidebar">
                    <ul class="nav flex-column">
                         <li class="nav-item"><a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a></li>
                         <li class="nav-item"><a class="nav-link {{ Route::is('admin.vendors.*') ? 'active' : '' }}" href="{{ route('admin.vendors.index') }}">@lang('Manage Vendors')</a></li>
                         <li class="nav-item"><a class="nav-link" href="#">@lang('Manage Services')</a></li>
                         <li class="nav-item mt-auto"><a class="nav-link" href="{{ route('home') }}" target="_blank">@lang('View Main Site')</a></li>
                         <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-admin-mobile').submit();">@lang('Logout')</a><form id="logout-form-admin-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form></li>
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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Wedding Marketplace') }} - @yield('title', 'Welcome')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom CSS (for royal visual identity) -->
    {{-- <link href="{{ asset('css/theme.css') }}" rel="stylesheet"> --}}
    {{-- Link to your main theme CSS file here. For now, some inline styles for placeholders. --}}
    <style>
        body {
            font-family: 'Georgia', serif; /* Example: Elegant serif font */
            background-color: #FFF8F0; /* Example: A very light, warm off-white, like ivory */
            color: #4A3B31; /* Example: Dark brown for text */
        }
        .navbar-royal {
            background-color: #E1C699 !important; /* Example: Gold/beige accent, !important to override Bootstrap */
            border-bottom: 2px solid #B08D57; /* Darker gold/bronze for border */
        }
        .navbar-royal .navbar-brand,
        .navbar-royal .nav-link {
            color: #4A3B31; /* Dark brown for text on navbar */
            font-weight: bold;
        }
        .navbar-royal .nav-link:hover {
            color: #795548; /* Slightly lighter brown on hover */
        }
        .btn-royal {
            background-color: #795548; /* Main action button color (brown) */
            border-color: #5D4037; /* Darker border */
            color: #FFFFFF; /* White text */
        }
        .btn-royal:hover {
            background-color: #5D4037;
            border-color: #4E342E;
            color: #FFFFFF;
        }
        .footer-royal {
            background-color: #D7CCC8; /* Light, earthy tone for footer */
            color: #4A3B31;
            padding-top: 1rem;
            padding-bottom: 1rem;
            border-top: 1px solid #BCAAA4;
        }
        /* Add more styles for headings, cards, etc. to fit the royal theme */
    </style>

    @stack('styles') <!-- For page-specific styles -->
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-royal">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'RoyalAffairs') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                        </li>
                        {{-- Add more public navigation links here, e.g., service categories --}}
                         <li class="nav-item"><a class="nav-link" href="{{ route('services.category', ['category' => 'all']) }}">@lang('All Services')</a></li>


                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">@lang('Login')</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">@lang('Register')</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                    {{-- Placeholder for user roles - this will be dynamic based on User model --}}
                                    @php $userRole = Auth::user()->role ?? 'customer'; @endphp {{-- Default to 'customer' if no role --}}

                                    @if($userRole === 'admin')
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">@lang('Admin Dashboard')</a></li>
                                    @elseif($userRole === 'vendor')
                                         <li><a class="dropdown-item" href="{{ route('vendor.dashboard') }}">@lang('Vendor Dashboard')</a></li>
                                    @else
                                        {{-- <li><a class="dropdown-item" href="#">@lang('My Bookings')</a></li> --}}
                                    @endif
                                    {{-- Generic profile link if needed --}}
                                    {{-- <li><a class="dropdown-item" href="#">@lang('My Profile')</a></li> --}}
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            @lang('Logout')
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="footer-royal text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'RoyalAffairs') }}. @lang('All rights reserved.')</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    @stack('scripts') <!-- For page-specific scripts -->
</body>
</html>

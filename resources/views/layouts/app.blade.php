<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Wedding Marketplace') }} - @yield('title', 'Welcome')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Assuming Vite setup --}}
    {{-- If using Laravel Mix, it would be: <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}

    @stack('styles') <!-- For page-specific styles -->
</head>
<body class="font-sans antialiased bg-background text-foreground">
    <header class="bg-[hsl(var(--royal-ivory))] text-[hsl(var(--deep-brown))] shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 lg:px-6 py-3">
            <div class="flex flex-wrap justify-between items-center">
                <a class="text-2xl font-serif font-bold text-royal-gradient" href="{{ route('home') }}">{{ config('app.name', 'RoyalAffairs') }}</a>

                {{-- Mobile Menu Toggle --}}
                <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 ml-3 text-sm text-[hsl(var(--deep-brown))] rounded-lg lg:hidden hover:bg-[hsl(var(--royal-gold-light)/0.2)] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--royal-gold-light))]" aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                </button>

                <div class="hidden w-full lg:flex lg:w-auto lg:items-center" id="navbar-default">
                    {{-- Centered Navigation Links & Search --}}
                    <div class="flex flex-col lg:flex-row lg:items-center lg:mx-auto">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <a href="{{ route('home') }}" class="block py-2 pr-4 pl-3 rounded hover:bg-[hsl(var(--royal-gold-light)/0.1)] lg:hover:bg-transparent lg:border-0 lg:hover:text-[hsl(var(--royal-gold-dark))] lg:p-0 {{ request()->routeIs('home') ? 'text-[hsl(var(--royal-gold-dark))]' : '' }}">@lang('Home')</a>
                            </li>
                            <li>
                                <a href="{{ route('services.category', ['category' => 'all']) }}" class="block py-2 pr-4 pl-3 rounded hover:bg-[hsl(var(--royal-gold-light)/0.1)] lg:hover:bg-transparent lg:border-0 lg:hover:text-[hsl(var(--royal-gold-dark))] lg:p-0 {{ request()->routeIs('services.category') ? 'text-[hsl(var(--royal-gold-dark))]' : '' }}">@lang('All Services')</a>
                            </li>
                            {{-- Potentially add a dropdown for categories here using Tailwind --}}
                        </ul>

                        {{-- Search Bar - slightly offset or part of the central block --}}
                        <form class="flex mt-4 lg:mt-0 lg:ml-8" action="{{ route('search') }}" method="GET">
                            <input class="form-input block w-full px-3 py-2 border border-[hsl(var(--border))] rounded-l-md shadow-sm focus:outline-none focus:ring-[hsl(var(--royal-gold))] focus:border-[hsl(var(--royal-gold))] sm:text-sm" type="search" name="query" placeholder="Search services..." aria-label="Search" value="{{ request('query') ?? '' }}">
                            <button class="inline-flex items-center px-3 py-2 border border-l-0 border-[hsl(var(--royal-gold-dark))] bg-[hsl(var(--royal-gold-dark))] text-white rounded-r-md hover:bg-[hsl(var(--royal-gold))] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[hsl(var(--royal-gold))]" type="submit">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </button>
                        </form>
                    </div>

                    {{-- Right Aligned Auth Links --}}
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-6 lg:mt-0 lg:items-center">
                        @guest
                            @if (Route::has('login'))
                                <li><a href="{{ route('login') }}" class="btn-royal-outline px-4 py-2 text-sm">@lang('Login')</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="btn-royal px-4 py-2 text-sm">@lang('Register')</a></li>
                            @endif
                        @else
                            <li class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 py-2 px-3 rounded hover:bg-[hsl(var(--royal-gold-light)/0.1)] focus:outline-none">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-card rounded-md shadow-lg py-1 z-50 border border-border" style="display: none;">
                                    @php $userRole = Auth::user()->role ?? 'customer'; @endphp
                                    @if($userRole === \App\Models\User::ROLE_ADMIN)
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-foreground hover:bg-muted">@lang('Admin Dashboard')</a>
                                    @elseif($userRole === \App\Models\User::ROLE_VENDOR)
                                         <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 text-sm text-foreground hover:bg-muted">@lang('Vendor Dashboard')</a>
                                    @else
                                        {{-- <a href="#" class="block px-4 py-2 text-sm text-foreground hover:bg-muted">@lang('My Bookings')</a> --}}
                                    @endif
                                    {{-- <a href="#" class="block px-4 py-2 text-sm text-foreground hover:bg-muted">@lang('My Profile')</a> --}}
                                    <hr class="border-border my-1">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="block px-4 py-2 text-sm text-foreground hover:bg-muted">
                                        @lang('Logout')
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {{-- Add Alpine.js for dropdown interactivity if not already included via app.js --}}
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}

    <main class="container mx-auto py-8 px-4"> {{-- Tailwind container for main content --}}
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

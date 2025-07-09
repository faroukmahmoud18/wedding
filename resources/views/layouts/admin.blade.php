<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - @lang('Admin') - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Assuming Vite setup & admin uses the same compiled CSS --}}
    {{-- If using Laravel Mix: <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}

    {{-- Specific Admin Styles (if any, could be a separate CSS file compiled by Vite/Mix) --}}
    {{-- @vite(['resources/css/admin.css']) --}}

    @stack('styles')
</head>
<body class="font-sans antialiased bg-background text-foreground">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-[hsl(var(--sidebar-background))] text-[hsl(var(--sidebar-foreground))] transform lg:translate-x-0 transition-transform duration-300 ease-in-out"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center mb-6">
                    {{-- <img src="/path/to/admin-logo.png" alt="Admin Logo" class="h-10 mr-2"> --}}
                    <span class="text-2xl font-serif font-bold text-[hsl(var(--sidebar-primary))]">@lang('Admin Panel')</span>
                </a>
                <nav class="mt-4">
                    <a class="flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-[hsl(var(--sidebar-accent))] hover:text-[hsl(var(--sidebar-accent-foreground))] {{ Route::is('admin.dashboard') ? 'bg-[hsl(var(--sidebar-primary))] text-[hsl(var(--sidebar-primary-foreground))]' : '' }}" href="{{ route('admin.dashboard') }}">
                        {{-- <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i> --}} @lang('Dashboard')
                    </a>
                    <a class="mt-2 flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-[hsl(var(--sidebar-accent))] hover:text-[hsl(var(--sidebar-accent-foreground))] {{ Route::is('admin.vendors.*') ? 'bg-[hsl(var(--sidebar-primary))] text-[hsl(var(--sidebar-primary-foreground))]' : '' }}" href="{{ route('admin.vendors.index') }}">
                        {{-- <i class="fas fa-users-cog w-5 h-5 mr-3"></i> --}} @lang('Manage Vendors')
                    </a>
                    <a class="mt-2 flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-[hsl(var(--sidebar-accent))] hover:text-[hsl(var(--sidebar-accent-foreground))] {{ Route::is('admin.services.*') ? 'bg-[hsl(var(--sidebar-primary))] text-[hsl(var(--sidebar-primary-foreground))]' : '' }}" href="{{ route('admin.services.index') }}">
                        {{-- <i class="fas fa-concierge-bell w-5 h-5 mr-3"></i> --}} @lang('Manage Services')
                    </a>
                    <a class="mt-2 flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-[hsl(var(--sidebar-accent))] hover:text-[hsl(var(--sidebar-accent-foreground))] {{ Route::is('admin.categories.*') ? 'bg-[hsl(var(--sidebar-primary))] text-[hsl(var(--sidebar-primary-foreground))]' : '' }}" href="{{ route('admin.categories.index') }}">
                        {{-- <i class="fas fa-sitemap w-5 h-5 mr-3"></i> --}} @lang('Manage Categories')
                    </a>
                    {{-- Add more admin navigation links here --}}
                </nav>
            </div>
            <div class="p-4 mt-auto border-t border-[hsl(var(--sidebar-border))]">
                 <a class="flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-[hsl(var(--sidebar-accent))] hover:text-[hsl(var(--sidebar-accent-foreground))]" href="{{ route('home') }}" target="_blank">
                    {{-- <i class="fas fa-external-link-alt w-5 h-5 mr-3"></i> --}} @lang('View Main Site')
                </a>
                <a class="mt-2 flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-[hsl(var(--sidebar-accent))] hover:text-[hsl(var(--sidebar-accent-foreground))]" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                    {{-- <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i> --}} @lang('Logout')
                </a>
                <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col lg:ml-64"> {{-- Add margin for sidebar width on lg screens --}}
            <header class="bg-card shadow-sm sticky top-0 z-20 border-b border-border">
                <div class="container mx-auto px-4 lg:px-6 h-16 flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-foreground p-2 rounded-md hover:bg-muted focus:outline-none focus:ring">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="text-lg font-semibold text-foreground">@yield('title', 'Admin Area')</div>
                    <div>{{-- User menu or other header items can go here --}}</div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-6 bg-background">
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

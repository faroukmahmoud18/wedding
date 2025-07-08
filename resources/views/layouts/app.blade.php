<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', __('Royal Vows')) }} - @yield('title', __('Luxury Wedding Marketplace'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Any page-specific CSS -->
    @stack('styles')

</head>
<body>
    <div id="app-wrapper">

        @hasSection ('header')
            @yield('header')
        @else
            @include('partials.header')
        @endif

        <main class="py-4 page-content-wrapper">
            @yield('content')
        </main>

        @hasSection ('footer')
            @yield('footer')
        @else
            @include('partials.footer')
        @endif

    </div><!-- /#app-wrapper -->

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/config.js') }}"></script> {{-- Ensure config is loaded first --}}
    <script src="{{ asset('js/auth.js') }}"></script>   {{-- Auth logic and UI updater --}}
    <script src="{{ asset('js/main.js') }}"></script>   {{-- General site scripts --}}

    <!-- Any page-specific scripts -->
    @stack('scripts')

</body>
</html>

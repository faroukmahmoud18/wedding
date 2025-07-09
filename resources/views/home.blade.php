@extends('layouts.app')

@section('title', __('Homepage'))

@section('content')
<div class="container mx-auto px-4">
    {{-- Hero Section --}}
    <div class="py-12 md:py-20 rounded-lg bg-gradient-hero text-center mb-12 shadow-elegant">
        <div class="container mx-auto px-6 md:px-12">
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-[hsl(var(--deep-brown))] mb-6 ornament-border relative">@lang('Find Your Perfect Wedding Services')</h1>
            <p class="text-lg md:text-xl text-[hsl(var(--deep-brown)/0.8)] mb-8 max-w-3xl mx-auto">@lang('Discover top-rated vendors for your special day. Photography, venues, catering, and more, all in one place with a touch of royal elegance.')</p>
            {{-- Search Bar integrated from navbar, or a larger version here --}}
            <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto flex">
                <input type="text" class="form-input flex-grow block w-full px-4 py-3 border border-[hsl(var(--border))] rounded-l-lg shadow-sm focus:outline-none focus:ring-[hsl(var(--royal-gold))] focus:border-[hsl(var(--royal-gold))] text-lg" name="query" placeholder="@lang('Search services, e.g., Photography')">
                <button type="submit" class="btn-royal px-6 py-3 rounded-l-none text-lg -ml-px">@lang('Search')</button>
            </form>
        </div>
    </div>

    {{-- Featured Categories --}}
    @if(isset($categories) && $categories->count() > 0)
    <section class="py-10">
        <h2 class="text-3xl font-serif text-center text-[hsl(var(--deep-brown))] mb-8">@lang('Browse by Category')</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($categories as $category) {{-- Assuming $categories is now a collection of Category models --}}
            <a href="{{ route('services.category', ['category' => $category->slug]) }}" class="block card-royal p-4 text-center hover-lift">
                {{-- Category Image Placeholder - replace with actual image if available --}}
                <div class="w-24 h-24 bg-[hsl(var(--royal-gold-light)/0.2)] rounded-full mx-auto flex items-center justify-center mb-3">
                     {{-- Icon placeholder or <img src="{{ $category->image_url ?? 'placeholder.svg' }}"> --}}
                    <span class="text-3xl text-[hsl(var(--royal-gold-dark))] font-serif">{{ Str::limit($category->name, 1, '') }}</span>
                </div>
                <h3 class="font-serif text-lg font-semibold text-[hsl(var(--deep-brown))]">{{ $category->name }}</h3>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Featured Services --}}
    @if(isset($featuredServices) && $featuredServices->count() > 0)
    <section class="py-10 bg-[hsl(var(--warm-ivory))] rounded-lg my-12 shadow-elegant">
        <h2 class="text-3xl font-serif text-center text-[hsl(var(--deep-brown))] mb-8">@lang('Featured Services')</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4">
            @foreach($featuredServices as $service)
                @include('partials.service_card', ['service' => $service])
            @endforeach
        </div>
    </section>
    @endif

    {{-- Featured Vendors --}}
    @if(isset($featuredVendors) && $featuredVendors->count() > 0)
    <section class="py-10">
        <h2 class="text-3xl font-serif text-center text-[hsl(var(--deep-brown))] mb-8">@lang('Meet Our Esteemed Vendors')</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4">
            @foreach($featuredVendors as $vendor)
            <div class="card-royal p-4 text-center hover-lift">
                <a href="{{ route('vendors.profile', ['id' => $vendor->id]) }}" class="block">
                    <img src="{{ $vendor->logo_url }}" class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-full mx-auto mb-4 border-2 border-[hsl(var(--royal-gold-light))]" alt="{{ $vendor->name }}">
                    <h3 class="font-serif text-xl font-semibold text-[hsl(var(--deep-brown))] mb-1">{{ $vendor->name }}</h3>
                </a>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mb-3">{{ Str::limit($vendor->description ?? __('Leading provider of excellent services.'), 70) }}</p>
                <a href="{{ route('vendors.profile', ['id' => $vendor->id]) }}" class="btn-royal-outline text-sm px-4 py-2 mt-auto">@lang('View Profile')</a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- How it Works --}}
    <section class="py-16 bg-[hsl(var(--deep-brown))] text-[hsl(var(--ivory))] rounded-lg my-12 shadow-elegant">
        <h2 class="text-3xl font-serif text-center mb-10">@lang('How It Works')</h2>
        <div class="container mx-auto grid md:grid-cols-3 gap-8 text-center px-4">
            <div class="flex flex-col items-center">
                <div class="bg-[hsl(var(--royal-gold))] text-[hsl(var(--deep-brown))] w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mb-4">1</div>
                <h3 class="text-xl font-serif font-semibold mb-2">@lang('Search & Discover')</h3>
                <p class="text-sm text-[hsl(var(--ivory)/0.8)]">@lang('Find services by category, keyword, or location using our elegant search.')</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-[hsl(var(--royal-gold))] text-[hsl(var(--deep-brown))] w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mb-4">2</div>
                <h3 class="text-xl font-serif font-semibold mb-2">@lang('Compare & Choose')</h3>
                <p class="text-sm text-[hsl(var(--ivory)/0.8)]">@lang('View detailed profiles, beautiful portfolios, and genuine reviews.')</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-[hsl(var(--royal-gold))] text-[hsl(var(--deep-brown))] w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mb-4">3</div>
                <h3 class="text-xl font-serif font-semibold mb-2">@lang('Connect & Book')</h3>
                <p class="text-sm text-[hsl(var(--ivory)/0.8)]">@lang('Contact vendors directly to discuss your needs and secure your booking.')</p>
            </div>
        </div>
    </section>
</div>
@endsection

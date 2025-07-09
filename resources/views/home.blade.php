@extends('layouts.app')

@section('title', __('Homepage'))

@section('content')
<div class="container">
    {{-- Hero Section Placeholder --}}
    <div class="p-5 mb-4 bg-light rounded-3" style="background-image: url('https://via.placeholder.com/1200x400.png?text=Royal+Wedding+Marketplace+Hero'); background-size: cover; color: #fff; text-shadow: 2px 2px 4px #000000;">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">@lang('Find Your Perfect Wedding Services')</h1>
            <p class="col-md-8 fs-4">@lang('Discover top-rated vendors for your special day. Photography, venues, catering, and more, all in one place with a touch of royal elegance.')</p>
            {{-- Search Bar Placeholder --}}
            <form action="#" method="GET" class="row g-3 align-items-center"> {{-- Replace # with search route --}}
                <div class="col-auto">
                    <input type="text" class="form-control form-control-lg" name="search_query" placeholder="@lang('Search services, e.g., Photography')">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-royal btn-lg">@lang('Search')</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Featured Categories Placeholder --}}
    <section class="py-5">
        <h2 class="text-center mb-4">@lang('Browse by Category')</h2>
        <div class="row text-center">
            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories as $categoryName)
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card h-100 shadow-sm">
                        {{-- You might want a default image per category or a more sophisticated way to get category images --}}
                        <img src="https://via.placeholder.com/300x200.png?text={{ urlencode(Str::title(str_replace('_', ' ', $categoryName))) }}" class="card-img-top" alt="{{ Str::title(str_replace('_', ' ', $categoryName)) }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::title(str_replace('_', ' ', $categoryName)) }}</h5>
                            <a href="{{ route('services.category', ['category' => $categoryName]) }}" class="btn btn-outline-secondary btn-sm">@lang('Explore')</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @for ($i = 0; $i < 3; $i++) {{-- Fallback Placeholder loop --}}
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200.png?text=Category+{{ $i+1 }}" class="card-img-top" alt="Category Placeholder">
                        <div class="card-body">
                            <h5 class="card-title">@lang('Category Name') {{ $i+1 }}</h5>
                            <a href="#" class="btn btn-outline-secondary btn-sm">@lang('Explore')</a>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </section>

    {{-- Featured Services --}}
    @if(isset($featuredServices) && $featuredServices->count() > 0)
    <section class="py-5 bg-light rounded">
        <h2 class="text-center mb-4">@lang('Featured Services')</h2>
        <div class="row">
            @foreach($featuredServices as $service)
            <div class="col-md-6 col-lg-3 mb-4"> {{-- Adjusted grid for better display --}}
                <div class="card h-100 shadow-sm">
                     <img src="{{ $service->featured_image_url }}" class="card-img-top" alt="{{ $service->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ Str::limit($service->title, 50) }}</h5>
                        <p class="card-text text-muted small">@lang('By:') <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}">{{ $service->vendor->name }}</a></p>
                        <p class="card-text flex-grow-1">{{ Str::limit($service->short_desc, 70) }}</p>
                        <p class="card-text fw-bold">
                            @if($service->price_from)
                                @lang('From') ${{ number_format($service->price_from, 2) }}
                                @if($service->unit) <small class="text-muted">/ {{ $service->unit }}</small> @endif
                            @else
                                @lang('Price on request')
                            @endif
                        </p>
                        <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="btn btn-royal mt-auto align-self-start">@lang('View Details')</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Featured Vendors --}}
    @if(isset($featuredVendors) && $featuredVendors->count() > 0)
    <section class="py-5">
        <h2 class="text-center mb-4">@lang('Meet Our Vendors')</h2>
        <div class="row">
            @foreach($featuredVendors as $vendor)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm text-center">
                    <img src="{{ $vendor->logo_url }}" class="card-img-top mx-auto mt-3 rounded-circle" alt="{{ $vendor->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $vendor->name }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($vendor->about, 80) }}</p>
                        <a href="{{ route('vendors.profile', ['id' => $vendor->id]) }}" class="btn btn-outline-secondary mt-auto align-self-center">@lang('View Profile')</a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

    {{-- How it Works Placeholder --}}
    <section class="py-5">
        <h2 class="text-center mb-4">@lang('How It Works')</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="p-3">
                    {{-- Placeholder for an icon --}}
                    <div style="font-size: 3rem; color: #795548;">&#x1F50D;</div> {{-- Magnifying glass emoji as placeholder --}}
                    <h4>@lang('1. Search')</h4>
                    <p>@lang('Find services by category, keyword, or location.')</p>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="p-3">
                    <div style="font-size: 3rem; color: #795548;">&#x1F4CB;</div> {{-- Clipboard emoji --}}
                    <h4>@lang('2. Compare')</h4>
                    <p>@lang('View detailed profiles, portfolios, and reviews.')</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div style="font-size: 3rem; color: #795548;">&#x1F4DE;</div> {{-- Telephone receiver emoji --}}
                    <h4>@lang('3. Connect')</h4>
                    <p>@lang('Contact vendors directly to discuss your needs and book.')</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

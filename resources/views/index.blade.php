{{-- resources/views/index.blade.php --}}
@extends('layouts.app')

@section('title', __('Homepage - Welcome to Royal Vows'))

{{-- The header is included by default from layouts.app.blade.php unless overridden --}}
{{-- @section('header')
    @include('partials.header')
@endsection --}}

@section('content')
    {{-- Search Hero Section --}}
    <section class="search-hero-section position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--ivory) 0%, var(--soft-champagne) 100%); padding: 5rem 0 6rem;">
        {{-- Background Royal Motifs (using inline SVGs for simplicity) --}}
        <div class="position-absolute top-0 start-0 opacity-10" style="pointer-events: none; width:100%; height:100%;">
            <svg class="royal-motif position-absolute" width="80" height="80" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); top: 10%; left: 5%;">
                <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9" cy="4" r="1"/><circle cx="12" cy="8" r="1"/><circle cx="15" cy="4" r="1"/>
                <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z"/>
            </svg>
            <svg class="royal-motif position-absolute" width="60" height="60" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); top: 20%; right: 10%; opacity: 0.7;">
                <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg class="royal-motif position-absolute" width="100" height="100" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); bottom: 15%; left: 12%; opacity: 0.6;">
                <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.8"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
             <svg class="royal-motif position-absolute" width="70" height="70" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); bottom: 10%; right: 8%; opacity: 0.5;">
                <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="container position-relative">
            <div class="text-center mb-5">
                <div class="d-flex justify-content-center mb-3">
                    <svg class="royal-motif" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold-dark);">
                         <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                         <circle cx="9" cy="4" r="1"/><circle cx="12" cy="8" r="1"/><circle cx="15" cy="4" r="1"/>
                         <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z"/>
                    </svg>
                </div>
                <h1 class="font-serif display-3 fw-bold mb-3" style="color: var(--royal-deep-brown);">
                    {{ __('Your Dream Wedding') }}
                    <span class="d-block text-royal-gradient">{{ __('Starts Here') }}</span>
                </h1>
                <p class="lead mx-auto mb-4" style="color: var(--muted-text); max-width: 600px;">
                    {{ __('Discover premium wedding services from verified vendors. From photography to venues, create your perfect royal wedding experience.') }}
                </p>
                <div class="d-flex justify-content-center">
                    <div class="royal-border-element" style="width: 200px;"></div> {{-- Class from style.css --}}
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-10">
                    <div class="card card-royal shadow-elegant p-3 p-md-4">
                        <form action="{{-- {{ route('search.perform') }} --}}" method="GET"> {{-- Update with actual search route --}}
                            <div class="row gx-2 gy-3 align-items-center">
                                <div class="col-lg">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                                            {{-- Bootstrap Search Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                                        </span>
                                        <input type="text" name="query" class="form-control border-start-0" placeholder="{{ __('Search services, vendors...') }}" aria-label="{{ __('Search services, vendors') }}">
                                    </div>
                                </div>
                                <div class="col-lg-auto">
                                    @php
                                        // This would come from a service or config
                                        $searchCategories = [
                                            'photography' => '📸 ' . __('Photography'),
                                            'venues' => '🏰 ' . __('Venues'),
                                            'dresses' => '👗 ' . __('Dresses'),
                                            'makeup' => '💄 ' . __('Makeup'),
                                        ];
                                    @endphp
                                    <select name="category" class="form-select form-select-lg">
                                        <option value="" selected>{{ __('All Categories') }}</option>
                                        @foreach($searchCategories as $slug => $label)
                                        <option value="{{ $slug }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg">
                                     <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                                            {{-- Bootstrap Geo Alt Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                                        </span>
                                        <input type="text" name="location" class="form-control border-start-0" placeholder="{{ __('Location (e.g. city, zip)') }}" aria-label="{{ __('Location') }}">
                                    </div>
                                </div>
                                <div class="col-lg-auto d-grid">
                                    <button type="submit" class="btn btn-royal btn-lg px-md-4 text-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-search me-1 d-inline d-md-none d-lg-inline" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="mt-4 pt-4 border-top" style="border-color: hsla(var(--bs-primary-rgb), 0.2) !important;">
                            <p class="text-sm mb-2" style="color: var(--muted-text);">{{ __('Popular categories:') }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($searchCategories as $slug => $label)
                                <a href="{{-- {{ route('search.category', ['categorySlug' => $slug]) }} --}}" class="btn btn-sm btn-outline-secondary popular-category-btn">
                                    {{ $label }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Search Hero Section --}}

    {{-- Features Section (Why Choose Royal Vows?) --}}
    <section class="features-section py-5" style="background-color: var(--warm-ivory);">
        <div class="container py-md-4 py-3">
            <div class="text-center mb-5">
                <div class="d-inline-block mb-2" style="color: var(--royal-gold);">
                    {{-- RoyalOrnament SVG --}}
                    <svg class="royal-motif" width="36" height="36" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.8"/>
                        <circle cx="12" cy="12" r="3" fill="currentColor" />
                    </svg>
                </div>
                <h2 class="font-serif display-5 fw-bold mb-3" style="color: var(--royal-deep-brown);">{{ __('Why Choose Royal Vows?') }}</h2>
                <p class="lead mx-auto" style="color: var(--muted-text); max-width: 700px;">
                    {{ __('We connect you with the finest wedding vendors, ensuring your special day is nothing short of extraordinary.') }}
                </p>
                 <div class="d-flex justify-content-center mt-3">
                    <div class="royal-border-element" style="width: 150px;"></div>
                </div>
            </div>

            <div class="row gy-4 gx-lg-5 text-center">
                <div class="col-md-4">
                    <div class="feature-item p-3">
                        <div class="feature-icon mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle position-relative" style="width: 70px; height: 70px; background-color: hsla(var(--bs-primary-rgb), 0.05);">
                            {{-- Shield Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16" style="color: var(--royal-gold-dark);">
                                <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.06.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.953-.325-1.882-.725-2.837-.855A1.06 1.06 0 0 0 8 1.59zM8 13c-1.207 0-2.27-.27-3.146-.727l-.1-.057c-.035-.02-.06-.04-.078-.063l-.032-.042a.735.735 0 0 1-.026-.047l-.002-.004a.038.038 0 0 1-.002-.005c-.002-.002-.003-.003-.003-.004a.04.04 0 0 1-.004-.008L8 13zm0 0c1.207 0 2.27.27 3.146.727l.1.057c.035.02.06.04.078.063l.032.042a.735.735 0 0 0 .026-.047l.002-.004a.038.038 0 0 0 .002-.005c.002-.002.003-.003.003-.004a.04.04 0 0 0 .004-.008l.002-.005a.038.038 0 0 0 .002-.005l.002-.004a.04.04 0 0 0 .004-.008l.002-.005a.038.038 0 0 0 .002-.005c.002-.002-.003-.003-.003-.004a.04.04 0 0 0 .004-.008l.002-.005zm0 0V6.5L8 6.26V3.622a8.868 8.868 0 0 1 2.794.731.479.479 0 0 1 .328.39c.554 4.157-.726 7.19-2.253 9.188a10.725 10.725 0 0 1-1.144 1.098z"/>
                                <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            {{-- FleurDeLis as small accent on icon --}}
                            <svg class="royal-motif position-absolute" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold); top: -5px; right: -5px; opacity:0.6;">
                                <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="font-serif h5 fw-semibold my-2" style="color: var(--royal-deep-brown);">{{ __('Verified Vendors') }}</h3>
                        <p class="small" style="color: var(--muted-text);">{{ __('All our vendors are thoroughly vetted and verified to ensure the highest quality of service.') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item p-3">
                        <div class="feature-icon mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background-color: hsla(var(--bs-primary-rgb), 0.05);">
                            {{-- Heart Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16" style="color: var(--royal-gold-dark);">
                                <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.199.223.446.223.696l0 8.139a.5.5 0 0 1-.4.2H.823a.5.5 0 0 1-.4-.2l0-8.14c0-.25.074-.496.223-.696L3.1.7zM3.5 11h9V5L8 1.07 3.5 5v6z"/>
                            </svg>
                        </div>
                        <h3 class="font-serif h5 fw-semibold my-2" style="color: var(--royal-deep-brown);">{{ __('Personalized Service') }}</h3>
                        <p class="small" style="color: var(--muted-text);">{{ __('Receive tailored recommendations and dedicated support throughout your wedding planning journey.') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item p-3">
                        <div class="feature-icon mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background-color: hsla(var(--bs-primary-rgb), 0.05);">
                            {{-- Award Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-award-fill" viewBox="0 0 16 16" style="color: var(--royal-gold-dark);">
                                <path d="m8 0l1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
                                <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                            </svg>
                        </div>
                        <h3 class="font-serif h5 fw-semibold my-2" style="color: var(--royal-deep-brown);">{{ __('Award-Winning Platform') }}</h3>
                        <p class="small" style="color: var(--muted-text);">{{ __('Our platform and vendors have received numerous awards for excellence in wedding services.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Features Section --}}

    {{-- Categories Section --}}
    <section class="categories-section py-5">
        <div class="container py-md-4 py-3">
            <div class="text-center mb-5">
                 <div class="d-inline-block mb-2" style="color: var(--royal-gold);">
                    {{-- RoyalCrown SVG --}}
                    <svg class="royal-motif" width="36" height="36" viewBox="0 0 24 24" fill="none">
                        <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor"/>
                        <circle cx="9" cy="4" r="1" fill="currentColor" /><circle cx="12" cy="8" r="1" fill="currentColor" /><circle cx="15" cy="4" r="1" fill="currentColor" />
                        <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z" fill="currentColor" />
                    </svg>
                </div>
                <h2 class="font-serif display-5 fw-bold mb-3" style="color: var(--royal-deep-brown);">{{ __('Wedding Service Categories') }}</h2>
                <p class="lead mx-auto" style="color: var(--muted-text); max-width: 700px;">
                    {{ __('Explore our comprehensive range of wedding services, from photography to venues.') }}
                </p>
                <div class="d-flex justify-content-center mt-3">
                    <div class="royal-border-element" style="width: 150px;"></div>
                </div>
            </div>

            @php
                // Mimicking categoryConfig from sampleData.ts
                $categoryConfigData = [
                    'photography' => ['title' => __('Wedding Photography'), 'description' => __('Capture your special moments'), 'icon' => '📸', 'gradient' => 'from-purple-400 to-pink-400', 'serviceCount' => 12, 'slug' => 'photography'],
                    'venues' => ['title' => __('Wedding Venues'), 'description' => __('Find the perfect location'), 'icon' => '🏰', 'gradient' => 'from-blue-400 to-cyan-400', 'serviceCount' => 8, 'slug' => 'venues'],
                    'dresses' => ['title' => __('Wedding Dresses'), 'description' => __('Discover stunning dresses'), 'icon' => '👗', 'gradient' => 'from-pink-400 to-rose-400', 'serviceCount' => 15, 'slug' => 'dresses'],
                    'makeup' => ['title' => __('Bridal Makeup'), 'description' => __('Professional makeup & hairstyling'), 'icon' => '💄', 'gradient' => 'from-amber-400 to-orange-400', 'serviceCount' => 10, 'slug' => 'makeup'],
                ];
                // Gradient classes from Tailwind won't work directly, define simple CSS or use inline for these.
                // For simplicity, using a placeholder gradient here.
                $gradientStylesData = [
                    'from-purple-400 to-pink-400' => 'background-image: linear-gradient(135deg, #c084fc, #f472b6);',
                    'from-blue-400 to-cyan-400' => 'background-image: linear-gradient(135deg, #60a5fa, #22d3ee);',
                    'from-pink-400 to-rose-400' => 'background-image: linear-gradient(135deg, #f472b6, #fb7185);',
                    'from-amber-400 to-orange-400' => 'background-image: linear-gradient(135deg, #fbbf24, #fb923c);',
                ];
            @endphp

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                @foreach ($categoryConfigData as $categoryKey => $config)
                <div class="col">
                    <a href="{{ url('/services/' . $config['slug']) }}" class="text-decoration-none category-card-link">
                        <div class="card card-royal h-100 category-card hover-lift shadow-sm">
                            <div class="category-card-icon-header d-flex align-items-center justify-content-center text-white"
                                 style="height: 120px; {{ $gradientStylesData[$config['gradient']] ?? 'background-color: var(--soft-champagne);' }} border-top-left-radius: var(--bs-card-inner-border-radius); border-top-right-radius: var(--bs-card-inner-border-radius);">
                                <span style="font-size: 2.75rem; opacity: 0.95;">{{ $config['icon'] }}</span>
                            </div>
                            <div class="card-body p-3 p-md-4 text-center">
                                <h3 class="font-serif h5 card-title mb-2" style="color: var(--royal-deep-brown);">{{ $config['title'] }}</h3>
                                <p class="card-text small mb-3" style="color: var(--muted-text); font-size: 0.85rem;">{{ $config['description'] }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 p-3 pt-0 text-center">
                                <div class="d-flex justify-content-center align-items-center text-sm" style="color: var(--muted-text);">
                                    <span>{{ $config['serviceCount'] }} {{ __('services') }}</span>
                                    {{-- ArrowRight Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short category-arrow ms-2" viewBox="0 0 16 16" style="color: var(--royal-gold); opacity:0; transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;">
                                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- End Categories Section --}}

    {{-- Featured Services Section --}}
    <section class="featured-services-section py-5" style="background-color: var(--warm-ivory);">
        <div class="container py-md-4 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center text-center text-md-start mb-5">
                <div>
                    <div class="d-inline-block mb-2" style="color: var(--royal-gold);">
                        {{-- FleurDeLis SVG --}}
                        <svg class="royal-motif" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2 class="font-serif display-5 fw-bold mb-2 mb-md-0" style="color: var(--royal-deep-brown);">{{ __('Featured Services') }}</h2>
                    <p class="lead mb-3 mb-md-0" style="color: var(--muted-text);">
                        {{ __('Discover our handpicked premium wedding services from top-rated vendors.') }}
                    </p>
                </div>
                <a href="{{ url('/services') }}" class="btn btn-royal-outline mt-3 mt-md-0 align-self-center align-self-md-end d-none d-md-inline-flex">
                    {{ __('View All Services') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                    </svg>
                </a>
            </div>

            @php
                // Mimicking sampleServices and sampleVendors from sampleData.ts
                // In a real Laravel app, this data would come from the controller ($featuredServices)
                $sampleVendorsData = [
                    '1' => ['id' => '1', 'name' => __('Elegant Moments Photography')],
                    '2' => ['id' => '2', 'name' => __('Golden Manor Venues')],
                    '3' => ['id' => '3', 'name' => __('Couture Bridal Boutique')],
                ]; // This was already defined in Category section, ideally use a View Composer or pass once from controller

                $featuredServicesData = [
                    [
                        'id' => '1', 'vendorId' => '1', 'category' => 'photography', 'title' => __('Premium Wedding Photography Package'), 'slug' => 'premium-wedding-photography',
                        'shortDescription' => __('Full-day coverage, 2 photographers, editing, digital gallery.'),
                        'priceFrom' => 3500, 'unit' => __('package'), 'location' => __('Beverly Hills, CA'), 'rating' => 4.9, 'reviewCount' => 87, 'featured' => true,
                        'images' => [['path' => 'https://placehold.co/600x400/D4AF37/303030?text=Royal+Photo', 'alt' => __('Wedding ceremony photography'), 'isPrimary' => true]],
                        'features' => [__('2 Pro Photographers'), __('8-10 Hours Coverage'), __('500+ Edited Photos')],
                        'vendor' => $sampleVendorsData['1']
                    ],
                    [
                        'id' => '2', 'vendorId' => '2', 'category' => 'venues', 'title' => __('Enchanted Garden Wedding Venue'), 'slug' => 'enchanted-garden-venue',
                        'shortDescription' => __('Romantic outdoor ceremony with elegant indoor reception hall.'),
                        'priceFrom' => 8000, 'unit' => __('event'), 'location' => __('Napa Valley, CA'), 'rating' => 4.8, 'reviewCount' => 64, 'featured' => true,
                        'images' => [['path' => 'https://placehold.co/600x400/C0C0C0/303030?text=Royal+Venue', 'alt' => __('Garden ceremony setup'), 'isPrimary' => true]],
                        'features' => [__('Outdoor Ceremony'), __('Indoor Reception Hall'), __('Capacity 200 Guests')],
                        'vendor' => $sampleVendorsData['2']
                    ],
                    [
                        'id' => '3', 'vendorId' => '3', 'category' => 'dresses', 'title' => __('Designer Wedding Dress Collection'), 'slug' => 'designer-wedding-dress',
                        'shortDescription' => __('Exclusive designer gowns with personalized fitting & alterations.'),
                        'priceFrom' => 1200, 'unit' => __('dress'), 'location' => __('Manhattan, NY'), 'rating' => 4.9, 'reviewCount' => 142, 'featured' => true,
                        'images' => [['path' => 'https://placehold.co/600x400/FFC0CB/303030?text=Royal+Dress', 'alt' => __('Designer wedding dress showcase'), 'isPrimary' => true]],
                        'features' => [__('Designer Collections'), __('Personal Fitting'), __('Expert Alterations')],
                        'vendor' => $sampleVendorsData['3']
                    ],
                ];
            @endphp

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($featuredServicesData as $service)
                    <div class="col">
                        <div class="card card-royal h-100 service-card hover-lift shadow-sm position-relative">
                             @if($service['featured'])
                                <div class="position-absolute top-0 start-0 m-2" style="z-index: 1;">
                                    <span class="badge px-2 py-1" style="font-size: 0.7rem; background-color: var(--royal-gold); color: var(--deep-brown);">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-patch-check-fill me-1" viewBox="0 0 16 16" style="margin-top:-2px;">
                                            <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89.01-.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89-.01.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                        </svg>
                                        {{ __('Featured') }}
                                    </span>
                                </div>
                            @endif
                            <a href="{{ url('/services/' . $service['category'] . '/' . $service['slug']) }}" class="text-decoration-none service-card-image-link">
                                <img src="{{ $service['images'][0]['path'] ?? 'https://placehold.co/600x400/EEE/333?text=Service+Image' }}" class="card-img-top service-card-img" alt="{{ $service['images'][0]['alt'] ?? $service['title'] }}">
                            </a>
                            <div class="card-body p-3 d-flex flex-column">
                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <a href="{{-- {{ route('vendors.show', ['vendorId' => $service['vendorId']]) }} --}}" class="text-muted text-decoration-none hover-underline small vendor-link">
                                        {{ $service['vendor']['name'] }}
                                    </a>
                                    <span class="badge category-badge">{{ Str::ucfirst($service['category']) }}</span>
                                </div>
                                <h3 class="font-serif h6 card-title mb-2 flex-grow-1">
                                    <a href="{{ url('/services/' . $service['category'] . '/' . $service['slug']) }}" class="text-decoration-none service-title-link">
                                        {{ $service['title'] }}
                                    </a>
                                </h3>
                                <p class="card-text small mb-3 service-short-description">
                                    {{ Str::limit($service['shortDescription'], 70) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center text-sm mb-3 service-meta">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-geo-alt-fill me-1 icon-gold" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        </svg> {{ $service['location'] }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-star-fill me-1 icon-amber" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg> {{ $service['rating'] }} ({{ $service['reviewCount'] }})
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 fw-bold service-price">
                                            ${{ number_format($service['priceFrom']) }}
                                            <span class="text-muted fw-normal small">/ {{ $service['unit'] }}</span>
                                        </p>
                                        <a href="{{ url('/services/' . $service['category'] . '/' . $service['slug']) }}" class="btn btn-sm btn-royal">{{ __('View Details') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
             <div class="text-center mt-5 d-md-none"> {{-- Show on mobile only --}}
                <a href="{{ url('/services') }}" class="btn btn-royal-outline btn-lg">
                    {{ __('View All Services') }}
                </a>
            </div>
        </div>
    </section>
    {{-- End Featured Services Section --}}

    {{-- CTA Section --}}
    <section class="cta-section py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--royal-gold), var(--royal-gold-dark)); color: var(--warm-ivory);">
        {{-- Background Royal Motifs --}}
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="pointer-events: none;">
            <svg class="royal-motif position-absolute" width="100" height="100" viewBox="0 0 24 24" fill="currentColor" style="color: var(--warm-ivory); top: 10%; left: 15%; transform: rotate(15deg);">
                <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="0.3" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
                <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="0.3" opacity="0.5"/>
            </svg>
            <svg class="royal-motif position-absolute" width="120" height="120" viewBox="0 0 24 24" fill="currentColor" style="color: var(--warm-ivory); bottom: 5%; right: 10%; transform: rotate(-25deg);">
                 <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
                <circle cx="9" cy="4" r="0.8" opacity="0.5"/><circle cx="12" cy="8" r="0.8" opacity="0.5"/><circle cx="15" cy="4" r="0.8" opacity="0.5"/>
                <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z" opacity="0.5"/>
            </svg>
        </div>
        <div class="container text-center position-relative py-md-5 py-4">
            <h2 class="font-serif display-4 fw-bold mb-3">{{ __('Ready to Plan Your Dream Wedding?') }}</h2>
            <p class="lead mx-auto mb-4" style="max-width: 700px; opacity: 0.9;">
                {{ __('Join thousands of couples who found their perfect wedding vendors through Royal Vows. Start your journey today.') }}
            </p>
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="{{ url('/services') }}" class="btn btn-lg cta-btn-primary">{{ __('Browse All Services') }}</a>
                <a href="{{-- {{ route('vendor.register') }} --}}" class="btn btn-lg cta-btn-secondary">{{ __('Become a Vendor') }}</a>
            </div>
        </div>
    </section>
    {{-- End CTA Section --}}
@endsection

{{-- The footer is included by default from layouts.app.blade.php unless overridden --}}
{{-- @section('footer')
    @include('partials.footer')
@endsection --}}

@push('scripts')
    {{-- Add any page-specific JavaScript for index.blade.php here --}}
    {{-- <script>console.log('Index page scripts loaded');</script> --}}
@endpush

@push('styles')
    {{-- Add any page-specific CSS for index.blade.php here --}}
    {{-- <style>.example-class { color: red; }</style> --}}
@endpush

@extends('layouts.app')

@section('title', $service->title ?? __('Service Details'))

@section('content')
<div class="container">
    {{-- Breadcrumbs Placeholder --}}
    <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
            @if(isset($service) && $service->category)
            <li class="breadcrumb-item"><a href="{{ route('services.category', ['category' => $service->category]) }}">{{ $service->category_name }}</a></li>
            @else
            <li class="breadcrumb-item"><a href="{{ route('services.category', ['category' => 'all']) }}">@lang('Services')</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $service->title ?? __('Service Detail') }}</li>
        </ol>
    </nav>

    @if(isset($service) && $service->vendor) {{-- Ensure service and its vendor exist --}}
    <div class="row">
        <!-- Service Images Column -->
        <div class="col-md-7">
            {{-- Main Image --}}
            <div class="mb-3">
                <img src="{{ $service->featured_image_url }}" class="img-fluid rounded shadow-sm" alt="{{ $service->title }}" id="mainServiceImage" style="max-height: 500px; width: 100%; object-fit: cover;">
            </div>
            {{-- Thumbnail Images --}}
            @if($service->images && $service->images->count() > 1) {{-- Show thumbnails if more than one image --}}
            <div class="row gx-2">
                @foreach($service->images as $image)
                <div class="col-3 mb-2">
                    <img src="{{ $image->path_url ?? Storage::disk('public')->url($image->path) }}" class="img-thumbnail" alt="{{ $image->alt ?? $service->title }}" style="cursor:pointer; height: 100px; width:100%; object-fit:cover;" onclick="document.getElementById('mainServiceImage').src='{{ Storage::disk('public')->url($image->path) }}'">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Service Details Column -->
        <div class="col-md-5">
            <h1 class="fw-bold" style="color: #5D4037;">{{ $service->title }}</h1>
            <p class="text-muted">@lang('Offered by:') <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}">{{ $service->vendor->name }}</a></p>

            <div class="my-3">
                <span class="fw-bold fs-4" style="color: #795548;">
                    @if($service->price_from && $service->price_to)
                        ${{ number_format($service->price_from, 2) }} - ${{ number_format($service->price_to, 2) }}
                    @elseif($service->price_from)
                        @lang('From') ${{ number_format($service->price_from, 2) }}
                    @else
                        @lang('Price on request')
                    @endif
                </span>
                @if($service->unit)
                <span class="text-muted">/ {{ $service->unit }}</span>
                @endif
            </div>

            <p class="lead">{{ $service->short_desc }}</p>

            {{-- Booking Form Placeholder --}}
            <div class="card my-4 shadow-sm card-royal-vendor">
                <div class="card-header">
                    @lang('Request Booking or Information')
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        {{-- <input type="hidden" name="vendor_id" value="{{ $service->vendor_id }}"> --}}

                        <div class="mb-3">
                            <label for="event_date" class="form-label">@lang('Preferred Event Date')</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">@lang('Quantity/Guests') ({{ $service->unit ?? 'units' }})</label>
                            <input type="number" class="form-control" id="qty" name="qty" value="1" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="booking_message" class="form-label">@lang('Message (Optional)')</label>
                            <textarea class="form-control" id="booking_message" name="message" rows="3" placeholder="@lang('Any specific requests or questions?')"></textarea>
                        </div>
                        @auth
                            <button type="submit" class="btn btn-royal w-100">@lang('Submit Booking Request')</button>
                        @else
                            <p class="text-center"><em><a href="{{ route('login', ['redirect' => url()->current()]) }}">@lang('Login')</a> @lang('or') <a href="{{ route('register') }}">@lang('Register')</a> @lang('to book this service.')</em></p>
                            <button type="submit" class="btn btn-royal w-100" disabled>@lang('Submit Booking Request')</button>
                        @endauth
                    </form>
                </div>
            </div>

            {{-- Add to Favorites/Wishlist Placeholder --}}
            {{-- <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-heart"></i> @lang('Add to Wishlist')</button> --}}
        </div>
    </div>

    <!-- Long Description, Reviews, Vendor Info Tabs -->
    <div class="mt-5">
        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">@lang('Full Description')</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">@lang('Reviews') ({{ $service->reviews_count ?? 0 }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vendor-info-tab" data-bs-toggle="tab" data-bs-target="#vendor-info" type="button" role="tab" aria-controls="vendor-info" aria-selected="false">@lang('About the Vendor')</button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="serviceTabsContent">
            <div class="tab-pane fade show active p-3 border rounded bg-white" id="description" role="tabpanel" aria-labelledby="description-tab">
                {!! nl2br(e($service->long_desc)) !!}
                {{-- Display service_meta here if applicable --}}
                @if($service->tags && count($service->tags) > 0)
                    <div class="mt-3">
                        <strong>@lang('Tags:')</strong>
                        @foreach($service->tags as $tag)
                            <span class="badge bg-light text-dark border me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
                 @if($service->location_text)
                    <div class="mt-3">
                        <strong>@lang('Location/Area Served:')</strong> {{ $service->location_text }}
                    </div>
                @endif
            </div>
            <div class="tab-pane fade p-3 border rounded bg-white" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <h5 class="mb-3">@lang('Customer Reviews')</h5>
                @if($service->reviews && $service->reviews->count() > 0)
                    @foreach($service->reviews as $review)
                        <div class="review mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $review->user->name ?? __('Anonymous') }}</strong>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="my-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $review->rating ? '#FFC107' : '#E0E0E0' }}; font-size: 1.1em;">&#9733;</span>
                                @endfor
                            </div>
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                @else
                    <p>@lang('No reviews yet for this service. Be the first to leave a review!')</p>
                @endif
                {{-- Add Review Form Placeholder (for logged-in users who have used the service) --}}
                {{-- Consider adding a simple review form here for authenticated users --}}
            </div>
            <div class="tab-pane fade p-3 border rounded bg-white" id="vendor-info" role="tabpanel" aria-labelledby="vendor-info-tab">
                <h4>{{ $service->vendor->name }}</h4>
                @if($service->vendor->logo_url)
                    <img src="{{ $service->vendor->logo_url }}" alt="{{ $service->vendor->name }}" class="img-thumbnail float-start me-3 mb-2" style="width: 100px;">
                @endif
                <p>{{ $service->vendor->about }}</p>
                <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}" class="btn btn-sm btn-outline-secondary">@lang('View Full Vendor Profile')</a>
            </div>
        </div>
    </div>

    {{-- Related Services --}}
    @if(isset($relatedServices) && $relatedServices->count() > 0)
    <section class="py-5 mt-4">
        <h3 class="mb-4">@lang('You Might Also Like')</h3>
        <div class="row">
            @foreach($relatedServices as $relatedService)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                     <a href="{{ route('services.show', ['slug' => $relatedService->slug]) }}">
                        <img src="{{ $relatedService->featured_image_url }}" class="card-img-top" alt="{{ $relatedService->title }}" style="height: 180px; object-fit: cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><a href="{{ route('services.show', ['slug' => $relatedService->slug]) }}" class="text-decoration-none" style="color: #5D4037;">{{ Str::limit($relatedService->title, 45) }}</a></h5>
                        <p class="card-text text-muted small flex-grow-1">
                            @if($relatedService->vendor)
                            @lang('By:') {{ $relatedService->vendor->name }}
                            @endif
                        </p>
                        <a href="{{ route('services.show', ['slug' => $relatedService->slug]) }}" class="btn btn-sm btn-royal align-self-start">@lang('View')</a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

    @else
        <div class="alert alert-warning" role="alert">
            @lang('Service details could not be loaded at this time. Please try again later or contact support.')
        </div>
        <a href="{{ route('home') }}" class="btn btn-royal">@lang('Back to Homepage')</a>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Example: Change main image on thumbnail click (if not using Bootstrap carousel)
    // This is a basic version, a more robust solution might be needed.
    // Already added inline onclick for simplicity in the HTML for thumbnails.
</script>
@endpush

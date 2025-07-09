<div class="card h-100 shadow-sm">
    <a href="{{ route('services.show', ['slug' => $service->slug]) }}">
        {{-- Use a placeholder if featured_image_url is not set or default image --}}
        <img src="{{ $service->featured_image_url ?? asset('images/placeholder-service.jpg') }}"
             class="card-img-top"
             alt="{{ $service->title }}"
             style="height: 200px; object-fit: cover; border-top-left-radius: var(--bs-card-inner-border-radius); border-top-right-radius: var(--bs-card-inner-border-radius);">
    </a>
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">
            <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="text-decoration-none" style="color: #5D4037;">
                {{ Str::limit($service->title, 50) }}
            </a>
        </h5>

        @if($service->category)
            <small class="text-muted mb-1">
                <a href="{{ route('services.category', ['category' => $service->category->slug]) }}" class="text-decoration-none text-muted">
                    {{ $service->category->name }}
                </a>
            </small>
        @endif

        @if($service->vendor)
            <p class="card-text text-muted small mb-2">
                @lang('By:') <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}" class="text-decoration-none">{{ $service->vendor->name }}</a>
            </p>
        @endif

        <p class="card-text flex-grow-1">{{ Str::limit($service->short_desc ?? $service->description ?? 'No description available.', 100) }}</p>

        <p class="card-text fw-bold mb-2">
            @if($service->price)
                {{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }}
                @if($service->price_unit)
                    <small class="text-muted">/ {{ $service->price_unit }}</small>
                @endif
            @else
                @lang('Contact for Price')
            @endif
        </p>
        <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="btn btn-sm btn-royal mt-auto align-self-start">@lang('View Details')</a>
    </div>
    {{-- Add rating display if available, e.g., stars --}}
    {{-- @if($service->average_rating)
        <div class="card-footer bg-transparent border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Rating: {{ number_format($service->average_rating, 1) }}/5</small>
                <div>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi {{ $i <= round($service->average_rating) ? 'bi-star-fill' : 'bi-star' }}" style="color: #FFD700;"></i>
                    @endfor
                </div>
            </div>
        </div>
    @endif --}}
</div>

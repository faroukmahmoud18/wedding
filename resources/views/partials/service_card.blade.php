<div class="card-royal flex flex-col h-full overflow-hidden hover-lift">
    <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="block">
        <img src="{{ $service->featured_image_url ?? asset('images/placeholder-service.jpg') }}"
             alt="{{ $service->title }}"
             class="w-full h-48 object-cover"> {{-- Tailwind classes for image --}}
    </a>
    <div class="p-4 flex flex-col flex-grow">
        <h3 class="text-lg font-serif font-semibold mb-1">
            <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="hover:text-[hsl(var(--royal-gold-dark))] transition-colors">
                {{ Str::limit($service->title, 45) }}
            </a>
        </h3>

        @if($service->category)
            <a href="{{ route('services.category', ['category' => $service->category->slug]) }}" class="text-xs text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--royal-gold-dark))] transition-colors mb-1 inline-block">
                {{ $service->category->name }}
            </a>
        @endif

        @if($service->vendor)
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-2">
                @lang('By:') <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}" class="hover:text-[hsl(var(--royal-gold-dark))] transition-colors">{{ $service->vendor->name }}</a>
            </p>
        @endif

        <p class="text-sm text-[hsl(var(--foreground))] flex-grow mb-3">{{ Str::limit($service->short_desc ?? $service->description ?? __('No description available.'), 80) }}</p>

        <div class="flex justify-between items-center mb-3">
            <p class="text-lg font-serif font-semibold text-[hsl(var(--royal-gold-dark))]">
                @if($service->price)
                    {{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }}
                    @if($service->price_unit)
                        <span class="text-xs font-sans text-[hsl(var(--muted-foreground))]">/ {{ $service->price_unit }}</span>
                    @endif
                @else
                    @lang('Contact for Price')
                @endif
            </p>
            @if($service->average_rating > 0)
            <div class="flex items-center">
                <svg class="w-4 h-4 text-yellow-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                <span class="text-xs text-[hsl(var(--muted-foreground))] ml-1">{{ number_format($service->average_rating, 1) }}</span>
            </div>
            @endif
        </div>

        <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="btn-royal-outline w-full text-center text-sm mt-auto">@lang('View Details')</a>
    </div>
</div>

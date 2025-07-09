@extends('layouts.app')

@section('title', $service->title ?? __('Service Details'))

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumbs --}}
    <nav class="mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2 text-[hsl(var(--muted-foreground))]">
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('Home')</a>
            </li>
            <li><span class="mx-2">/</span></li>
            @if(isset($service) && $service->category)
            <li class="flex items-center">
                <a href="{{ route('services.category', ['category' => $service->category->slug]) }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">{{ $service->category_name }}</a>
            </li>
            <li><span class="mx-2">/</span></li>
            @else
            <li class="flex items-center">
                <a href="{{ route('services.category', ['category' => 'all']) }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('Services')</a>
            </li>
            <li><span class="mx-2">/</span></li>
            @endif
            <li class="text-[hsl(var(--foreground))]" aria-current="page">{{ Str::limit($service->title ?? __('Service Detail'), 50) }}</li>
        </ol>
    </nav>

    @if(isset($service) && $service->vendor)
    <div class="lg:flex lg:space-x-8">
        <!-- Service Images Column -->
        <div class="lg:w-7/12 mb-8 lg:mb-0">
            <div class="mb-4">
                <img src="{{ $service->featured_image_url }}" class="w-full h-auto max-h-[70vh] object-contain md:object-cover rounded-lg shadow-elegant" alt="{{ $service->title }}" id="mainServiceImage">
            </div>
            {{-- Thumbnail Images --}}
            @if($service->images && $service->images->count() > 0) {{-- Assuming $service->images is for additional images --}}
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                {{-- Display featured image as first thumbnail if not part of images collection --}}
                 <div class="aspect-square">
                    <img src="{{ $service->featured_image_url }}" class="w-full h-full object-cover rounded-md shadow-sm cursor-pointer border-2 border-[hsl(var(--royal-gold))]" alt="{{ $service->title }} thumbnail" onclick="document.getElementById('mainServiceImage').src='{{ $service->featured_image_url }}'">
                </div>
                @foreach($service->images as $image)
                <div class="aspect-square">
                    <img src="{{ $image->image_url }}" class="w-full h-full object-cover rounded-md shadow-sm cursor-pointer hover:border-2 hover:border-[hsl(var(--royal-gold))]" alt="{{ $image->caption ?? $service->title }}" onclick="document.getElementById('mainServiceImage').src='{{ $image->image_url }}'">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Service Details Column -->
        <div class="lg:w-5/12">
            <h1 class="text-3xl md:text-4xl font-serif font-bold text-[hsl(var(--deep-brown))] mb-2">{{ $service->title }}</h1>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                @lang('Offered by:')
                <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline font-medium">{{ $service->vendor->name }}</a>
            </p>

            <div class="my-4">
                <span class="text-3xl font-serif font-bold text-[hsl(var(--royal-gold-dark))]">
                    @if($service->price)
                        {{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }}
                    @else
                        @lang('Contact for Price')
                    @endif
                </span>
                @if($service->price && $service->price_unit)
                <span class="text-sm text-[hsl(var(--muted-foreground))]">/ {{ $service->price_unit }}</span>
                @endif
            </div>

            @if($service->average_rating > 0)
            <div class="flex items-center mb-4">
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($service->average_rating) ? 'text-yellow-400' : 'text-gray-300' }} fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                @endfor
                <span class="ml-2 text-sm text-[hsl(var(--muted-foreground))]">({{ $service->reviews()->approved()->count() }} @lang('reviews'))</span>
            </div>
            @endif

            <p class="text-base text-[hsl(var(--foreground))] leading-relaxed mb-6">{{ $service->short_desc }}</p>

            {{-- Booking Form --}}
            <div class="card-royal p-6 my-6">
                <h3 class="text-xl font-serif font-semibold text-[hsl(var(--deep-brown))] mb-4">@lang('Request Booking or Information')</h3>
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <div class="mb-4">
                        <label for="booking_date" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Preferred Event Date')</label>
                        <input type="date" class="form-input mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50" id="booking_date" name="booking_date" required>
                    </div>
                    <div class="mb-4">
                        <label for="guests" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Number of Guests/Units')</label>
                        <input type="number" class="form-input mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50" id="guests" name="guests" value="1" min="1" required>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Message (Optional)')</label>
                        <textarea class="form-textarea mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50" id="message" name="message" rows="3" placeholder="@lang('Any specific requests or questions?')"></textarea>
                    </div>
                    @auth
                        <button type="submit" class="btn-royal w-full text-lg py-3">@lang('Submit Booking Request')</button>
                    @else
                        <p class="text-center text-sm text-[hsl(var(--muted-foreground))] mb-3"><em><a href="{{ route('login', ['redirect' => url()->current()]) }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('Login')</a> @lang('or') <a href="{{ route('register') }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('Register')</a> @lang('to book this service.')</em></p>
                        <button type="button" class="btn-royal w-full text-lg py-3 opacity-50 cursor-not-allowed" disabled>@lang('Submit Booking Request')</button>
                    @endauth
                </form>
            </div>
        </div>
    </div>

    <!-- Long Description, Reviews, Vendor Info Tabs -->
    <div class="mt-12" x-data="{ activeTab: 'description' }">
        <div class="border-b border-[hsl(var(--border))]">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="activeTab = 'description'" :class="{ 'border-[hsl(var(--royal-gold-dark))] text-[hsl(var(--royal-gold-dark))]': activeTab === 'description', 'border-transparent text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))] hover:border-gray-300': activeTab !== 'description' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg focus:outline-none">
                    @lang('Full Description')
                </button>
                <button @click="activeTab = 'reviews'" :class="{ 'border-[hsl(var(--royal-gold-dark))] text-[hsl(var(--royal-gold-dark))]': activeTab === 'reviews', 'border-transparent text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))] hover:border-gray-300': activeTab !== 'reviews' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg focus:outline-none">
                    @lang('Reviews') ({{ $service->reviews()->approved()->count() }})
                </button>
                <button @click="activeTab = 'vendor'" :class="{ 'border-[hsl(var(--royal-gold-dark))] text-[hsl(var(--royal-gold-dark))]': activeTab === 'vendor', 'border-transparent text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))] hover:border-gray-300': activeTab !== 'vendor' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg focus:outline-none">
                    @lang('About the Vendor')
                </button>
            </nav>
        </div>
        <div class="py-6">
            <div x-show="activeTab === 'description'" class="prose max-w-none text-[hsl(var(--foreground))]">
                {!! nl2br(e($service->description)) !!}
                @if($service->tags && (is_array($service->tags) ? count($service->tags) > 0 : !empty($service->tags)))
                    <div class="mt-6">
                        <strong class="font-semibold">@lang('Tags:')</strong>
                        @php $tags = is_array($service->tags) ? $service->tags : json_decode($service->tags, true) ?? (is_string($service->tags) ? array_map('trim', explode(',', $service->tags)) : []); @endphp
                        @foreach($tags as $tag)
                            <span class="inline-block bg-[hsl(var(--royal-gold-light)/0.2)] text-[hsl(var(--royal-gold-dark))] text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
                 @if($service->location_text)
                    <div class="mt-4">
                        <strong class="font-semibold">@lang('Location/Area Served:')</strong> {{ $service->location_text }}
                    </div>
                @endif
            </div>
            <div x-show="activeTab === 'reviews'">
                <h3 class="text-xl font-serif font-semibold text-[hsl(var(--deep-brown))] mb-4">@lang('Customer Reviews')</h3>
                @forelse($service->reviews()->approved()->latest()->get() as $review)
                    <div class="mb-6 pb-6 border-b border-[hsl(var(--border))]">
                        <div class="flex items-center mb-2">
                            <strong class="text-md font-semibold text-[hsl(var(--foreground))]">{{ $review->user->name ?? __('Anonymous') }}</strong>
                            <span class="text-xs text-[hsl(var(--muted-foreground))] ml-2">- {{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @endfor
                        </div>
                        <p class="text-base text-[hsl(var(--foreground))] italic">"{{ $review->comment }}"</p>
                    </div>
                @empty
                    <p class="text-[hsl(var(--muted-foreground))]">@lang('No reviews yet for this service.')</p>
                @endforelse
                {{-- Add Review Form Placeholder --}}
            </div>
            <div x-show="activeTab === 'vendor'" class="card-royal p-6">
                <div class="flex items-center">
                    @if($service->vendor->logo_url)
                        <img src="{{ $service->vendor->logo_url }}" alt="{{ $service->vendor->name }}" class="w-20 h-20 rounded-full object-cover mr-4 border border-[hsl(var(--border))]">
                    @endif
                    <div>
                        <h3 class="text-xl font-serif font-semibold text-[hsl(var(--deep-brown))]">{{ $service->vendor->name }}</h3>
                        {{-- Vendor specific short info if available --}}
                    </div>
                </div>
                <p class="mt-4 text-base text-[hsl(var(--foreground))] leading-relaxed">{{ $service->vendor->description ?? __('This vendor has not provided a detailed description yet.') }}</p>
                <a href="{{ route('vendors.profile', ['id' => $service->vendor->id]) }}" class="btn-royal-outline mt-4 inline-block">@lang('View Full Vendor Profile')</a>
            </div>
        </div>
    </div>

    {{-- Related Services --}}
    @if(isset($relatedServices) && $relatedServices->count() > 0)
    <section class="py-12 mt-8">
        <h2 class="text-3xl font-serif text-center text-[hsl(var(--deep-brown))] mb-8">@lang('You Might Also Like')</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($relatedServices as $relatedService)
                @include('partials.service_card', ['service' => $relatedService])
            @endforeach
        </div>
    </section>
    @endif

    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">@lang('Error:')</strong>
            <span class="block sm:inline">@lang('Service details could not be loaded at this time. Please try again later or contact support.')</span>
        </div>
        <div class="mt-6">
            <a href="{{ route('home') }}" class="btn-royal">@lang('Back to Homepage')</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
{{-- Alpine.js should be included globally via app.js for x-data to work --}}
<script>
    // Simple JS for image thumbnail click to change main image
    // This can be enhanced or replaced by a more robust gallery component if needed
    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.getElementById('mainServiceImage');
        const thumbnails = document.querySelectorAll('.aspect-square img'); // Adjust selector if needed

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                if (mainImage) {
                    mainImage.src = this.src;
                }
                // Optional: Add active state to thumbnail
                thumbnails.forEach(t => t.classList.remove('border-[hsl(var(--royal-gold))]', 'border-2'));
                this.classList.add('border-[hsl(var(--royal-gold))]', 'border-2');
            });
        });
    });
</script>
@endpush

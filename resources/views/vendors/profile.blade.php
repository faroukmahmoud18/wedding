@extends('layouts.app')

@section('title', $vendor->name ?? __('Vendor Profile'))

@section('content')
<div class="container">
    @if(isset($vendor))
    {{-- Breadcrumbs Placeholder --}}
    <nav aria-label="breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
            {{-- Optionally, link to a vendors listing page if one exists --}}
            {{-- <li class="breadcrumb-item"><a href="#">@lang('Vendors')</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">{{ $vendor->name }}</li>
        </ol>
    </nav>

    <div class="lg:flex lg:space-x-8">
        <!-- Vendor Details Column -->
        <aside class="lg:w-1/3 mb-8 lg:mb-0">
            <div class="card-royal p-6 text-center">
                <img src="{{ $vendor->logo_url }}" class="w-32 h-32 md:w-40 md:h-40 object-cover rounded-full mx-auto mb-4 border-4 border-[hsl(var(--royal-gold-light))]" alt="{{ $vendor->name }} Logo">
                <h1 class="text-3xl font-serif font-bold text-[hsl(var(--deep-brown))]">{{ $vendor->name }}</h1>
                {{-- Placeholder for average rating or vendor specific tagline --}}
                {{-- <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">★★★★☆ (Overall Rating)</p> --}}

                <div class="mt-6 text-left space-y-3">
                    @if($vendor->contact_email)
                    <p class="text-sm flex items-center"><svg class="w-4 h-4 mr-2 text-[hsl(var(--royal-gold-dark))]" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg> <a href="mailto:{{ $vendor->contact_email }}" class="hover:text-[hsl(var(--royal-gold-dark))]">{{ $vendor->contact_email }}</a></p>
                    @endif
                    @if($vendor->phone_number)
                    <p class="text-sm flex items-center"><svg class="w-4 h-4 mr-2 text-[hsl(var(--royal-gold-dark))]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg> {{ $vendor->phone_number }}</p>
                    @endif
                    @if($vendor->city || $vendor->country)
                    <p class="text-sm flex items-center"><svg class="w-4 h-4 mr-2 text-[hsl(var(--royal-gold-dark))]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        {{ $vendor->city ? $vendor->city . ', ' : '' }}{{ $vendor->country }}
                    </p>
                    @endif
                     @if($vendor->address)
                    <p class="text-sm flex items-start"><svg class="w-4 h-4 mr-2 text-[hsl(var(--royal-gold-dark))] mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        <span>{{ $vendor->address }}</span>
                    </p>
                    @endif
                    {{-- Add website, social media links if available in Vendor model --}}
                </div>
               {{-- <div class="mt-6">
                    <button class="btn-royal w-full">@lang('Contact Vendor')</button>
                </div> --}}
            </div>
        </aside>

        <!-- Vendor About and Services Column -->
        <div class="lg:w-2/3">
            <div class="card-royal p-6 mb-8">
                <h2 class="text-2xl font-serif font-semibold text-[hsl(var(--deep-brown))] mb-3">@lang('About') {{ $vendor->name }}</h2>
                <div class="prose max-w-none text-[hsl(var(--foreground))]">
                    {!! nl2br(e($vendor->description ?? __('No detailed information provided by this vendor yet.'))) !!}
                </div>
            </div>

            <h2 class="text-2xl font-serif font-semibold text-[hsl(var(--deep-brown))] mb-6">@lang('Services Offered by') {{ $vendor->name }}</h2>
            @if($vendor->services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($vendor->services as $service)
                        @include('partials.service_card', ['service' => $service])
                    @endforeach
                </div>
                 {{-- Pagination for services if many (if $vendor->services was paginated in controller) --}}
                {{-- <div class="mt-8">
                    {{ $vendor->services()->paginate(6)->links() }}
                </div> --}}
            @else
                <div class="card-royal p-6 text-center">
                    <p class="text-lg text-[hsl(var(--muted-foreground))]">@lang('This vendor currently has no services listed.')</p>
                </div>
            @endif

            {{-- Placeholder for Vendor Reviews/Testimonials on their profile page --}}
            {{-- <div class="mt-12 card-royal p-6">
                <h3 class="text-2xl font-serif font-semibold text-[hsl(var(--deep-brown))] mb-4">@lang('What Clients Say')</h3>
                <p class="text-[hsl(var(--muted-foreground))]">@lang('No reviews available for this vendor yet.')</p>
            </div> --}}
        </div>
    </div>
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
             <strong class="font-bold">@lang('Error:')</strong>
            <span class="block sm:inline">@lang('Vendor profile could not be loaded or does not exist.')</span>
        </div>
        <div class="mt-6">
            <a href="{{ route('home') }}" class="btn-royal">@lang('Back to Homepage')</a>
        </div>
    @endif
</div>
@endsection

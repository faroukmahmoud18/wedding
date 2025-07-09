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

    <div class="row">
        <!-- Vendor Details Column -->
        <div class="col-md-4">
            <div class="card shadow-sm card-royal-vendor">
                <img src="{{ $vendor->logo_url ?? 'https://via.placeholder.com/350x250.png?text=' . urlencode($vendor->name) }}" class="card-img-top" alt="{{ $vendor->name }} Logo">
                <div class="card-body text-center">
                    <h2 class="card-title" style="color: #5D4037;">{{ $vendor->name }}</h2>
                    {{-- Placeholder for average rating --}}
                    {{-- <p class="text-muted">★★★★☆ (15 Reviews)</p> --}}
                </div>
                <ul class="list-group list-group-flush">
                    @if($vendor->phone)
                    <li class="list-group-item"><strong>@lang('Phone:')</strong> {{ $vendor->phone }}</li>
                    @endif
                    @if($vendor->email)
                    <li class="list-group-item"><strong>@lang('Email:')</strong> <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a></li>
                    @endif
                    @if($vendor->address)
                    <li class="list-group-item"><strong>@lang('Address:')</strong> {{ $vendor->address }}</li>
                    @endif
                    {{-- Add website, social media links if available in Vendor model --}}
                </ul>
                <div class="card-body text-center">
                    {{-- <button class="btn btn-royal">@lang('Contact Vendor')</button> --}}
                    {{-- Or link to a contact form/modal --}}
                </div>
            </div>
        </div>

        <!-- Vendor About and Services Column -->
        <div class="col-md-8">
            <div class="mb-4 p-3 border rounded bg-white shadow-sm">
                <h3 style="color: #795548;">@lang('About') {{ $vendor->name }}</h3>
                <p>{{ $vendor->about ?? __('No detailed information provided by this vendor yet.') }}</p>
            </div>

            <h3 class="mb-3" style="color: #795548;">@lang('Services Offered')</h3>
            @if(isset($vendor->services) && $vendor->services->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($vendor->services as $service)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $service->featured_image_url ?? 'https://via.placeholder.com/300x200.png?text=' . urlencode($service->title) }}" class="card-img-top" alt="{{ $service->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($service->short_desc, 80) }}</p>
                                <p class="card-text fw-bold">
                                     @if($service->price_from && $service->price_to)
                                        ${{ number_format($service->price_from, 2) }} - ${{ number_format($service->price_to, 2) }}
                                    @elseif($service->price_from)
                                        @lang('From') ${{ number_format($service->price_from, 2) }}
                                    @else
                                        @lang('Price on request')
                                    @endif
                                    <small class="text-muted">{{ $service->unit ? '/ ' . $service->unit : '' }}</small>
                                </p>
                                <a href="{{ route('services.show', ['slug' => $service->slug]) }}" class="btn btn-sm btn-royal">@lang('View Service')</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                 {{-- Pagination for services if many --}}
                {{-- <div class="mt-4 d-flex justify-content-center">
                    {{ $vendor->services->links() }}
                </div> --}}
            @else
                <p>@lang('This vendor currently has no services listed.')</p>
            @endif

            {{-- Placeholder for Vendor Reviews/Testimonials --}}
            {{-- <div class="mt-5">
                <h3 class="mb-3">@lang('What Clients Say')</h3>
                <p>@lang('No reviews available for this vendor yet.')</p>
            </div> --}}
        </div>
    </div>
    @else
        <div class="alert alert-warning" role="alert">
            @lang('Vendor profile could not be loaded or does not exist.')
        </div>
        <a href="{{ route('home') }}" class="btn btn-royal">@lang('Back to Homepage')</a>
    @endif
</div>
@endsection

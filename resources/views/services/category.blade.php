@extends('layouts.app')

@section('title', __('Services in') . ' ' . ($categoryName ?? __('All Categories')))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="lg:flex lg:space-x-8">
        {{-- Filters Sidebar --}}
        <aside class="lg:w-1/4 mb-8 lg:mb-0">
            <div class="card-royal">
                <div class="card-royal-header p-4 border-b border-[hsl(var(--border))]">
                    <h3 class="text-lg font-serif font-semibold text-[hsl(var(--deep-brown))]">@lang('Filters')</h3>
                </div>
                <div class="card-royal-body p-4">
                    <form method="GET" action="{{ route('services.category', ['category' => $categorySlug ?? 'all']) }}" id="filterFormSidebar">
                        <input type="hidden" name="sort_by" value="{{ $sort_by ?? 'new_first' }}">

                        {{-- Category select is only shown if viewing 'all' categories, otherwise it's fixed by the URL --}}
                        @if($categorySlug === 'all')
                        <div class="mb-4">
                            <label for="category_filter_slug" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Category')</label>
                            <select name="category_filter_slug" id="category_filter_slug" class="form-select mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50"
                                    onchange="if(this.value) { window.location.href = '{{ url('services/category') }}/' + this.value + window.location.search.replace(/category_filter_slug=[^&]*&?/, '').replace(/page=[^&]*&?/, ''); } else { this.form.submit(); }">
                                <option value="" {{ !$currentCategory ? 'selected' : '' }}>@lang('All Categories')</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ (isset($currentCategory) && $currentCategory->id == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="mb-4">
                             <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Category')</label>
                             <p class="text-lg font-semibold text-[hsl(var(--deep-brown))]">{{ $categoryName }}</p>
                             <a href="{{ route('services.category', ['category' => 'all']) }}" class="text-sm text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('View all categories')</a>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Location')</label>
                            <input type="text" name="location" id="location" class="form-input mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50" placeholder="@lang('e.g., City, State')" value="{{ $location ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label for="min_price" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Min Price') ({{ config('settings.currency_symbol', '$') }})</label>
                            <input type="number" name="min_price" id="min_price" class="form-input mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50" placeholder="0" value="{{ $min_price ?? '' }}" min="0">
                        </div>

                        <div class="mb-4">
                            <label for="max_price" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Max Price') ({{ config('settings.currency_symbol', '$') }})</label>
                            <input type="number" name="max_price" id="max_price" class="form-input mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50" placeholder="@lang('Any')" value="{{ $max_price ?? '' }}" min="0">
                        </div>

                        <div>
                            <button type="submit" class="btn-royal w-full">@lang('Apply Filters')</button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Category Service Listing --}}
        <div class="lg:w-3/4">
            {{-- Breadcrumbs --}}
            <nav class="mb-6 text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('Home')</a>
                    </li>
                    <li><span class="text-[hsl(var(--muted-foreground))]">/</span></li>
                    @if(isset($currentCategory))
                        <li class="flex items-center">
                            <a href="{{ route('services.category', ['category' => 'all']) }}" class="text-[hsl(var(--royal-gold-dark))] hover:underline">@lang('All Services')</a>
                        </li>
                        <li><span class="text-[hsl(var(--muted-foreground))]">/</span></li>
                        <li class="text-[hsl(var(--foreground))]" aria-current="page">{{ $categoryName }}</li>
                    @else
                        <li class="text-[hsl(var(--foreground))]" aria-current="page">@lang('All Services')</li>
                    @endif
                </ol>
            </nav>

            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 pb-4 border-b border-[hsl(var(--border))]">
                <div>
                    <h1 class="text-3xl font-serif text-[hsl(var(--deep-brown))]">@lang('Services in') <span class="text-[hsl(var(--royal-gold-dark))]">{{ $categoryName }}</span></h1>
                    @if($services->total() > 0)
                        <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">@lang('Showing :first - :last of :total results', ['first' => $services->firstItem(), 'last' => $services->lastItem(), 'total' => $services->total()])</p>
                    @else
                         <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">@lang('No services found.')</p>
                    @endif
                </div>
                <div class="mt-4 sm:mt-0">
                    <form method="GET" action="{{ route('services.category', ['category' => $categorySlug ?? 'all']) }}" id="sortFormCategory">
                        {{-- Persist other filters --}}
                        @if(isset($location)) <input type="hidden" name="location" value="{{ $location }}"> @endif
                        @if(isset($min_price)) <input type="hidden" name="min_price" value="{{ $min_price }}"> @endif
                        @if(isset($max_price)) <input type="hidden" name="max_price" value="{{ $max_price }}"> @endif

                        <select name="sort_by" class="form-select rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50 text-sm" onchange="document.getElementById('sortFormCategory').submit()">
                            <option value="new_first" {{ ($sort_by ?? 'new_first') == 'new_first' ? 'selected' : '' }}>@lang('Newest First')</option>
                            <option value="price_asc" {{ ($sort_by ?? '') == 'price_asc' ? 'selected' : '' }}>@lang('Price: Low to High')</option>
                            <option value="price_desc" {{ ($sort_by ?? '') == 'price_desc' ? 'selected' : '' }}>@lang('Price: High to Low')</option>
                        </select>
                    </form>
                </div>
            </div>

            @if($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        @include('partials.service_card', ['service' => $service])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $services->appends(request()->query())->links() }}
                </div>
            @else
                 <div class="card-royal p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-[hsl(var(--royal-gold-light))]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-xl font-serif font-semibold text-[hsl(var(--deep-brown))]">@lang('No Services Found')</h3>
                    <p class="mt-1 text-sm text-[hsl(var(--muted-foreground))]">
                        @lang('We couldn\'t find any services in this category matching your criteria. Try adjusting your filters or exploring other categories.')
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('services.category', ['category' => 'all']) }}" class="btn-royal">@lang('View All Services')</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Removed old style block --}}
@endpush

@push('scripts')
<script>
    // Any specific JS for this page, e.g., if enhancing filter interactions
</script>
@endpush

@extends('layouts.app')

@section('title', __('Search Results') . (isset($query) && $query ? ' for "' . e($query) . '"' : ''))

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
                    <form method="GET" action="{{ route('search') }}">
                        <input type="hidden" name="query" value="{{ $query ?? '' }}">
                        <input type="hidden" name="sort_by" value="{{ $sort_by ?? 'relevance' }}">


                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">@lang('Category')</label>
                            <select name="category_id" id="category_id" class="form-select mt-1 block w-full rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50">
                                <option value="">@lang('All Categories')</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (isset($category_id) && $category_id == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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

        {{-- Search Results --}}
        <div class="lg:w-3/4">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 pb-4 border-b border-[hsl(var(--border))]">
                <div>
                    @if(isset($query) && $query)
                        <h1 class="text-2xl md:text-3xl font-serif text-[hsl(var(--deep-brown))]">@lang('Results for:') "<span class="text-[hsl(var(--royal-gold-dark))]">{{ e($query) }}</span>"</h1>
                    @else
                        <h1 class="text-2xl md:text-3xl font-serif text-[hsl(var(--deep-brown))]">@lang('Browse All Services')</h1>
                    @endif
                    <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">{{ $services->total() }} @lang('services found.')</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <form method="GET" action="{{ route('search') }}" id="sortForm">
                        <input type="hidden" name="query" value="{{ $query ?? '' }}">
                        <input type="hidden" name="category_id" value="{{ $category_id ?? '' }}">
                        <input type="hidden" name="location" value="{{ $location ?? '' }}">
                        <input type="hidden" name="min_price" value="{{ $min_price ?? '' }}">
                        <input type="hidden" name="max_price" value="{{ $max_price ?? '' }}">
                        <select name="sort_by" class="form-select rounded-md border-[hsl(var(--input))] shadow-sm focus:border-[hsl(var(--ring))] focus:ring focus:ring-[hsl(var(--ring))] focus:ring-opacity-50 text-sm" onchange="document.getElementById('sortForm').submit()">
                            <option value="relevance" {{ (isset($sort_by) && $sort_by == 'relevance') ? 'selected' : '' }}>@lang('Sort by Relevance')</option>
                            <option value="price_asc" {{ (isset($sort_by) && $sort_by == 'price_asc') ? 'selected' : '' }}>@lang('Price: Low to High')</option>
                            <option value="price_desc" {{ (isset($sort_by) && $sort_by == 'price_desc') ? 'selected' : '' }}>@lang('Price: High to Low')</option>
                            <option value="new_first" {{ (isset($sort_by) && $sort_by == 'new_first') ? 'selected' : '' }}>@lang('Newest First')</option>
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
                    {{ $services->appends(request()->query())->links() }} {{-- Ensure pagination views are Tailwind styled --}}
                </div>
            @else
                <div class="card-royal p-8 text-center">
                    {{-- <i class="bi bi-emoji-frown fs-1 text-warning"></i> --}}
                    <svg class="mx-auto h-12 w-12 text-[hsl(var(--royal-gold-light))]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-xl font-serif font-semibold text-[hsl(var(--deep-brown))]">@lang('No Services Found')</h3>
                    <p class="mt-1 text-sm text-[hsl(var(--muted-foreground))]">
                        @lang('We couldn\'t find any services matching your criteria. Try adjusting your search query or filters.')
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="btn-royal">@lang('Back to Home')</a>
                        @if(isset($query) || isset($category_id) || isset($location) || isset($min_price) || isset($max_price))
                            <a href="{{ route('search') }}" class="btn-royal-outline ml-2">@lang('Clear Filters')</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Removed old style block. Specific styles for this page can be added here if needed, but prefer Tailwind utilities or app.css components --}}
@endpush

@push('scripts')
<script>
    // Potential JS for enhancing filter interactions, e.g., AJAX filtering
    // For now, standard form submissions are used.
</script>
@endpush

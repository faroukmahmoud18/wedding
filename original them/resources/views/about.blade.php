{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', __('About Royal Vows'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8 text-center">

            <div class="mb-4">
                {{-- RoyalOrnament from RoyalMotifs.tsx --}}
                <svg class="royal-motif" width="60" height="60" viewBox="0 0 24 24" fill="none" style="color: var(--royal-gold);">
                    <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.8"/>
                    <circle cx="12" cy="12" r="3" fill="currentColor" />
                </svg>
            </div>

            <h1 class="font-serif display-4 fw-bold mb-4" style="color: var(--royal-deep-brown);">
                {{ __('About Royal Vows') }}
            </h1>

            <div class="royal-border-element mx-auto mb-5" style="width: 150px;"></div>

            <div class="lead space-y-4" style="color: var(--muted-text); line-height: 1.8;">
                <p>
                    {{ __('Welcome to Royal Vows, your premier destination for discovering and booking exquisite wedding services. Our mission is to connect discerning couples with the finest vendors, ensuring every wedding is a masterpiece of elegance and unforgettable moments.') }}
                </p>
                <p>
                    {{ __('Founded on the principle that your special day deserves nothing but the best, Royal Vows meticulously curates a selection of top-tier photographers, breathtaking venues, renowned bridal designers, and talented makeup artists. We believe in quality, luxury, and personalized experiences.') }}
                </p>
                <p>
                    {{ __('Our platform is designed to simplify your wedding planning journey, providing you with a seamless and inspiring way to find and secure the perfect elements for your celebration. From grand royal affairs to intimate chic gatherings, Royal Vows is dedicated to helping you craft the wedding of your dreams.') }}
                </p>
                <p>
                    {{ __('We are passionate about bringing fairytale weddings to life, supported by a network of trusted professionals who share our commitment to excellence. Let us be part of your story, helping you weave together the threads of a truly majestic day.') }}
                </p>
            </div>

            <div class="mt-5 mb-4">
                {{-- RoyalOrnament from RoyalMotifs.tsx --}}
                <svg class="royal-motif" width="40" height="40" viewBox="0 0 24 24" fill="none" style="color: var(--royal-gold); opacity:0.7;">
                     <path d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" opacity="0.8"/>
                <circle cx="12" cy="12" r="3" fill="currentColor" />
                </svg>
            </div>

            <a href="{{ url('/contact') }}" class="btn btn-royal btn-lg mt-4">
                {{ __('Contact Us For More Information') }}
            </a>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .space-y-4 > p:not(:last-child) {
        margin-bottom: 1.5rem; /* Bootstrap's default is 1rem, increasing spacing a bit */
    }
</style>
@endpush

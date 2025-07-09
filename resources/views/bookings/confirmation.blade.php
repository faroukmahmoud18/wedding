@extends('layouts.app')

@section('title', __('Booking Confirmation'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm card-royal-vendor">
                <div class="card-header text-center">
                    <h2 style="color: #5D4037;">@lang('Booking Request Received!')</h2>
                </div>
                <div class="card-body text-center">
                    @if(session('booking_success_message'))
                        <p class="lead">{{ session('booking_success_message') }}</p>
                    @else
                        <p class="lead">@lang('Thank you for your booking request. We have received your details.')</p>
                    @endif

                    @if(isset($booking)) {{-- Assuming controller passes the booking object --}}
                        <p>@lang('Your booking ID is:') <strong>#{{ $booking->id }}</strong></p>
                        <p>@lang('Service Booked:') {{ $booking->service->title ?? __('N/A') }}</p>
                        <p>@lang('Event Date:') {{ $booking->event_date ? $booking->event_date->format('F d, Y') : __('N/A') }}</p>
                        <p>@lang('The vendor will contact you shortly to confirm the details and availability.')</p>
                    @else
                         <p>@lang('The vendor will contact you shortly to confirm the details and availability. Please check your email for further communication.')</p>
                    @endif

                    <hr>
                    <p>@lang('What\'s next?')</p>
                    <ul class="list-unstyled">
                        <li>@lang('You will receive an email confirmation soon (if applicable).')</li>
                        <li>@lang('The service vendor will review your request and get in touch with you regarding availability and any further steps.')</li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-royal">@lang('Back to Homepage')</a>
                        {{-- Optionally, link to user's booking history page --}}
                        {{-- <a href="#" class="btn btn-outline-secondary">@lang('View My Bookings')</a> --}}
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    @lang('Thank you for choosing') {{ config('app.name', 'RoyalAffairs') }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

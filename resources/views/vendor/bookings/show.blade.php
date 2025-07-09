@extends('layouts.vendor')

@section('title', __('Booking Details #') . $booking->id)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Booking Details #')<span class="text-primary">{{ $booking->id }}</span></h1>
        <a href="{{ route('vendor.bookings.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to Bookings List')
        </a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Booking Information')</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">@lang('Booking ID:')</dt>
                        <dd class="col-sm-8">#{{ $booking->id }}</dd>

                        <dt class="col-sm-4">@lang('Service:')</dt>
                        <dd class="col-sm-8"><a href="{{ route('vendor.services.show', $booking->service) }}">{{ $booking->service->title }}</a></dd>

                        <dt class="col-sm-4">@lang('Customer Name:')</dt>
                        <dd class="col-sm-8">{{ $booking->user->name ?? $booking->customer_name ?? __('Guest') }}</dd>

                        <dt class="col-sm-4">@lang('Customer Email:')</dt>
                        <dd class="col-sm-8">{{ $booking->user->email ?? $booking->customer_email ?? __('N/A') }}</dd>

                        <dt class="col-sm-4">@lang('Customer Phone:')</dt>
                        <dd class="col-sm-8">{{ $booking->customer_phone ?? __('N/A') }}</dd>

                        <dt class="col-sm-4">@lang('Booking Date:')</dt>
                        <dd class="col-sm-8">{{ $booking->booking_date ? $booking->booking_date->format('l, F j, Y') : __('Date not set') }}</dd>

                        {{-- <dt class="col-sm-4">@lang('Time Slot:')</dt>
                        <dd class="col-sm-8">{{ $booking->time_slot ?? __('N/A') }}</dd> --}}

                        <dt class="col-sm-4">@lang('Number of Guests/Participants:')</dt>
                        <dd class="col-sm-8">{{ $booking->guests ?? __('N/A') }}</dd>

                        <dt class="col-sm-4">@lang('Total Amount:')</dt>
                        <dd class="col-sm-8">{{ config('settings.currency_symbol', '$') }}{{ number_format($booking->total_amount, 2) }}</dd>

                        <dt class="col-sm-4">@lang('Payment Status:')</dt>
                        <dd class="col-sm-8">
                            @if($booking->payment_status == 'paid') <span class="badge bg-success">{{ Str::title($booking->payment_status) }}</span>
                            @elseif($booking->payment_status == 'pending') <span class="badge bg-warning text-dark">{{ Str::title($booking->payment_status) }}</span>
                            @elseif($booking->payment_status == 'failed') <span class="badge bg-danger">{{ Str::title($booking->payment_status) }}</span>
                            @else <span class="badge bg-secondary">{{ Str::title($booking->payment_status ?? 'N/A') }}</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">@lang('Booking Status:')</dt>
                        <dd class="col-sm-8">
                            @if($booking->status == 'confirmed') <span class="badge bg-success fs-6">@lang('Confirmed')</span>
                            @elseif($booking->status == 'pending') <span class="badge bg-warning text-dark fs-6">@lang('Pending Confirmation')</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="badge bg-danger fs-6">@lang('Cancelled')</span>
                                @if($booking->cancelled_by) <small class="d-block text-muted">(@lang('By:') {{ Str::title($booking->cancelled_by) }})</small>@endif
                            @elseif($booking->status == 'completed') <span class="badge bg-primary fs-6">@lang('Completed')</span>
                            @else <span class="badge bg-secondary fs-6">{{ Str::title($booking->status) }}</span>
                            @endif
                        </dd>
                        @if($booking->status == 'cancelled' && $booking->cancellation_reason)
                            <dt class="col-sm-4">@lang('Cancellation Reason:')</dt>
                            <dd class="col-sm-8 fst-italic">{{ $booking->cancellation_reason }}</dd>
                        @endif

                        <dt class="col-sm-4">@lang('Booked On:')</dt>
                        <dd class="col-sm-8">{{ $booking->created_at->format('M d, Y H:i A') }}</dd>
                    </dl>

                    @if($booking->message)
                        <hr>
                        <strong>@lang('Message from Customer:')</strong>
                        <p class="text-muted fst-italic">"{{ $booking->message }}"</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Booking Actions')</h6>
                </div>
                <div class="card-body">
                    @if($booking->status == 'pending')
                        <form action="{{ route('vendor.bookings.updateStatus', $booking) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('@lang('Are you sure you want to confirm this booking?')')">
                                <i class="fas fa-check-circle"></i> @lang('Confirm Booking')
                            </button>
                        </form>
                    @endif

                    @if(in_array($booking->status, ['pending', 'confirmed']))
                        <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#cancelBookingModal-{{ $booking->id }}">
                            <i class="fas fa-times-circle"></i> @lang('Cancel Booking')
                        </button>
                    @endif

                    @if($booking->status == 'confirmed' && (!$booking->booking_date || $booking->booking_date->isPast()) ) {{-- Allow marking completed if confirmed and date is past or not set --}}
                         <form action="{{ route('vendor.bookings.updateStatus', $booking) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirm('@lang('Are you sure you want to mark this booking as completed?')')">
                                <i class="fas fa-calendar-check"></i> @lang('Mark as Completed')
                            </button>
                        </form>
                    @endif

                    @if($booking->status == 'cancelled' || $booking->status == 'completed')
                        <p class="text-muted text-center">@lang('No further actions available for this booking status.')</p>
                    @endif
                     <a href="mailto:{{ $booking->user->email ?? $booking->customer_email }}" class="btn btn-outline-secondary w-100 mt-2"><i class="fas fa-envelope"></i> @lang('Contact Customer')</a>
                </div>
            </div>

            {{-- Placeholder for Transactions if payment integration exists --}}
            @if($booking->transactions && $booking->transactions->count() > 0)
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Payment Transactions')</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($booking->transactions as $transaction)
                            <li class="list-group-item">
                                <strong>@lang('ID:')</strong> {{ $transaction->transaction_id }} <br>
                                <strong>@lang('Amount:')</strong> {{ config('settings.currency_symbol', '$') }}{{ number_format($transaction->amount, 2) }} <br>
                                <strong>@lang('Status:')</strong> <span class="badge bg-{{ $transaction->status == 'successful' ? 'success' : 'warning text-dark' }}">{{ Str::title($transaction->status) }}</span> <br>
                                <strong>@lang('Date:')</strong> {{ $transaction->created_at->format('M d, Y H:i A') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Cancel Modal (from index, can be reused or specific modal here) --}}
@if(in_array($booking->status, ['pending', 'confirmed']))
<div class="modal fade" id="cancelBookingModal-{{ $booking->id }}" tabindex="-1" aria-labelledby="cancelBookingModalLabel-{{ $booking->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('vendor.bookings.updateStatus', $booking) }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="cancelled">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cancelBookingModalLabel-{{ $booking->id }}">@lang('Cancel Booking #'):{{$booking->id}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>@lang('Are you sure you want to cancel this booking for') "{{ $booking->service->title }}" @lang('by') {{ $booking->user->name ?? __('Guest') }}?</p>
            <div class="mb-3">
                <label for="cancellation_reason_vendor-{{ $booking->id }}" class="form-label">@lang('Reason for Cancellation (Optional, will be shared with customer)')</label>
                <textarea class="form-control" id="cancellation_reason_vendor-{{ $booking->id }}" name="cancellation_reason_vendor" rows="2"></textarea>
            </div>
            <div class="alert alert-warning small">@lang('The customer will be notified of this cancellation.')</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Keep Booking')</button>
            <button type="submit" class="btn btn-danger">@lang('Yes, Cancel Booking')</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endif

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.badge.fs-6 { font-size: 0.9rem; }
</style>
@endpush

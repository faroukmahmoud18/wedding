@extends('layouts.vendor')

@section('title', __('My Bookings'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('My Bookings')</h1>
        {{-- Maybe a button to export bookings or filter by date range --}}
    </div>

    <!-- Filter/Search Form -->
    <div class="card shadow mb-4 card-royal-vendor">
        <div class="card-body">
            <form method="GET" action="{{ route('vendor.bookings.index') }}" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="service_id" class="form-label visually-hidden">@lang('Service')</label>
                    <select name="service_id" id="service_id" class="form-select form-select-sm">
                        <option value="">@lang('All My Services')</option>
                        @foreach($services as $service) {{-- $services should be passed from VendorBookingController --}}
                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ Str::limit($service->title, 50) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                     <label for="status" class="form-label visually-hidden">@lang('Status')</label>
                    <select name="status" id="status" class="form-select form-select-sm">
                        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>@lang('All Statuses')</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>@lang('Pending Confirmation')</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>@lang('Confirmed')</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>@lang('Cancelled')</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                        {{-- Add other relevant statuses --}}
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label visually-hidden">@lang('From')</label>
                    <input type="date" name="date_from" id="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" title="@lang('Booking Date From')">
                </div>
                <div class="col-md-2">
                     <label for="date_to" class="form-label visually-hidden">@lang('To')</label>
                    <input type="date" name="date_to" id="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" title="@lang('Booking Date To')">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-sm btn-info w-100">@lang('Filter')</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4 card-royal-vendor">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">@lang('Booking List')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="vendorBookingsDataTable" width="100%" cellspacing="0">
                    <thead class="table-dark" style="background-color: #5D4037; color: #E1C699;">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Service')</th>
                            <th>@lang('Customer')</th>
                            <th>@lang('Booking Date')</th>
                            {{-- <th>@lang('Time Slot')</th> --}}
                            <th>@lang('Total Amount')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Booked On')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>
                                <a href="{{ route('vendor.services.show', $booking->service) }}" title="{{ $booking->service->title }}">{{ Str::limit($booking->service->title, 30) }}</a>
                            </td>
                            <td>{{ $booking->user->name ?? __('Guest') }} <br><small class="text-muted">{{ $booking->user->email ?? $booking->customer_email }}</small></td>
                            <td>{{ $booking->booking_date ? $booking->booking_date->format('D, M d, Y') : __('N/A') }}</td>
                            {{-- <td>{{ $booking->time_slot ?? __('N/A') }}</td> --}}
                            <td>{{ config('settings.currency_symbol', '$') }}{{ number_format($booking->total_amount, 2) }}</td>
                            <td>
                                @if($booking->status == 'confirmed') <span class="badge bg-success">@lang('Confirmed')</span>
                                @elseif($booking->status == 'pending') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                @elseif($booking->status == 'cancelled') <span class="badge bg-danger">@lang('Cancelled')</span>
                                @elseif($booking->status == 'completed') <span class="badge bg-primary">@lang('Completed')</span>
                                @else <span class="badge bg-secondary">{{ Str::title($booking->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('vendor.bookings.show', $booking) }}" class="btn btn-sm btn-info" title="@lang('View Details')"><i class="fas fa-eye"></i></a>
                                {{-- Add other actions like "Mark as Completed" or "Cancel Booking" if allowed for vendor --}}
                                @if($booking->status == 'pending')
                                    <button type="button" class="btn btn-sm btn-success" title="@lang('Confirm Booking')" onclick="document.getElementById('confirmBookingForm-{{$booking->id}}').submit();"><i class="fas fa-check"></i></button>
                                    <form id="confirmBookingForm-{{$booking->id}}" action="{{ route('vendor.bookings.updateStatus', $booking) }}" method="POST" class="d-none">
                                        @csrf @method('PATCH') <input type="hidden" name="status" value="confirmed">
                                    </form>
                                @endif
                                 @if(in_array($booking->status, ['pending', 'confirmed']))
                                    <button type="button" class="btn btn-sm btn-danger" title="@lang('Cancel Booking')" data-bs-toggle="modal" data-bs-target="#cancelBookingModal-{{ $booking->id }}"><i class="fas fa-times"></i></button>
                                @endif
                            </td>
                        </tr>
                        {{-- Cancel Modal --}}
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
                                        <label for="cancellation_reason_vendor-{{ $booking->id }}" class="form-label">@lang('Reason for Cancellation (Optional)')</label>
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
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">@lang('No bookings found matching your criteria.')</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.table-dark { background-color: #5D4037 !important; color: #E1C699; }
</style>
@endpush

@push('scripts')
{{-- Add any JS for this page, e.g. date pickers for filter --}}
@endpush

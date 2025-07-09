@extends('layouts.vendor')

@section('title', __('Service Details:') . ' ' . Str::limit($service->title, 30))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Service Details')</h1>
        <div>
            @if(in_array($service->status, ['pending_approval', 'rejected', 'on_hold']) || ($service->status == 'approved' && !$service->is_live) )
                <a href="{{ route('vendor.services.edit', $service) }}" class="btn btn-sm btn-primary btn-royal shadow-sm me-2">
                    <i class="fas fa-edit fa-sm text-white-50"></i> @lang('Edit Service')
                </a>
            @else
                 <button class="btn btn-sm btn-primary btn-royal shadow-sm me-2" disabled title="@lang('Contact admin for changes to live/approved service')">
                    <i class="fas fa-edit fa-sm text-white-50"></i> @lang('Edit Service')
                </button>
            @endif
            <a href="{{ route('vendor.services.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to My Services')
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold">{{ $service->title }}</h5>
                </div>
                <div class="card-body">
                    @if($service->featured_image_url)
                        <div class="mb-3 text-center">
                            <img src="{{ $service->featured_image_url }}" alt="{{ $service->title }} Featured Image" class="img-fluid rounded" style="max-height: 300px; border: 1px solid #ddd;">
                        </div>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-3">@lang('Category:')</dt>
                        <dd class="col-sm-9">{{ $service->category->name ?? __('N/A') }}</dd>

                        <dt class="col-sm-3">@lang('Price:')</dt>
                        <dd class="col-sm-9">{{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }} {{ $service->price_unit ? '/ '.$service->price_unit : '' }}</dd>

                        <dt class="col-sm-3">@lang('Admin Status:')</dt>
                        <dd class="col-sm-9">
                            @if($service->status == 'approved') <span class="badge bg-success fs-6">@lang('Approved')</span>
                            @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark fs-6">@lang('Pending Review')</span>
                            @elseif($service->status == 'rejected')
                                <span class="badge bg-danger fs-6">@lang('Rejected')</span>
                                @if($service->rejection_reason) <small class="d-block text-muted mt-1">@lang('Admin Reason:') {{ $service->rejection_reason }}</small> @endif
                            @elseif($service->status == 'on_hold') <span class="badge bg-secondary fs-6">@lang('On Hold by Admin')</span>
                            @else <span class="badge bg-light text-dark fs-6">{{ Str::title(str_replace('_', ' ', $service->status)) }}</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">@lang('Live Status:')</dt>
                        <dd class="col-sm-9">{!! $service->is_live ? '<span class="badge bg-success fs-6">'.__('Live').'</span>' : '<span class="badge bg-secondary fs-6">'.__('Offline').'</span>' !!}</dd>

                        <dt class="col-sm-3">@lang('Location:')</dt>
                        <dd class="col-sm-9">{{ $service->location_text ?? __('N/A') }}</dd>

                        <dt class="col-sm-3">@lang('Tags:')</dt>
                        <dd class="col-sm-9">
                            @if($service->tags)
                                @php $tags = is_array($service->tags) ? $service->tags : json_decode($service->tags, true); @endphp
                                @if(is_array($tags) && count($tags) > 0)
                                    @foreach($tags as $tag)
                                        <span class="badge bg-info me-1">{{ $tag }}</span>
                                    @endforeach
                                @else
                                     {{ is_string($service->tags) ? $service->tags : __('N/A')}}
                                @endif
                            @else
                                @lang('N/A')
                            @endif
                        </dd>
                    </dl>
                    <hr>
                    <h6>@lang('Short Description:')</h6>
                    <p class="text-muted">{{ $service->short_desc ?? __('No short description provided.') }}</p>
                    <hr>
                    <h6>@lang('Full Description:')</h6>
                    <div>{!! nl2br(e($service->description)) !!}</div>
                </div>
            </div>
             @if($service->images && $service->images->count() > 0)
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Additional Images')</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($service->images as $image)
                        <div class="col-md-3 col-sm-4 col-6">
                             <a href="{{ $image->image_url }}" data-bs-toggle="tooltip" title="{{ $image->caption ?? __('Service Image') }}" target="_blank">
                                <img src="{{ $image->image_url }}" alt="{{ $image->caption ?? __('Service Image') }}" class="img-fluid rounded" style="height: 100px; width:100%; object-fit: cover; border: 1px solid #ddd;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-5">
            {{-- Booking Summary for this service --}}
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">@lang('Recent Bookings for this Service') ({{ $service->bookings->count() }})</h6>
                    @if($service->bookings->count() > 0)
                        <a href="{{ route('vendor.bookings.index', ['service_id' => $service->id]) }}" class="btn btn-sm btn-outline-secondary">@lang('View All')</a>
                    @endif
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @if($service->bookings->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($service->bookings->sortByDesc('created_at')->take(5) as $booking)
                            <li class="list-group-item">
                                <a href="{{ route('vendor.bookings.show', $booking) }}"><strong>#{{$booking->id}}</strong> - {{ $booking->user->name ?? __('Guest') }}</a>
                                <small class="d-block text-muted">@lang('Date:') {{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}
                                    <span class="float-end badge {{ $booking->status == 'confirmed' ? 'bg-success' : ($booking->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">{{ Str::title($booking->status) }}</span>
                                </small>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center text-muted py-3">@lang('No bookings found for this service yet.')</p>
                    @endif
                </div>
            </div>

            {{-- Reviews for this service --}}
            <div class="card shadow mb-4 card-royal-vendor">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Customer Reviews') ({{ $service->reviews->where('is_approved', true)->count() }}) - @lang('Avg:') {{ number_format($service->average_rating, 1) }} <i class="fas fa-star text-warning"></i></h6>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @if($service->reviews->where('is_approved', true)->count() > 0)
                        @foreach($service->reviews->where('is_approved', true) as $review)
                            <div class="mb-2 pb-2 border-bottom">
                                <strong>{{ $review->user->name ?? __('Anonymous') }}</strong>
                                <small class="text-muted float-end">{{ $review->created_at->format('M d, Y') }}</small>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-0 mt-1 fst-italic">"{{ $review->comment }}"</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted py-3">@lang('No approved reviews for this service yet.')</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.badge.fs-6 { font-size: 0.9rem; }
</style>
@endpush

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush

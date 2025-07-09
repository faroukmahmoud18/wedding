@extends('layouts.admin')

@section('title', __('Service Details:') . ' ' . Str::limit($service->title, 30))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Service Details')</h1>
        <div>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-primary shadow-sm me-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> @lang('Edit Service')
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('Back to List')
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Service Info Column -->
        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold">{{ $service->title }}</h5>
                </div>
                <div class="card-body">
                    @if($service->featured_image_url)
                        <div class="mb-3 text-center">
                            <img src="{{ $service->featured_image_url }}" alt="{{ $service->title }} Featured Image" class="img-fluid rounded" style="max-height: 300px;">
                        </div>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-3">@lang('Vendor:')</dt>
                        <dd class="col-sm-9">
                            @if($service->vendor)
                                <a href="{{ route('admin.vendors.show', $service->vendor) }}">{{ $service->vendor->name }}</a>
                            @else
                                @lang('N/A')
                            @endif
                        </dd>

                        <dt class="col-sm-3">@lang('Category:')</dt>
                        <dd class="col-sm-9">
                            @if($service->category)
                                <a href="{{ route('admin.categories.edit', $service->category) }}">{{ $service->category->name }}</a>
                            @else
                                @lang('N/A')
                            @endif
                        </dd>

                        <dt class="col-sm-3">@lang('Price:')</dt>
                        <dd class="col-sm-9">{{ config('settings.currency_symbol', '$') }}{{ number_format($service->price, 2) }} {{ $service->price_unit ? '/ '.$service->price_unit : '' }}</dd>

                        <dt class="col-sm-3">@lang('Status:')</dt>
                        <dd class="col-sm-9">
                            @if($service->status == 'approved') <span class="badge bg-success fs-6">@lang('Approved')</span>
                            @elseif($service->status == 'pending_approval') <span class="badge bg-warning text-dark fs-6">@lang('Pending Approval')</span>
                            @elseif($service->status == 'rejected')
                                <span class="badge bg-danger fs-6">@lang('Rejected')</span>
                                @if($service->rejection_reason) <small class="d-block text-muted">@lang('Reason:') {{ $service->rejection_reason }}</small> @endif
                            @elseif($service->status == 'on_hold') <span class="badge bg-secondary fs-6">@lang('On Hold')</span>
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
                    <p class="text-muted">{{ $service->short_desc ?? __('No short description.') }}</p>
                    <hr>
                    <h6>@lang('Full Description:')</h6>
                    <div>{!! nl2br(e($service->description)) !!}</div>
                </div>
            </div>

            @if($service->images && $service->images->count() > 0)
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Additional Images')</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($service->images as $image)
                        <div class="col-md-3 col-sm-4 col-6">
                             <a href="{{ $image->image_url }}" data-bs-toggle="tooltip" title="{{ $image->caption ?? __('Service Image') }}" target="_blank">
                                <img src="{{ $image->image_url }}" alt="{{ $image->caption ?? __('Service Image') }}" class="img-fluid rounded" style="height: 100px; width:100%; object-fit: cover;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Actions & Related Info Column -->
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Quick Actions')</h6>
                </div>
                <div class="card-body">
                    @if($service->status == 'pending_approval')
                        <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block w-100 mb-2" onclick="return confirm('@lang('Are you sure you want to approve this service?')');">
                                <i class="fas fa-check"></i> @lang('Approve Service')
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger btn-block w-100" data-bs-toggle="modal" data-bs-target="#rejectServiceModal-{{ $service->id }}">
                            <i class="fas fa-times"></i> @lang('Reject Service')
                        </button>
                    @elseif($service->status == 'approved')
                        <form action="{{ route('admin.services.toggleLive', $service) }}" method="POST" class="d-inline mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $service->is_live ? 'warning' : 'success' }} btn-block w-100">
                                <i class="fas {{ $service->is_live ? 'fa-eye-slash' : 'fa-eye' }}"></i> {{ $service->is_live ? __('Set Offline') : __('Set Live') }}
                            </button>
                        </form>
                    @elseif(in_array($service->status, ['rejected', 'on_hold']))
                         <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block w-100 mb-2" onclick="return confirm('@lang('Are you sure you want to re-approve this service?')');">
                                <i class="fas fa-check-circle"></i> @lang('Re-Approve Service')
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Bookings for this service --}}
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Recent Bookings') ({{ $service->bookings->count() }})</h6>
                </div>
                <div class="card-body">
                    @if($service->bookings->count() > 0)
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Customer')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($service->bookings->sortByDesc('created_at')->take(10) as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name ?? __('Guest') }}</td>
                                    <td>{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($booking->status == 'confirmed') <span class="badge bg-success">@lang('Confirmed')</span>
                                        @elseif($booking->status == 'pending') <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                        @elseif($booking->status == 'cancelled') <span class="badge bg-danger">@lang('Cancelled')</span>
                                        @else <span class="badge bg-secondary">{{ Str::title($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($service->bookings->count() > 10)
                        {{-- <a href="#" class="btn btn-sm btn-outline-secondary mt-2">@lang('View All Bookings for this Service')</a> --}}
                    @endif
                    @else
                    <p>@lang('No bookings found for this service yet.')</p>
                    @endif
                </div>
            </div>

            {{-- Reviews for this service --}}
            <div class="card shadow mb-4 card-royal-admin">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@lang('Reviews') ({{ $service->reviews->count() }}) - @lang('Avg Rating:') {{ number_format($service->average_rating, 1) }} <i class="fas fa-star text-warning"></i></h6>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @if($service->reviews->count() > 0)
                        @foreach($service->reviews as $review)
                            <div class="mb-2 pb-2 border-bottom">
                                <strong>{{ $review->user->name ?? __('Anonymous') }}</strong>
                                <small class="text-muted float-end">{{ $review->created_at->format('M d, Y') }}</small>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="ms-2 badge {{ $review->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">{{ $review->is_approved ? __('Approved') : __('Pending') }}</span>
                                </div>
                                <p class="mb-0 mt-1 fst-italic">"{{ $review->comment }}"</p>
                                {{-- Admin actions for reviews: approve, delete --}}
                            </div>
                        @endforeach
                    @else
                        <p>@lang('No reviews yet for this service.')</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal (if needed from show page, but typically on index or edit) --}}
@if($service->status == 'pending_approval')
<div class="modal fade" id="rejectServiceModal-{{ $service->id }}" tabindex="-1" aria-labelledby="rejectServiceModalLabel-{{ $service->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.services.reject', $service) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rejectServiceModalLabel-{{ $service->id }}">@lang('Reject Service:') {{ Str::limit($service->title, 30) }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="rejection_reason-{{ $service->id }}" class="form-label">@lang('Reason for Rejection')</label>
                <textarea class="form-control" id="rejection_reason-{{ $service->id }}" name="rejection_reason" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
            <button type="submit" class="btn btn-danger">@lang('Reject Service')</button>
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

@push('scripts')
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush

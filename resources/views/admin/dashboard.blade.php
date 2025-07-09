@extends('layouts.admin')

@section('title', __('Admin Dashboard'))

@section('content')
<div class="container-fluid">
    <h1 class="h2 mb-4" style="color: #4A3B31;">@lang('Admin Dashboard')</h1>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-royal-admin h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('Total Vendors')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['total_vendors'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i> {{-- Placeholder for FontAwesome icon --}}
                             <span style="font-size: 2rem;">&#127978;</span> {{-- Placeholder emoji --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-royal-admin h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('Total Services')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['total_services'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                             <span style="font-size: 2rem;">&#128221;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-royal-admin h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('Pending Approvals') (@lang('Vendors'))</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['pending_vendor_approvals'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <span style="font-size: 2rem;">&#9203;</span>
                        </div>
                    </div>
                     <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-royal-admin h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">@lang('Total Bookings')</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stats['total_bookings'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                             <span style="font-size: 2rem;">&#128197;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions or Recent Activity -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card card-royal-admin">
                <div class="card-header">
                    @lang('Quick Actions')
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary btn-sm mb-2">@lang('Add New Vendor')</a>
                    {{-- <a href="#" class="btn btn-info btn-sm mb-2">@lang('Review New Services')</a> --}}
                    <p>@lang('Links to common administrative tasks.')</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card card-royal-admin">
                <div class="card-header">
                    @lang('Recent Activity')
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">@lang('Vendor "Elegant Events" registered.')</li>
                    <li class="list-group-item">@lang('Service "Royal Photography Package" added.')</li>
                    <li class="list-group-item">@lang('Booking #123 confirmed.')</li>
                </ul>
                 <div class="card-footer text-center">
                    <a href="#">@lang('View all activity') &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Placeholder for charts or more detailed reports --}}
    {{-- <div class="card card-royal-admin mt-4">
        <div class="card-header">@lang('Site Analytics Overview')</div>
        <div class="card-body">
            <p class="text-center">@lang('[Chart placeholder - e.g., New Users, Bookings Over Time]')</p>
            <canvas id="myAnalyticsChart"></canvas>
        </div>
    </div> --}}

</div>
@endsection

@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Placeholder for Chart.js
    // const ctx = document.getElementById('myAnalyticsChart');
    // if(ctx) {
    //     new Chart(ctx, {
    //         type: 'line',
    //         data: {
    //             labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    //             datasets: [{
    //                 label: 'New Bookings',
    //                 data: [12, 19, 3, 5, 2, 3],
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: { scales: { y: { beginAtZero: true } } }
    //     });
    // }
</script> --}}
@endpush

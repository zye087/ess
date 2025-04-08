@extends('layouts.admin.app')

@section('title', 'Enhance Security School | Admin - Dashboard')

@section('content')
<main>
    <!-- Page Header -->
    <header class="page-header page-header-dark bg-gradient-success-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            Dashboard
                        </h1>
                        <div class="page-header-subtitle">Manage and monitor school security and pickups.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-xl px-4 mt-n10">
        <div class="row">
            <!-- Total Parents -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Total Registered Parents</h5>
                        <h2 class="fw-bold text-primary">{{ $totalParents }}</h2>
                        <p class="text-muted">Registered in the system</p>
                    </div>
                </div>
            </div>

            <!-- Total Children -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Total Children</h5>
                        <h2 class="fw-bold text-success">{{ $totalChildren }}</h2>
                        <p class="text-muted">Enrolled under parents</p>
                    </div>
                </div>
            </div>

            <!-- Pickups Today -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Total Pickups Today</h5>
                        <h2 class="fw-bold text-warning">{{ $totalPickupsToday }}</h2>
                        <p class="text-muted">Completed pickups for today</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pickup Trend Chart -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold">Pickup Trend (Today)</h5>
                <canvas id="pickupChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Pickup Logs -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold">Recent Pickup Logs</h5>
                @if($pickupLogs->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                               <th style="font-weight: bold;">Child Name</th>
                               <th style="font-weight: bold;">Picked Up By</th>
                               <th style="font-weight: bold;">Pickup Time</th>
                               <th style="font-weight: bold;">Date</th>
                            </tr>
                        </thead>
                         <tbody>
                            @foreach($pickupLogs as $index => $log)
                            <tr>
                                <td>{{ $log->child->name }}</td>
                                <td>
                                    @if($log->parent)
                                        {{ $log->parent->name }} <strong class="text-success">(Parent)</strong>
                                    @elseif($log->guardian)
                                        {{ $log->guardian->name }} <strong class="text-warning">(Guardian)</strong>
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($log->picked_up_at)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No pickup logs available today.</p>
                @endif
            </div>
        </div>
    </div>
</main>

@endsection

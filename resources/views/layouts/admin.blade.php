<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - So Hu Beach Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">
    @if (!Request::is('admin/login'))
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white"
             style="width: 250px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 1040;">
            <a href="{{ url('/admin/dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 40px; height: 40px;" class="me-2 rounded-circle" />
                <span class="fs-5 fw-bold">Admin Panel</span>
            </a>
            <hr class="border-secondary" />
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link text-white">
                        <i class="bi bi-house me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/bookings') }}" class="nav-link text-white">
                        <i class="bi bi-calendar-check me-2"></i> Bookings
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/users') }}" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>

                <!-- Reports & Analytics Section -->
                <li class="mt-3">
                    <span class="text-uppercase text-secondary fw-bold small ms-2">Reports & Analytics</span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="revenueDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bar-chart-line me-2"></i> Revenue Summary
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="revenueDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ url('/admin/reports/revenue/daily') }}">
                                Daily Revenue
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('/admin/reports/revenue/monthly') }}">
                                Monthly Revenue
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('/admin/reports/top-rooms') }}" class="nav-link text-white">
                        <i class="bi bi-star me-2"></i> Top Rooms Booked
                    </a>
                </li>
            </ul>
            <hr class="border-secondary" />
            <div>
                <a href="{{ url('/admin/logout') }}" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1" style="margin-left: 250px;">
            <!-- Top Navbar and main content -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
                <div class="container-fluid">
                    <!-- Notification Bell with Badge -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-4"></i>
                                @php
                                    $newBookings = \App\Models\Reservation::where('status', 'active')->where('is_seen', false)->count();
                                    $newPayments = \App\Models\Reservation::where('status', 'active')->whereNotNull('payment_proof')->where('payment_alert', false)->count();
                                    $totalAlerts = $newBookings + $newPayments;
                                @endphp
                                @if($totalAlerts > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalAlerts }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 300px;">
                                <li class="dropdown-header fw-bold">Notifications</li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/admin/bookings') }}">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        New Bookings
                                        @if($newBookings > 0)
                                            <span class="badge bg-primary ms-2">{{ $newBookings }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/admin/payments') }}">
                                        <i class="bi bi-image me-2"></i>
                                        New Payment Proofs
                                        @if($newPayments > 0)
                                            <span class="badge bg-success ms-2">{{ $newPayments }}</span>
                                        @endif
                                    </a>
                                </li>
                                @if($totalAlerts == 0)
                                    <li><span class="dropdown-item text-muted">No new notifications</span></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>
    @else
        @yield('content')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

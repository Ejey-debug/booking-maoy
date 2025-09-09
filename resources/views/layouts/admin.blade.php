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
        <nav class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white" style="width: 250px; min-height: 100vh;">
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
            </ul>
            <hr class="border-secondary" />
            <div>
                <a href="{{ url('/admin/logout') }}" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
                <div class="container-fluid">
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

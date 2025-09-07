<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>So hu Beach Club</title>

  <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />

    <style>
        /* Start fully transparent */
        .navbar {
            background-color: transparent !important;
            transition: background-color 0.3s ease, backdrop-filter 0.3s ease;
        }

        /* Add background after scroll */
        .navbar.scrolled {
            background-color: rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body class="bg-light">

    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="{{ asset('images/logo.png') }}" width="50" height="50" class="me-2" />
                <span style="font-family: 'Great Vibes', cursive; font-size: 30px; color: #fff;">
                    So Hu Beach Club
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/accommodations') }}">Accommodations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn ms-3" style="background-color: #6a491b; color: white; font-size: 16px; padding: 6px 16px;" href="{{ url('/reserve') }}">
                            Book Now
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="p-0 m-0 w-100">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scroll Effect -->
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>

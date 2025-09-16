@extends('layouts.app')

@section('content')

<!-- 🌊 Full Width Hero Section -->
<section style="position: relative; width: 100%; height: 50vh; overflow: hidden;">

    <!-- 🖼 Background Image -->
    <img src="{{ asset('images/homebg.jpg') }}"
         alt="Hero Image"
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;" />

    <!-- 🌓 Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: -1;"></div>

    <!-- 📝 Text Content -->
    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white h-100 px-3">
        <p class="text-uppercase small fw-semibold">Best Hotel With Cozy Rooms</p>
        <h1 class="display-3 fw-bold mb-3">Welcome to So Hu<br />Beach Club.</h1>
        <p class="lead mb-4">
            Discover comfort, elegance, and unforgettable memories along the serene shores of So Hu Beach.

</section>

<!-- About Section -->
<section class="mb-5 py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">About So hu Beach Club</h2>
            <p class="text-muted">
                Your premier destination for relaxation and adventure. Nestled along pristine shores, we offer a unique blend of luxury, comfort, and natural beauty.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">🌴 Beachfront Location</h5>
                        <p class="card-text">Wake up to stunning ocean views and enjoy direct access to the sand and sea.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">🏨 Modern Amenities</h5>
                        <p class="card-text">From luxurious rooms to high-end dining, every detail is designed for your comfort.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">😊 Friendly Staff</h5>
                        <p class="card-text">Our team is dedicated to making your stay relaxing, fun, and worry-free.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">🎉 Family-Friendly Activities</h5>
                        <p class="card-text">Enjoy a wide range of activities for guests of all ages, from water sports to beach games.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="bg-light mt-5 py-4 border-top shadow-sm">
            <div class="container py-3">
                <div class="row gy-4 justify-content-between">
                    <!-- Logo and Address -->
                    <div class="col-md-4 text-start">
                        <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 60px; height: 60px;" />
                        <h5 class="mt-2">Sohu Beach Club Resort</h5>
                        <address class="mt-3">
                            Barangay Alacan<br />
                            San Fabian, Pangasinan,<br />
                            Philippines 2433<br />
                            <a href="mailto:gerbysohu@yahoo.com" class="text-dark">gerbysohu@yahoo.com</a>
                        </address>
                    </div>

                    <!-- Navigation Links -->
                    <div class="col-md-4 text-start">
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                            <li><a href="{{ url('/about') }}" class="text-dark text-decoration-none">About Us</a></li>
                            <li><a href="{{ url('/services') }}" class="text-dark text-decoration-none">Services</a></li>
                            <li><a href="{{ url('/accommodations') }}" class="text-dark text-decoration-none">Accommodations</a></li>
                            <li><a href="{{ url('/contact') }}" class="text-dark text-decoration-none">Contact</a></li>
                            <li><a href="{{ url('/reserve') }}" class="text-dark text-decoration-none">Book Now</a></li>
                        </ul>
                    </div>

                    <!-- Subscription Form -->
                    <div class="col-md-4 text-start">
                        <h6 class="fw-bold">
                            Be the first to discover exclusive deals.<br />
                            Subscribe now!
                        </h6>
                        <form class="d-flex mt-2">
                            <input type="email" class="form-control me-2" placeholder="Enter your email" />
                            <button class="btn btn-dark rounded-pill px-4">Subscribe</button>
                        </form>
                        <small class="d-block mt-2 text-muted">
                            By subscribing to our mailing list, you agree with our
                            <a href="#" class="text-dark text-decoration-underline">Privacy Policy</a>.
                        </small>
                        <div class="mt-3">
                            <a href="https://facebook.com/yourpage" target="_blank"><i class="bi bi-facebook me-3 fs-5"></i></a>
                            <a href="https://instagram.com/yourprofile" target="_blank"><i class="bi bi-instagram me-3 fs-5"></i></a>
                            <a href="https://tiktok.com/@yourprofile" target="_blank"><i class="bi bi-tiktok fs-5"></i></a>
                        </div>
                    </div>
                </div>

                <hr class="my-4" />

                <p class="text-center mb-0">&copy; COPYRIGHT SOHU BEACH CLUB RESORT 2025</p>
            </div>
        </footer>


</section>

@endsection

@extends('layouts.app')

@section('content')

<!-- 🌅 Hero Section -->
<section style="position: relative; width: 100%; height: 45vh; overflow: hidden;">
    <img src="{{ asset('images/homebg.jpg') }}"
         alt="About So Hu Beach Club"
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.55); z-index: -1;"></div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white h-100">
        <h1 class="fw-bold display-4 mb-3">About So Hu Beach Club Resort</h1>
        <p class="lead">Experience relaxation, luxury, and the beauty of Pangasinan’s shores.</p>
    </div>
</section>

<!-- 🏝 About Content Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <img src="{{ asset('images/resort.jpeg') }}" alt="Resort Overview" class="img-fluid rounded-4 shadow-sm">
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">Your Perfect Getaway Destination</h2>
                <p class="text-muted">
                    So Hu Beach Club Resort is your ultimate tropical escape — a haven where modern comfort meets natural serenity.
                    Nestled in the heart of <strong>San Fabian, Pangasinan</strong>, our beachfront resort offers the ideal spot for families, couples, and friends looking for both relaxation and adventure.
                </p>
                <p class="text-muted">
                    We take pride in our warm hospitality, elegant accommodations, and world-class amenities that promise to make every stay truly memorable.
                </p>
                <a href="{{ url('/reserve') }}" class="btn btn-dark rounded-pill px-4 mt-3">Book Your Stay</a>
            </div>
        </div>
    </div>
</section>

<!-- ✨ Features Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose So Hu Beach Club?</h2>
            <p class="text-muted">We go beyond hospitality — we create experiences that last a lifetime.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm text-center border-0">
                    <div class="card-body">
                        <i class="bi bi-umbrella-beach fs-1 mb-3 text-dark"></i>
                        <h5 class="fw-semibold">Beachfront Paradise</h5>
                        <p class="text-muted small">Wake up to breathtaking views and direct beach access.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm text-center border-0">
                    <div class="card-body">
                        <i class="bi bi-cup-hot fs-1 mb-3 text-dark"></i>
                        <h5 class="fw-semibold">On-Site Dining</h5>
                        <p class="text-muted small">Enjoy delicious local and international dishes by the sea.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm text-center border-0">
                    <div class="card-body">
                        <i class="bi bi-heart fs-1 mb-3 text-dark"></i>
                        <h5 class="fw-semibold">Romantic Escapes</h5>
                        <p class="text-muted small">Perfect for couples seeking a peaceful, intimate retreat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm text-center border-0">
                    <div class="card-body">
                        <i class="bi bi-people fs-1 mb-3 text-dark"></i>
                        <h5 class="fw-semibold">Family-Friendly</h5>
                        <p class="text-muted small">Fun activities for all ages, from water sports to movie nights.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🧭 Footer -->
<footer class="bg-light py-4 border-top shadow-sm">
    <div class="container">
        <div class="row gy-4 justify-content-between">
            <div class="col-md-4">
                <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 60px; height: 60px;">
                <h5 class="mt-2">Sohu Beach Club Resort</h5>
                <address class="text-muted mt-2">
                    Barangay Alacan<br>
                    San Fabian, Pangasinan, Philippines 2433<br>
                    <a href="mailto:gerbysohu@yahoo.com" class="text-dark">gerbysohu@yahoo.com</a>
                </address>
            </div>

            <div class="col-md-4">
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-dark text-decoration-none">About Us</a></li>
                    <li><a href="{{ url('/services') }}" class="text-dark text-decoration-none">Services</a></li>
                    <li><a href="{{ url('/accommodations') }}" class="text-dark text-decoration-none">Accommodations</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-dark text-decoration-none">Contact</a></li>
                    <li><a href="{{ url('/reserve') }}" class="text-dark text-decoration-none">Book Now</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold">Stay Updated</h6>
                <form class="d-flex mt-2">
                    <input type="email" class="form-control me-2" placeholder="Enter your email">
                    <button class="btn btn-dark rounded-pill px-4">Subscribe</button>
                </form>
                <small class="text-muted d-block mt-2">
                    By subscribing, you agree to our <a href="#" class="text-dark text-decoration-underline">Privacy Policy</a>.
                </small>
                <div class="mt-3">
                    <a href="https://facebook.com/yourpage" target="_blank"><i class="bi bi-facebook me-3 fs-5"></i></a>
                    <a href="https://instagram.com/yourprofile" target="_blank"><i class="bi bi-instagram me-3 fs-5"></i></a>
                    <a href="https://tiktok.com/@yourprofile" target="_blank"><i class="bi bi-tiktok fs-5"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <p class="text-center text-muted mb-0">&copy; 2025 SOHU BEACH CLUB RESORT. All Rights Reserved.</p>
    </div>
</footer>

@endsection

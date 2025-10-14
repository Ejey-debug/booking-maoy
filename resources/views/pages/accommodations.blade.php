@extends('layouts.app')

@section('content')

<!-- 🌅 Hero Section -->
<section style="position: relative; width: 100%; height: 50vh; overflow: hidden;">
    <img src="{{ asset('images/homebg.jpg') }}"
         alt="Hero Image"
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.55); z-index: -1;"></div>
    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white h-100 px-3">
        <p class="text-uppercase small fw-semibold">Relax. Recharge. Reconnect.</p>
        <h1 class="display-3 fw-bold mb-3">Luxury Rooms & Suites</h1>
        <p class="lead mb-4">Find your perfect escape in our beachfront accommodations designed for ultimate comfort.</p>
        <a href="{{ url('/reserve') }}" class="btn btn-light rounded-pill px-5 py-2 fw-semibold">Book Your Stay</a>
    </div>
</section>

<!-- 🏨 Accommodation Listings -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Choose Your Perfect Stay</h2>
            <p class="text-muted">Every room combines modern elegance with a touch of coastal charm.</p>
        </div>

        <div class="row g-4">
            <!-- Room Card Template -->
            @foreach([
                [
                    'name' => 'Villa A',
                    'img' => 'rooms/VillaA.jpeg',
                    'desc' => 'Spacious room with sea view and private balcony.',
                    'price' => '₱18,000 / Night',
                    'capacity' => '3-6 Persons',
                    'amenities' => 'WiFi, Aircon, TV, Mini Bar'
                ],
                [
                    'name' => 'Villa B',
                    'img' => 'rooms/VillaB.jpeg',
                    'desc' => 'Ideal for families with two queen beds and extra space.',
                    'price' => '₱15,000 / Night',
                    'capacity' => '3-6 Persons',
                    'amenities' => 'WiFi, Aircon, TV, Mini Fridge'
                ],
                [
                    'name' => 'Villa C',
                    'img' => 'rooms/VillaC,D,E,F.jpeg',
                    'desc' => 'Luxury suite with living area and balcony view.',
                    'price' => '₱15,000 / Night',
                    'capacity' => '3-6 Persons',
                    'amenities' => 'WiFi, Aircon, TV, Bathtub'
                ],
                [
                    'name' => 'Villa D',
                    'img' => 'rooms/VillaC,D,E,F.jpeg',
                    'desc' => 'Premium room with workspace and private lounge area.',
                    'price' => '₱15,000 / Night',
                    'capacity' => '3-6 Persons',
                    'amenities' => 'WiFi, Aircon, TV, Workspace'
                ],
                [
                    'name' => 'Villa E',
                    'img' => 'rooms/VillaC,D,E,F.jpeg',
                    'desc' => 'Private villa surrounded by tropical gardens.',
                    'price' => '₱15,000 / Night',
                    'capacity' => '3-6 Persons',
                    'amenities' => 'WiFi, Aircon, TV, Kitchen, Garden View'
                ],
                [
                    'name' => 'Villa F',
                    'img' => 'rooms/VillaC,D,E,F.jpeg',
                    'desc' => 'Top-floor suite with panoramic ocean views.',
                    'price' => '₱15,000 / Night',
                    'capacity' => '3-6 Persons',
                    'amenities' => 'WiFi, Aircon, TV, Jacuzzi'
                ]
            ] as $room)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="{{ asset($room['img']) }}" class="card-img-top" alt="{{ $room['name'] }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold">{{ $room['name'] }}</h5>
                            <p class="text-muted mb-2">{{ $room['desc'] }}</p>
                            <p class="mb-1"><strong>Capacity:</strong> {{ $room['capacity'] }}</p>
                            <p class="mb-1"><strong>Amenities:</strong> {{ $room['amenities'] }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-bold text-primary fs-5">{{ $room['price'] }}</span>
                            <a href="{{ url('/reserve') }}" class="btn btn-dark btn-sm rounded-pill px-3">Reserve Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 💬 Reservation CTA -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Ready to Relax by the Shore?</h2>
        <p class="lead mb-4">Book your room today and enjoy a beachfront experience like no other.</p>
        <a href="{{ url('/reserve') }}" class="btn btn-light rounded-pill px-5 py-2 fw-semibold">Check Availability</a>
    </div>
</section>

<!-- 🌴 Footer -->
<footer class="bg-light mt-5 py-4 border-top shadow-sm">
    <div class="container py-3">
        <div class="row gy-4 justify-content-between">
            <!-- Logo and Address -->
            <div class="col-md-4 text-start">
                <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 60px; height: 60px;">
                <h5 class="mt-2">Sohu Beach Club Resort</h5>
                <address class="mt-3 text-muted">
                    Barangay Alacan<br>
                    San Fabian, Pangasinan<br>
                    Philippines 2433<br>
                    <a href="mailto:gerbysohu@yahoo.com" class="text-dark">gerbysohu@yahoo.com</a>
                </address>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 text-start">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-dark text-decoration-none">About Us</a></li>
                    <li><a href="{{ url('/services') }}" class="text-dark text-decoration-none">Services</a></li>
                    <li><a href="{{ url('/accommodations') }}" class="text-dark text-decoration-none">Accommodations</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-dark text-decoration-none">Contact</a></li>
                    <li><a href="{{ url('/reserve') }}" class="text-dark text-decoration-none">Book Now</a></li>
                </ul>
            </div>

            <!-- Subscription -->
            <div class="col-md-4 text-start">
                <h6 class="fw-bold">Be the first to know our latest deals</h6>
                <form class="d-flex mt-2">
                    <input type="email" class="form-control me-2" placeholder="Enter your email">
                    <button class="btn btn-dark rounded-pill px-4">Subscribe</button>
                </form>
                <small class="d-block mt-2 text-muted">
                    By subscribing, you agree to our
                    <a href="#" class="text-dark text-decoration-underline">Privacy Policy</a>.
                </small>
                <div class="mt-3">
                    <a href="https://facebook.com/yourpage" target="_blank"><i class="bi bi-facebook me-3 fs-5"></i></a>
                    <a href="https://instagram.com/yourprofile" target="_blank"><i class="bi bi-instagram me-3 fs-5"></i></a>
                    <a href="https://tiktok.com/@yourprofile" target="_blank"><i class="bi bi-tiktok fs-5"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <p class="text-center mb-0">&copy; COPYRIGHT SOHU BEACH CLUB RESORT 2025</p>
    </div>
</footer>

@endsection

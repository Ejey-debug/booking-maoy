@extends('layouts.app')

@section('content')
<!-- 🌊 Full Width Hero Section -->
<section style="position: relative; width: 100%; height: 70vh; overflow: hidden;">
    <img src="{{ asset('images/homebg.jpg') }}"
         alt="Hero Image"
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;" />

    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: -1;"></div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white h-100 px-3">
        <p class="text-uppercase small fw-semibold mb-2">A Place Where Paradise Meets Comfort</p>
        <h1 class="display-3 fw-bold mb-3">Welcome to So Hu Beach Club</h1>
        <p class="lead mb-4">Experience luxury, relaxation, and unforgettable moments by the sea.</p>
        <a href="{{ url('/reserve') }}" class="btn btn-light text-dark fw-bold rounded-pill px-5 py-2">
            Book Your Stay Now
        </a>
    </div>
</section>


<!-- 🏝 Services Section -->
<section class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Our Premium Services</h2>
        <p class="text-muted mb-5">
            Discover the perfect blend of relaxation, recreation, and refined comfort.
        </p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded h-100 border hover-shadow">
                    <i class="bi bi-house-heart text-primary fs-1 mb-3"></i>
                    <h4 class="fw-bold">Elegant Villas</h4>
                    <p class="text-muted">Stylish beachfront villas designed for comfort and serenity.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded h-100 border hover-shadow">
                    <i class="bi bi-water text-primary fs-1 mb-3"></i>
                    <h4 class="fw-bold">Exciting Activities</h4>
                    <p class="text-muted">Enjoy water sports, island hopping, or peaceful sunset yoga sessions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded h-100 border hover-shadow">
                    <i class="bi bi-egg-fried text-primary fs-1 mb-3"></i>
                    <h4 class="fw-bold">Fine Dining</h4>
                    <p class="text-muted">Savor gourmet dishes and fresh seafood prepared by top chefs.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- 🏖 Featured Accommodations & Quick Reservation -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Choose Your Perfect Getaway</h2>
        <p class="text-muted mb-5">Select from our finest villas designed for luxury and relaxation.</p>

        <div class="row g-4 justify-content-center">
            <!-- Villa A -->
            <div class="col-md-4">
                <div class="card border-0 shadow rounded-3 overflow-hidden h-100">
                    <img src="{{ asset('rooms/VillaA.jpeg') }}" class="card-img-top" alt="Villa A">
                    <div class="card-body">
                        <h5 class="fw-bold">Villa A – Sea View</h5>
                        <p class="text-muted mb-1">₱18,000 / Night</p>
                        <p class="small">Spacious villa with balcony, minibar, and panoramic sea view.</p>
                        <a href="{{ url('/reserve') }}" class="btn btn-dark rounded-pill px-4">Reserve Now</a>
                    </div>
                </div>
            </div>

            <!-- Villa B -->
            <div class="col-md-4">
                <div class="card border-0 shadow rounded-3 overflow-hidden h-100">
                    <img src="{{ asset('rooms/VillaB.jpeg') }}" class="card-img-top" alt="Villa B">
                    <div class="card-body">
                        <h5 class="fw-bold">Villa B – Family Suite</h5>
                        <p class="text-muted mb-1">₱15,000 / Night</p>
                        <p class="small">Perfect for families with extra space and comfort.</p>
                        <a href="{{ url('/reserve') }}" class="btn btn-dark rounded-pill px-4">Reserve Now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ url('/accommodations') }}" class="btn btn-outline-dark rounded-pill px-5 py-2">
                View All Accommodations
            </a>
        </div>
    </div>
</section>


<!-- 🌅 Call to Action -->
<section class="py-5 text-white" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/sunset.jpg') }}') center/cover no-repeat;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Plan Your Perfect Escape</h2>
        <p class="lead mb-4">Let the soothing sound of the waves and the golden sunset complete your getaway.</p>
        <a href="{{ url('/reserve') }}" class="btn btn-light text-dark fw-bold rounded-pill px-5 py-2">
            Start Your Reservation
        </a>
    </div>
</section>


<!-- 🌴 Footer Section -->
<footer class="bg-light mt-5 py-4 border-top shadow-sm">
    <div class="container py-3">
        <div class="row gy-4 justify-content-between">
            <div class="col-md-4">
                <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 60px; height: 60px;">
                <h5 class="mt-2">Sohu Beach Club Resort</h5>
                <address class="mt-3">
                    Barangay Alacan<br>
                    San Fabian, Pangasinan,<br>
                    Philippines 2433<br>
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
                <h6 class="fw-bold">Be the first to discover exclusive deals.<br>Subscribe now!</h6>
                <form class="d-flex mt-2">
                    <input type="email" class="form-control me-2" placeholder="Enter your email">
                    <button class="btn btn-dark rounded-pill px-4">Subscribe</button>
                </form>
                <small class="d-block mt-2 text-muted">
                    By subscribing, you agree with our
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

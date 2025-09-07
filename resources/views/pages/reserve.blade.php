@extends('layouts.app')

@section('content')
<div class="py-5 position-relative" style="
    background: url('{{ asset('images/homebg.jpg') }}') no-repeat center center;
    background-size: cover;
    min-height: 100vh;
">
    <!-- Overlay -->
    <div style="
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 0;
    "></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow bg-white bg-opacity-75">
                    <div class="card-body p-4">
                        <h2 class="mb-4 text-center">Book Your Stay</h2>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form id="reservationForm" method="GET" action="{{ url('/availability') }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required />
                            </div>

                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contact" name="contact" required />
                            </div>

                            <div class="mb-3">
                                <label for="check_in_date" class="form-label">Check-in Date</label>
                                <input type="date" class="form-control" id="check_in_date" name="check_in_date" min="{{ date('Y-m-d') }}" required />
                            </div>

                            <div class="mb-3">
                                <label for="check_out_date" class="form-label">Check-out Date</label>
                                <input type="date" class="form-control" id="check_out_date" name="check_out_date" min="{{ date('Y-m-d') }}" required />
                            </div>

                            <div class="mb-4">
                                <label for="nights" class="form-label">Number of Guests</label>
                                <input type="number" class="form-control" id="nights" name="nights" min="1" required />
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Check Availability</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light mt-5 py-4 border-top shadow-sm">
    <div class="container py-3">
        <div class="row gy-4 justify-content-between">
            <!-- Logo & Address -->
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

            <!-- Navigation -->
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

            <!-- Newsletter -->
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
                    <a href="#"><i class="bi bi-facebook me-3 fs-5"></i></a>
                    <a href="#"><i class="bi bi-instagram me-3 fs-5"></i></a>
                    <a href="#"><i class="bi bi-tiktok fs-5"></i></a>
                </div>
            </div>
        </div>

        <hr class="my-4" />
        <p class="text-center mb-0">&copy; COPYRIGHT SOHU BEACH CLUB RESORT 2025</p>
    </div>
</footer>
@endsection

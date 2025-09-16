@extends('layouts.app')

@section('content')
<!-- 🌊 Full Width Hero Section -->
<section style="position: relative; width: 100%; height: 100vh; overflow: hidden;">

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
        </p>
        <a href="{{ url('/accommodations') }}" class="btn btn-light btn-lg rounded-pill px-4">Explore Accommodations</a>
    </div>

</section>



<!-- Introduction Section -->
<section class="bg-white text-dark py-5">
    <div class="container text-center">
        <p class="lead fw-semibold">Escape. Relax. Party. Repeat.</p>
        <p>
            Welcome to Sohu Beach Club — your exclusive escape from the ordinary. Whether you're here to chill with friends,
            dance under the stars, or enjoy gourmet seaside dining, Sohu sets the standard for beachfront luxury.
        </p>
        <p>
            Choose from a variety of accommodations and services tailored to your needs. We provide the perfect setting for
            weddings, birthdays, reunions, and other celebrations that deserve to be unforgettable.
        </p>
        <ul class="list-unstyled mb-4">
            <li><strong>Located:</strong> Alacan, San Fabian, Pangasinan</li>
        </ul>

<!-- 🌍 Embedded Map -->
<div class="d-flex justify-content-center mb-3">
    <div class="ratio ratio-4x3" style="max-width: 500px; height: 300px;">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d833.5350098330586!2d120.4262974223769!3d16.167700853476685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33916f001ad74497%3A0x7008bcefb32cd9b4!2sSOHU%20BEACH%20CLUB!5e1!3m2!1sen!2sph!4v1757008554899!5m2!1sen!2sph"
            style="border:0; border-radius: 12px; width:100%; height:100%;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>




        <!-- Gallery Row -->
        <div class="row flex-nowrap overflow-auto pb-3">
            <div class="col-8 col-md-4">
                <img src="{{ asset('images/bg1.jpg') }}" class="img-fluid rounded shadow-sm" alt="Gallery Image 1" />
            </div>
            <div class="col-8 col-md-4">
                <img src="{{ asset('images/bg2.jpg') }}" class="img-fluid rounded shadow-sm" alt="Gallery Image 2" />
            </div>
            <div class="col-8 col-md-4">
                <img src="{{ asset('images/bg3.jpg') }}" class="img-fluid rounded shadow-sm" alt="Gallery Image 3" />
            </div>
        </div>

    </div>
</section>

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
@endsection

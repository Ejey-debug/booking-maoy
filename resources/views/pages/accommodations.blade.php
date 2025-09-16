@extends('layouts.app') @section('content')
<!-- 🌊 Full Width Hero Section -->
<section style="position: relative; width: 100%; height: 50vh; overflow: hidden;">
    <img src="{{ asset('images/homebg.jpg') }}"
         alt="Hero Image"
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;" />
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: -1;"></div>
    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white h-100 px-3">
        <p class="text-uppercase small fw-semibold">Best Hotel With Cozy Rooms</p>
        <h1 class="display-3 fw-bold mb-3">Just Experience A New Level<br />Of Luxury.</h1>
        <p class="lead mb-4">
            Discover comfort, elegance, and unforgettable memories along the serene shores of So Hu Beach.
        </p>
    </div>
</section>

<!-- Accommodations Carousel Section -->
<div class="container mt-5">
    <h2 class="fw-bold">Accommodations</h2>
    <p class="text-muted">Choose from our range of luxurious rooms and suites, each designed for your comfort and relaxation.</p>

    <div id="roomsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/bg1.jpg') }}" class="card-img-top" alt="Deluxe Room" style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Deluxe Room</h5>
                                <p class="card-text">Spacious room with sea view and balcony.</p>
                                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal"
                                    data-bs-target="#roomInfoModal"
                                    data-img="{{ asset('images/bg1.jpg') }}"
                                    data-room="Deluxe Room"
                                    data-desc="Spacious room with sea view and balcony."
                                    data-price="₱3,500"
                                    data-capacity="2 Adults"
                                    data-amenities="WiFi, Aircon, TV, Mini Bar">
                                    More Info
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/bg2.jpg') }}" class="card-img-top" alt="Family Room" style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Family Room</h5>
                                <p class="card-text">Perfect for families, with two queen beds.</p>
                                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal"
                                    data-bs-target="#roomInfoModal"
                                    data-img="{{ asset('images/bg2.jpg') }}"
                                    data-room="Family Room"
                                    data-desc="Perfect for families, with two queen beds."
                                    data-price="₱4,500"
                                    data-capacity="4 Adults"
                                    data-amenities="WiFi, Aircon, TV, Mini Fridge">
                                    More Info
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/bg3.jpg') }}" class="card-img-top" alt="Suite" style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Suite</h5>
                                <p class="card-text">Luxury suite with private balcony.</p>
                                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal"
                                    data-bs-target="#roomInfoModal"
                                    data-img="{{ asset('images/bg3.jpg') }}"
                                    data-room="Suite"
                                    data-desc="Luxury suite with private balcony."
                                    data-price="₱6,000"
                                    data-capacity="2 Adults"
                                    data-amenities="WiFi, Aircon, TV, Mini Bar, Bathtub">
                                    More Info
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/bg1.jpg') }}" class="card-img-top" alt="Executive Room" style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Executive Room</h5>
                                <p class="card-text">Premium room with workspace and lounge area.</p>
                                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal"
                                    data-bs-target="#roomInfoModal"
                                    data-img="{{ asset('images/bg4.jpg') }}"
                                    data-room="Executive Room"
                                    data-desc="Premium room with workspace and lounge area."
                                    data-price="₱5,000"
                                    data-capacity="2 Adults"
                                    data-amenities="WiFi, Aircon, TV, Workspace, Lounge">
                                    More Info
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/bg2.jpg') }}" class="card-img-top" alt="Penthouse" style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Penthouse</h5>
                                <p class="card-text">Top floor suite with panoramic views.</p>
                                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal"
                                    data-bs-target="#roomInfoModal"
                                    data-img="{{ asset('images/bg5.jpg') }}"
                                    data-room="Penthouse"
                                    data-desc="Top floor suite with panoramic views."
                                    data-price="₱8,000"
                                    data-capacity="2 Adults"
                                    data-amenities="WiFi, Aircon, TV, Mini Bar, Jacuzzi">
                                    More Info
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('images/bg3.jpg') }}" class="card-img-top" alt="Garden Villa" style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Garden Villa</h5>
                                <p class="card-text">Private villa surrounded by lush gardens.</p>
                                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal"
                                    data-bs-target="#roomInfoModal"
                                    data-img="{{ asset('images/bg3.jpg') }}"
                                    data-room="Garden Villa"
                                    data-desc="Private villa surrounded by lush gardens."
                                    data-price="₱7,000"
                                    data-capacity="4 Adults"
                                    data-amenities="WiFi, Aircon, TV, Kitchen, Garden">
                                    More Info
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#roomsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#roomsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Room Info Modal -->
<div class="modal fade" id="roomInfoModal" tabindex="-1" aria-labelledby="roomInfoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roomInfoLabel">Room Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="modalRoomImg" src="" alt="Room Image" class="img-fluid rounded mb-3" style="max-height:200px;object-fit:cover;">
        <h4 id="modalRoomName"></h4>
        <p id="modalRoomDesc"></p>
        <ul class="list-unstyled mb-2">
            <li><strong>Price:</strong> <span id="modalRoomPrice"></span></li>
            <li><strong>Capacity:</strong> <span id="modalRoomCapacity"></span></li>
            <li><strong>Amenities:</strong> <span id="modalRoomAmenities"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-light mt-5 py-4 border-top shadow-sm">
    <div class="container py-3">
        <div class="row gy-4 justify-content-between">
            <!-- Logo and Contact -->
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
            <!-- Subscription -->
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

<script>
document.querySelectorAll('[data-bs-target="#roomInfoModal"]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('modalRoomImg').src = btn.getAttribute('data-img');
        document.getElementById('modalRoomName').textContent = btn.getAttribute('data-room');
        document.getElementById('modalRoomDesc').textContent = btn.getAttribute('data-desc');
        document.getElementById('modalRoomPrice').textContent = btn.getAttribute('data-price');
        document.getElementById('modalRoomCapacity').textContent = btn.getAttribute('data-capacity');
        document.getElementById('modalRoomAmenities').textContent = btn.getAttribute('data-amenities');
    });
});
</script>
@endsection

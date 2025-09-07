@extends('layouts.app') @section('content')
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
<div class="container py-5">
    <div class="row">
        <!-- Contact Form -->
        <div class="col-md-6">
            <h4 class="fw-bold mb-3">
                Contact Us<br />
                For Reservations
            </h4>

            <form method="POST" action="{{ url('/contact/send') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Full Name" required />
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required />
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="contact" placeholder="Contact Number" required />
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="message" rows="4" placeholder="Message" style="background-color: #e1e1e1;" required></textarea>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="terms" required />
                    <label class="form-check-label small" for="terms"> I accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a> </label>
                </div>
                <button type="submit" class="btn btn-dark">Send Email</button>
            </form>

            @if(session('success'))
                <div id="contact-success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        var alert = document.getElementById('contact-success-alert');
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 3000); // 3 seconds
                </script>
            @endif
        </div>

        <!-- Contact Info -->
        <div class="col-md-6 mt-4 mt-md-0 ps-md-4">
            <h6 class="fw-bold">Main Office Address</h6>
            <p>
                Unit 202, 2nd Floor 3G Arcade Building<br />
                Don Juico Boulevard Corner West Service Road<br />
                Angeles City, Pampanga
            </p>

            <h6 class="fw-bold">Telephone Numbers</h6>
            <p>
                Landline: +63 45 978 0134 | 0960 965 6546<br />
                Mobile: +63 950 024 3243 | +63 997 984 5275<br />
                Viber/WhatsApp: +63 917 674 4421 | +63 927 625 6497
            </p>

            <h6 class="fw-bold">Beach Address</h6>
            <p>
                Barangay Alacan<br />
                San Fabian, Pangasinan<br />
                Resort Number: +63 920 945 6215 | +63 920 951 6051
            </p>

            <h6 class="fw-bold">Email</h6>
            <p>SohubeachClub@gmail.com</p>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold">How Can We Help You?</h3>
            <p class="text-muted">Frequently Asked Questions</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="bg-white p-4 rounded shadow-sm border">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    What is the check-in time?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Check-in starts at 2:00 PM.</div>
                            </div>
                        </div>

                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    Can we bring pets?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Yes, small pets are allowed in designated areas.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA -->
    <div class="text-center mt-5">
        <h5 class="fw-bold">Still Have A Question?</h5>
        <button class="btn btn-dark">Contact Us</button>
    </div>
</div>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Welcome to So Hu Beach Club!</strong></p>
                <p>By submitting this form, you agree to the following terms and conditions:</p>
                <ul>
                    <li>All reservations are subject to availability and confirmation.</li>
                    <li>Cancellation policies apply and vary depending on your booking.</li>
                    <li>Personal information will be handled securely and used solely for communication and reservation purposes.</li>
                    <li>Guests must adhere to resort policies during their stay.</li>
                </ul>
                <p>We reserve the right to modify these terms at any time.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light mt-5 py-4 border-top shadow-sm">
    <div class="container py-3">
        <div class="row gy-4 justify-content-between">
            <!-- Logo & Address -->
            <div class="col-md-4">
                <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 60px; height: 60px;" />
                <h5 class="mt-2">Sohu Beach Club Resort</h5>
                <address class="mt-3">
                    Barangay Alacan<br />
                    San Fabian, Pangasinan,<br />
                    Philippines 2433<br />
                    <a href="mailto:gerbysohu@yahoo.com" class="text-dark">gerbysohu@yahoo.com</a>
                </address>
            </div>

            <!-- Site Links -->
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

            <!-- Subscription -->
            <div class="col-md-4">
                <h6 class="fw-bold">
                    Be the first to discover exclusive deals.<br />
                    Subscribe now!
                </h6>
                <form class="d-flex mt-2">
                    <input type="email" class="form-control me-2" placeholder="Enter your email" />
                    <button class="btn btn-dark rounded-pill px-4">Subscribe</button>
                </form>
                <small class="d-block mt-2 text-muted">
                    By subscribing, you agree to our
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

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

</section>

<div class="container py-5">
    <h2 class="mb-4 text-center">Room Availability</h2>
    <div class="mb-3 text-center">
        <strong>Check-in:</strong> {{ $check_in_date }}<br>
        <strong>Check-out:</strong> {{ $check_out_date }}
    </div>
    <div class="row">
        @forelse($rooms as $room)
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" alt="{{ $room->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-room.jpg') }}" class="card-img-top" alt="Default Room" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        <p class="card-text">{{ $room->description }}</p>
                        <p class="card-text">
                            <strong>Total Price:</strong> ₱{{ number_format($room->price, 2) }} <br>
                            <strong>50% Downpayment:</strong> ₱{{ number_format($room->price / 2, 2) }}
                        </p>
                        <span class="badge bg-success mb-2">Available</span>
                        <button class="btn btn-primary mt-auto"
                            onclick="showConfirmationModal('{{ $room->id }}', '{{ $room->name }}', '{{ $room->price }}')">
                            Book This Room
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No rooms available for your selected dates.
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Booking Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Room:</strong> <span id="modalRoomName"></span></p>
                <p><strong>Total Price:</strong> ₱<span id="modalRoomPrice"></span></p>
                <p><strong>50% Downpayment:</strong> ₱<span id="modalRoomDownpayment"></span></p>

                <h6>Choose Payment Method</h6>
                <div class="d-flex gap-3 mb-3">
                    <button type="button" class="btn btn-outline-primary" onclick="selectPayment('gcash')">GCash</button>
                    <button type="button" class="btn btn-outline-info" onclick="selectPayment('maya')">Maya</button>
                </div>

                <div id="qrSection" class="text-center" style="display: none;">
                    <p>Scan this QR Code to pay:</p>
                    <img id="qrCodeImage" src="" alt="QR Code" style="max-width: 200px;" />
                </div>
            </div>
            <div class="modal-footer">
                <form id="bookRoomForm" method="POST" action="{{ url('/reserve') }}" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="room_id" id="modalRoomId" />
                    <input type="hidden" name="check_in_date" value="{{ $check_in_date }}" />
                    <input type="hidden" name="check_out_date" value="{{ $check_out_date }}" />
                    <input type="hidden" name="payment_method" id="hiddenPaymentMethod" value="gcash" />

                    <!-- Guest Info -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact" class="form-control" maxlength="11" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number of Nights</label>
                        <input type="number" name="nights" class="form-control" min="1" value="1" required />
                    </div>

                    <div class="mb-2">
                        <label for="modalPaymentProof" class="form-label">Proof of Payment</label>
                        <input type="file" class="form-control" id="modalPaymentProof" name="payment_proof" accept="image/*" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Confirm & Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
    function showConfirmationModal(roomId, roomName, roomPrice) {
        document.getElementById("modalRoomId").value = roomId;
        document.getElementById("modalRoomName").textContent = roomName;
        document.getElementById("modalRoomPrice").textContent = parseFloat(roomPrice).toFixed(2);
        document.getElementById("modalRoomDownpayment").textContent = (roomPrice / 2).toFixed(2);
        var modal = new bootstrap.Modal(document.getElementById("confirmationModal"));
        modal.show();
    }

    function selectPayment(method) {
        document.getElementById("hiddenPaymentMethod").value = method;

        let qrSection = document.getElementById("qrSection");
        let qrCodeImage = document.getElementById("qrCodeImage");

        if (method === "gcash") {
            qrCodeImage.src = "{{ asset('images/gcash-qr.png') }}"; // Replace with your GCash QR
            qrSection.style.display = "block";
        } else if (method === "maya") {
            qrCodeImage.src = "{{ asset('images/maya-qr.png') }}"; // Replace with your Maya QR
            qrSection.style.display = "block";
        }
    }
</script>


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

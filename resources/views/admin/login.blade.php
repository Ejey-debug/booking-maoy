@extends('layouts.admin')

@section('content')
<div class="container py-5 min-vh-100 d-flex flex-column justify-content-center">
    <div class="row justify-content-center flex-grow-1">
        <div class="col-md-5">
            <div class="card shadow bg-white bg-opacity-75">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Sohu Logo" style="width: 60px; height: 60px;" class="mb-2" />
                    </div>
                    <h3 class="mb-4 text-center">Admin Login</h3>
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ url('/admin/login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <hr class="my-4" />
        <p class="text-center mb-0">&copy; COPYRIGHT SOHU BEACH CLUB RESORT 2025</p>
    </div>
@endsection

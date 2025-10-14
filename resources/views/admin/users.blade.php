@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <h2 class="mb-4 fw-bold">Users</h2>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ optional($user->created_at)->format('Y-m-d h:i A') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
    <div class="container py-4">
        <h2>Account Settings</h2>

        <div class="row g-4">
            {{-- Profile Info Update --}}
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Edit Profile</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user-profile-information.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input name="name" type="text"
                                    class="form-control @error('updateProfileInformation.name') is-invalid @enderror"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                                @error('updateProfileInformation.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input name="username" type="text"
                                    class="form-control @error('updateProfileInformation.username') is-invalid @enderror"
                                    value="{{ old('username', auth()->user()->username) }}" required>
                                @error('updateProfileInformation.username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email"
                                    class="form-control @error('updateProfileInformation.email') is-invalid @enderror"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                                @error('updateProfileInformation.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                {{-- Password Update --}}
                <div class="card">
                    <div class="card-header">Update Password</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user-password.update') }}">
                            @csrf
                            @method('PUT')

                            {{-- Current password --}}
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input name="current_password" type="password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    required>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New password --}}
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input name="password" type="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm --}}
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="password_confirmation" type="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

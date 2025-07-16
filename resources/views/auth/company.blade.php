@extends('layouts.app')

@section('title', 'Edit Perusahaan')

@section('content')
    <div class="container py-4">
        <h2>Edit Perusahaan</h2>

        <div class="row g-4">
            {{-- Left: Form --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Perusahaan Details</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('company.update', $company->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Perusahaan Name</label>
                                <input name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $company->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $company->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input name="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $company->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $company->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Logo Upload Field Only --}}
                            <div class="mb-3">
                                <label class="form-label">Upload New Logo</label>
                                <input type="file" name="logo"
                                    class="form-control @error('logo') is-invalid @enderror">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Update Perusahaan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right: Logo Preview --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Current Logo</div>
                    <div class="card-body text-center">
                        @if ($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Perusahaan" class="img-fluid"
                                style="max-height: 200px;">
                        @else
                            <p class="text-muted">Belum ada logo</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', $title)

@section('content')
    <h2>{{ $title }}</h2>

    <div class="row mt-4">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit {{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('outcome.update', $outcome->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        {{-- Row 1: Nama outcomes & Spesialis --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_list_out" class="form-label">Nama List Pengeluaran <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_list_out" name="nama_list_out"
                                    placeholder="Nama List Pengeluaran"
                                    value="{{ old('nama_list_out', $outcome->nama_list_out) }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('outcome.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

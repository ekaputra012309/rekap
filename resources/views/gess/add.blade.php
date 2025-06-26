@extends('layouts.app')

@section('title', $title)

@section('content')
    <h2>{{ $title }}</h2>

    <div class="row mt-4">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Input {{ $title }} Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('gess.store') }}" method="POST">
                        @csrf

                        {{-- Hidden User ID --}}
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $datenow }}" required>
                                @error('tanggal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Donatur --}}
                            <div class="col-md-3">
                                <label for="nama_donatur" class="form-label">Nama Donatur <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_donatur" name="nama_donatur"
                                    placeholder="Nama Donatur" value="{{ old('nama_donatur') }}" required>
                                @error('nama_donatur')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kaleng --}}
                            <div class="col-md-2">
                                <label for="kaleng" class="form-label">Jml Kaleng <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="kaleng" name="kaleng"
                                    placeholder="Jumlah Kaleng" value="{{ old('kaleng') }}" min="1" required>
                                @error('kaleng')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nominal --}}
                            <div class="col-md-3">
                                <label for="nominal" class="form-label">Nominal (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="nominal" name="nominal"
                                    placeholder="Nominal" value="{{ old('nominal') }}" min="0" step="0.01"
                                    required>
                                @error('nominal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-md-7">
                                <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="Keterangan" value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('gess.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                    <form action="{{ route('gess.update', $gess->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', \Carbon\Carbon::parse($gess->tanggal)->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Donatur --}}
                            <div class="col-md-3">
                                <label for="nama_donatur" class="form-label">Nama Donatur <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_donatur" name="nama_donatur"
                                    value="{{ old('nama_donatur', $gess->nama_donatur) }}" required>
                                @error('nama_donatur')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kaleng --}}
                            <div class="col-md-2">
                                <label for="kaleng" class="form-label">Jml Kaleng <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="kaleng" name="kaleng"
                                    value="{{ old('kaleng', $gess->kaleng) }}" min="1" required>
                                @error('kaleng')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nominal --}}
                            <div class="col-md-3">
                                <label for="nominal" class="form-label">Nominal (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="nominal" name="nominal"
                                    value="{{ old('nominal', $gess->nominal) }}" min="0" step="0.01" required>
                                @error('nominal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-md-7">
                                <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    value="{{ old('keterangan', $gess->keterangan) }}">
                                @error('keterangan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('gess.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

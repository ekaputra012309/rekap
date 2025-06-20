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
                    <form action="{{ route('poliklinik.store') }}" method="post">
                        @csrf
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="kode_poli" class="form-label">Kode Poliklinik</label>
                                <input type="text" class="form-control" id="kode_poli" name="kode_poli"
                                    placeholder="Kode Poliklinik" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nama_poli" class="form-label">Nama Poliklinik</label>
                                <input type="text" class="form-control" id="nama_poli" name="nama_poli"
                                    placeholder="Nama Poliklinik" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('poliklinik.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

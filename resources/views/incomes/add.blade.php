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
                    <form action="{{ route('income.store') }}" method="post">
                        @csrf
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        {{-- Row 1: Nama Dokter & Spesialis --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_list_in" class="form-label">Nama List Pemasukan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_list_in" name="nama_list_in"
                                    placeholder="Nama List Pemasukan" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('income.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

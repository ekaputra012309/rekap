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
                    <form action="{{ route('dokter.store') }}" method="post">
                        @csrf
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        {{-- Row 1: Nama Dokter & Spesialis --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_dokter" class="form-label">Nama Dokter <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_dokter" name="nama_dokter"
                                    placeholder="Nama Dokter" required>
                            </div>

                            <div class="col-md-6">
                                <label for="poli_id" class="form-label">Spesialis <span
                                        class="text-danger">*</span></label>
                                <select name="poli_id" id="poli_id" class="form-control select2" required>
                                    <option value="">Pilih</option>
                                    @foreach ($datapoli as $dp)
                                        <option value="{{ $dp->id }}">{{ $dp->nama_poli }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Row 2: Keterangan --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="10" rows="2"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('dokter.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

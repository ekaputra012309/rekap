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
                    <form action="{{ route('saldo.update', $saldo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        <div class="row">

                            {{-- saldo_awal --}}
                            <div class="col-md-3">
                                <label for="saldo_awal" class="form-label">Saldo Awal (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="saldo_awal" name="saldo_awal"
                                    value="{{ old('saldo_awal', $saldo->saldo_awal) }}" required>
                                @error('saldo_awal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('saldo.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

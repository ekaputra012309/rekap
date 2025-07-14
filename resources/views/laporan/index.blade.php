@extends('layouts.app')

@section('title', $title)

@section('content')
    <h2>{{ $title }}</h2>
    <!-- New Row for DataTable -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 d-none d-md-block">Data {{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.cetak') }}" target="_blank">
                        <label>Start Date:</label>
                        <input class="form-control mb-2" type="date" name="start" value="{{ request('start') }}"
                            required>
                        <label>End Date:</label>
                        <input class="form-control mb-2" type="date" name="end" value="{{ request('end') }}"
                            required>
                        <button class="btn btn-primary" type="submit">Generate PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

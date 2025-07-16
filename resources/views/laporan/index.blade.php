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
                        <div class="row">
                            <div class="form-group col-12 col-md-3">
                                <label>Jenis Laporan:</label>
                                <select name="type" class="form-control mb-2" required>
                                    <option value="laporan" {{ request('type') == 'laporan' ? 'selected' : '' }}>Laporan
                                        Umum
                                    </option>
                                    <option value="gib" {{ request('type') == 'gib' ? 'selected' : '' }}>GIB</option>
                                    <option value="gess" {{ request('type') == 'gess' ? 'selected' : '' }}>GESS</option>
                                    <option value="doom" {{ request('type') == 'doom' ? 'selected' : '' }}>DOOM</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-md-3">
                                <label>Start Date:</label>
                                <input class="form-control mb-2" type="date" name="start"
                                    value="{{ request('start') }}" required>
                            </div>

                            <div class="form-group col-12 col-md-3">
                                <label>End Date:</label>
                                <input class="form-control mb-2" type="date" name="end" value="{{ request('end') }}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary " type="submit"><i class="fas fa-file-pdf"></i> Generate
                                PDF</button>
                            <button class="btn btn-secondary" type="reset"><i class="fas fa-redo-alt"></i> Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

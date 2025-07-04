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
                    <form action="{{ route('pengeluaran.store') }}" method="post">
                        @csrf
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        {{-- Row: Tanggal --}}
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $datenow }}" required>
                            </div>
                        </div>

                        <hr>

                        {{-- Detail Rows --}}
                        <h5>Detail pengeluaran</h5>
                        <table class="table table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th>Rincian</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th><button type="button" class="btn btn-success btn-sm" id="addRow"><i
                                                class="fas fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="details[0][outcome_id]" class="form-control outcome-select" required>
                                            <option value="">-- Pilih Rincian --</option>
                                            @foreach ($outcomes as $outcome)
                                                <option value="{{ $outcome->id }}">{{ $outcome->nama_list_out }}</option>
                                            @endforeach
                                            <option value="custom">-- Custom --</option>
                                        </select>
                                        <input type="text" name="details[0][custom_rincian]"
                                            class="form-control mt-2 custom-input d-none"
                                            placeholder="Masukkan Rincian Custom">
                                    </td>
                                    <td>
                                        <input type="number" name="details[0][nominal]" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="details[0][keterangan]" class="form-control">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let rowIdx = 1;

        $(document).ready(function() {
            // Add Row
            $('#addRow').click(function() {
                $('#detailTable tbody').append(`
                <tr>
                    <td>
                        <select name="details[${rowIdx}][outcome_id]" class="form-control outcome-select" required>
                            <option value="">-- Pilih Rincian --</option>
                            @foreach ($outcomes as $outcome)
                                <option value="{{ $outcome->id }}">{{ $outcome->nama_list_out }}</option>
                            @endforeach
                            <option value="custom">-- Custom --</option>
                        </select>
                        <input type="text" name="details[${rowIdx}][custom_rincian]" class="form-control mt-2 custom-input d-none"
                            placeholder="Masukkan Rincian Custom">
                    </td>
                    <td><input type="number" name="details[${rowIdx}][nominal]" class="form-control" required></td>
                    <td><input type="text" name="details[${rowIdx}][keterangan]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash"></i></button></td>
                </tr>
            `);

                rowIdx++;
            });

            // Remove Row
            $('#detailTable').on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });

            // Toggle custom input
            $('#detailTable').on('change', '.outcome-select', function() {
                let selected = $(this).val();
                let customInput = $(this).closest('td').find('.custom-input');
                let dropdown = $(this); // current select element

                if (selected === 'custom') {
                    dropdown.addClass('d-none'); // hide dropdown
                    customInput.removeClass('d-none'); // show input
                    customInput.prop('required', true);
                    customInput.focus(); // optional: auto-focus the input
                } else {
                    customInput.addClass('d-none'); // hide input if not custom
                    customInput.prop('required', false);
                    customInput.val('');
                }
            });
        });
    </script>
@endpush

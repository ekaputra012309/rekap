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
                    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        {{-- Row: Tanggal --}}
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', $pengeluaran->tanggal->format('Y-m-d')) }}" required>
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
                                @foreach ($pengeluaran->details as $index => $detail)
                                    <tr>
                                        <td>
                                            @php
                                                $isCustom = is_null($detail->outcome_id);
                                            @endphp

                                            <select name="details[{{ $index }}][outcome_id]"
                                                class="form-control outcome-select {{ $isCustom ? 'd-none' : '' }}"
                                                data-index="{{ $index }}">
                                                <option value="">-- Pilih Rincian --</option>
                                                @foreach ($outcomes as $outcome)
                                                    <option value="{{ $outcome->id }}"
                                                        {{ $detail->outcome_id == $outcome->id ? 'selected' : '' }}>
                                                        {{ $outcome->nama_list_out }}
                                                    </option>
                                                @endforeach
                                                <option value="custom" {{ $isCustom ? 'selected' : '' }}>-- Custom --
                                                </option>
                                            </select>

                                            <input type="text" name="details[{{ $index }}][custom_rincian]"
                                                class="form-control mt-2 custom-input {{ $isCustom ? '' : 'd-none' }}"
                                                placeholder="Masukkan Rincian Custom"
                                                value="{{ $detail->custom_rincian }}">
                                        </td>
                                        <td>
                                            <input type="number" name="details[{{ $index }}][nominal]"
                                                class="form-control" value="{{ $detail->nominal }}" required>
                                        </td>
                                        <td>
                                            <input type="text" name="details[{{ $index }}][keterangan]"
                                                class="form-control" value="{{ $detail->keterangan }}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="details[{{ $index }}][id]"
                                                value="{{ $detail->id }}">
                                            <button type="button" class="btn btn-danger btn-sm removeRow"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let rowIdx = {{ $pengeluaran->details->count() }};

        $(document).ready(function() {

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
                            <input type="text" name="details[${rowIdx}][custom_rincian]" class="form-control mt-2 custom-input d-none" placeholder="Masukkan Rincian Custom">
                        </td>
                        <td><input type="number" name="details[${rowIdx}][nominal]" class="form-control" required></td>
                        <td><input type="text" name="details[${rowIdx}][keterangan]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash"></i></button></td>
                    </tr>
                `);

                rowIdx++;
            });

            $('#detailTable').on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });

            $('#detailTable').on('change', '.outcome-select', function() {
                let selected = $(this).val();
                let customInput = $(this).closest('td').find('.custom-input');
                let dropdown = $(this);

                if (selected === 'custom') {
                    dropdown.addClass('d-none');
                    customInput.removeClass('d-none');
                    customInput.prop('required', true);
                    customInput.focus();
                } else {
                    customInput.addClass('d-none');
                    customInput.prop('required', false);
                    customInput.val('');
                }
            });

            $('.outcome-select').each(function() {
                if ($(this).find('option:selected').val() === 'custom') {
                    $(this).addClass('d-none');
                    let customInput = $(this).closest('td').find('.custom-input');
                    customInput.removeClass('d-none');
                    customInput.prop('required', true);
                }
            });
        });
    </script>
@endpush

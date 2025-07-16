@extends('layouts.cetak')

@section('title', $title)

@section('content')
    @php
        $no = 1;
        $totalNominal = 0;
    @endphp

    {{-- data pemasukan --}}
    <h3 class="text-center">
        LAPORAN PENERIMAAN <br>
        DONATUR OPRASIONAL (DOOM) <br>
        YAYASAN AT TAQWA PIK
    </h3>

    <table id="dat">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Nama Donatur</th>
                <th class="text-center">Nominal (Rp)</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $doom)
                @php
                    $totalNominal += (int) $doom->nominal;
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($doom->tanggal)->format('d M') }}</td>
                    <td>{{ $doom->nama_donatur }}</td>
                    <td class="text-right">{{ number_format($doom->nominal, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $doom->bayar_id == 1 ? 'Tunai' : 'Transfer' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL</th>
                <th class="text-right">{{ number_format($totalNominal, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
@endsection

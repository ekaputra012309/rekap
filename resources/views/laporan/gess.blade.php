@extends('layouts.cetak')

@section('title', $title)

@section('content')
    @php
        $no = 1;
        $totalKaleng = 0;
        $totalNominal = 0;
    @endphp

    {{-- data pemasukan --}}
    <h3 class="text-center">
        LAPORAN PENERIMAAN <br>
        GERAKAN SEDEKAH SERIBU SEHARI (GESS) <br>
        YAYASAN AT TAQWA PIK
    </h3>

    <table id="dat">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Nama Donatur</th>
                <th class="text-center">Kaleng</th>
                <th class="text-center">Nominal (Rp)</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $gess)
                @php
                    $totalKaleng += (int) $gess->kaleng;
                    $totalNominal += (int) $gess->nominal;
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($gess->tanggal)->format('d M') }}</td>
                    <td>{{ $gess->nama_donatur }}</td>
                    <td class="text-center">{{ $gess->kaleng }}</td>
                    <td class="text-right">{{ number_format($gess->nominal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $gess->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL</th>
                <th class="text-center">{{ $totalKaleng }}</th>
                <th class="text-right">{{ number_format($totalNominal, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
@endsection

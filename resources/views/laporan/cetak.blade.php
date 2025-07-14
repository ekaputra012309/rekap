<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        html,
        body {
            font-family: sans-serif;
            font-size: 12px;
            padding-top: 150px;
            padding-bottom: 50px;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100px;
            text-align: center;
        }

        .pagenum:before {
            content: counter(page);
        }

        table#dat {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table#kop {
            border: none !important;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        h2,
        p {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <table id="kop">
            <tr>
                <td style="width: 60px; border:none">
                    <img src="{{ public_path('img/logo dkm.png') }}" alt="Logo" width="80">
                </td>
                <td style="text-align: center; border: none">
                    <h1 style="margin: 0;">Masjid At-Taqwa</h1>
                    <p style="margin: 0; font-size: 14px">
                        Jl. Raya Penggilingan Komplek Perkampungan Industri Kecil (PIK) Blok E Rt 09 Rw 10 Penggilingan
                        Cakung Jakarta Timur.</p>
                </td>
            </tr>
        </table>
        <hr>
        <h2>Laporan Data Periode: {{ $start }} - {{ $end }}</h2>
    </div>

    @php
        $totalPerDay = 0;
    @endphp

    {{-- data pemasukan --}}
    <h3>Data Pemasukan</h3>
    <table id="dat">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px">No</th>
                <th class="text-center">Rincian</th>
                <th class="text-right">Jumlah (Rp)</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($datapemasukan as $formattedTanggal => $headers)
                {{-- Group Header per Day --}}
                <tr>
                    <td colspan="4"><strong>Tanggal: {{ $formattedTanggal }}</strong></td>
                </tr>

                @foreach ($headers as $header)
                    @foreach ($header->details as $detail)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $detail->income->nama_list_in }}</td>
                            @php
                                $nominal = $detail->nominal;
                                $totalPerDay += $nominal;
                            @endphp
                            <td class="text-right">
                                {{ fmod($nominal, 1) == 0 ? number_format($nominal, 0, ',', '.') : number_format($nominal, 2, ',', '.') }}
                            </td>
                            <th></th>
                        </tr>
                    @endforeach
                @endforeach

                {{-- Total for the Day --}}
                <tr>
                    <td colspan="3" class="text-right"><strong>Total {{ $formattedTanggal }}</strong></td>

                    <td class="text-right">
                        <strong>
                            {{ number_format($totalPerDay, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            @endforeach
            {{-- infaq dan lain-lain --}}
            @php
                $gdg = 0;
                $totalPerDayM = 0;
                $totalLainM = 0;
                $gdg = $totalGess + $totalGib + $totalDoom;
            @endphp
            <tr>
                <td colspan="4" class="text-center"><strong style="text-transform: uppercase">Infaq dan
                        lain-lain</strong></td>
            </tr>
            {{-- gib, doom, gess --}}
            <tr>
                <td></td>
                <td>Gess</td>
                <td class="text-right">
                    {{ fmod($totalGess, 1) == 0 ? number_format($totalGess, 0, ',', '.') : number_format($totalGess, 2, ',', '.') }}
                </td>
                <th></th>
            </tr>
            <tr>
                <td></td>
                <td>GIB</td>
                <td class="text-right">
                    {{ fmod($totalGib, 1) == 0 ? number_format($totalGib, 0, ',', '.') : number_format($totalGib, 2, ',', '.') }}
                </td>
                <th></th>
            </tr>
            <tr>
                <td></td>
                <td>Doom</td>
                <td class="text-right">
                    {{ fmod($totalDoom, 1) == 0 ? number_format($totalDoom, 0, ',', '.') : number_format($totalDoom, 2, ',', '.') }}
                </td>
                <th></th>
            </tr>
            @foreach ($datapemasukanlain as $formattedTanggal => $headers)
                @foreach ($headers as $header)
                    @foreach ($header->details as $detail)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $detail->custom_rincian }}</td>
                            @php
                                $nominal = $detail->nominal;
                                $totalPerDayM += $nominal;
                            @endphp
                            <td class="text-right">
                                {{ fmod($nominal, 1) == 0 ? number_format($nominal, 0, ',', '.') : number_format($nominal, 2, ',', '.') }}
                            </td>
                            <th></th>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            {{-- Total for the Day --}}
            @php $totalLainM = $totalPerDayM + $gdg; @endphp
            <tr>
                <td colspan="3" class="text-right"><strong>Total Lain-lain</strong></td>

                <td class="text-right">
                    <strong>
                        {{ number_format($totalLainM, 0, ',', '.') }}
                    </strong>
                </td>
            </tr>
        </tbody>
        <tfoot>
            @php
                $a = $datapemasukan->flatten()->flatMap->details->sum('nominal');
                $b = $datapemasukanlain->flatten()->flatMap->details->sum('nominal');
                $grandTotal = $a + $b + $gdg;
            @endphp

            <tr>
                <td colspan="3" class="text-right"><strong>Total Seluruh Pemasukan</strong></td>
                <td class="text-right">
                    <strong>{{ number_format($grandTotal, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- data pengeluaran --}}
    <h3>Data Pengeluaran</h3>
    <table id="dat">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px">No</th>
                <th class="text-center">Rincian</th>
                <th class="text-right">Jumlah (Rp)</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($datapengeluaran as $formattedTanggal => $headers)
                {{-- Group Header per Day --}}
                <tr>
                    <td colspan="4"><strong>Tanggal: {{ $formattedTanggal }}</strong></td>
                </tr>

                @foreach ($headers as $header)
                    @foreach ($header->details as $detail)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $detail->outcome->nama_list_out ?? 'tes' }}</td>
                            @php
                                $nominal = $detail->nominal;
                                $totalPerDay += $nominal;
                            @endphp
                            <td class="text-right">
                                {{ fmod($nominal, 1) == 0 ? number_format($nominal, 0, ',', '.') : number_format($nominal, 2, ',', '.') }}
                            </td>
                            <th></th>
                        </tr>
                    @endforeach
                @endforeach

                {{-- Total for the Day --}}
                <tr>
                    <td colspan="3" class="text-right"><strong>Total {{ $formattedTanggal }}</strong></td>

                    <td class="text-right">
                        <strong>
                            {{ number_format($totalPerDay, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            @endforeach
            {{-- infaq dan lain-lain --}}
            <tr>
                <td colspan="4" class="text-center"><strong style="text-transform: uppercase">Lain-lain</strong></td>
            </tr>

            @foreach ($datapengeluaranlain as $formattedTanggal => $headers)
                @foreach ($headers as $header)
                    @foreach ($header->details as $detail)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $detail->custom_rincian }}</td>
                            @php
                                $nominal = $detail->nominal;
                                $totalPerDay += $nominal;
                            @endphp
                            <td class="text-right">
                                {{ fmod($nominal, 1) == 0 ? number_format($nominal, 0, ',', '.') : number_format($nominal, 2, ',', '.') }}
                            </td>
                            <th></th>
                        </tr>
                    @endforeach
                @endforeach

                {{-- Total for the Day --}}
                <tr>
                    <td colspan="3" class="text-right"><strong>Total </strong></td>

                    <td class="text-right">
                        <strong>
                            {{ number_format($totalPerDay, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                $c = $datapengeluaran->flatten()->flatMap->details->sum('nominal');
                $d = $datapengeluaranlain->flatten()->flatMap->details->sum('nominal');
                $grandTotal = $c + $d;
                $saldoAkhir = $saldoawal + $a + $b - $grandTotal;
            @endphp

            <tr>
                <td colspan="3" class="text-right"><strong>Total Seluruh Pengeluaran</strong></td>
                <td class="text-right">
                    <strong>{{ number_format($grandTotal, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    @php
        $saldoAwalValue = $saldoawal ?? 0;
        $totalMasuk = $a + $b + $gdg;
        $totalKeluar = $c + $d;
        $saldoAkhir = $saldoAwalValue + $totalMasuk - $totalKeluar;

        function formatCurrency($value)
        {
            return $value < 0
                ? '(' . number_format(abs($value), 0, ',', '.') . ')'
                : number_format($value, 0, ',', '.');
        }
    @endphp

    <br><br>
    <table style="width: 50%; border-collapse: collapse; margin-top: 20px;" border="1">
        <tr>
            <th style="padding: 6px;">Keterangan</th>
            <th style="padding: 6px; text-align: right;">Jumlah (Rp)</th>
        </tr>
        <tr>
            <td style="padding: 6px;">Saldo Awal</td>
            <td style="padding: 6px; text-align: right;">
                {{ formatCurrency($saldoAwalValue) }}
            </td>
        </tr>
        <tr>
            <td style="padding: 6px;">Total Pemasukan</td>
            <td style="padding: 6px; text-align: right;">
                {{ formatCurrency($totalMasuk) }}
            </td>
        </tr>
        <tr>
            <td style="padding: 6px;">Total Pengeluaran</td>
            <td style="padding: 6px; text-align: right;">
                {{ formatCurrency($totalKeluar) }}
            </td>
        </tr>
        <tr>
            <th style="padding: 6px;">Saldo Akhir</th>
            <th style="padding: 6px; text-align: right;">
                {{ formatCurrency($saldoAkhir) }}
            </th>
        </tr>
    </table>


</body>

</html>

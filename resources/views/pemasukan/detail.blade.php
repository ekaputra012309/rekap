<h5>Tanggal: {{ \Carbon\Carbon::parse($pemasukan->tanggal)->translatedFormat('l, d F Y') }}</h5>
<h5>Total: Rp
    {{ fmod($pemasukan->total, 1) == 0 ? number_format($pemasukan->total, 0, ',', '.') : number_format($pemasukan->total, 2, ',', '.') }}
</h5>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Rincian</th>
            <th>Nominal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemasukan->details as $detail)
            <tr>
                <td>{{ $detail->income_id ? $detail->income->nama_list_in : $detail->custom_rincian }}</td>
                <td class="d-flex justify-content-between">
                    <span>Rp</span>
                    <span>{{ fmod($detail->nominal, 1) == 0 ? number_format($detail->nominal, 0, ',', '.') : number_format($detail->nominal, 2, ',', '.') }}</span>
                </td>
                <td>{{ $detail->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

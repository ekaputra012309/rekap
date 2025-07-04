<h5>Tanggal: {{ \Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('l, d F Y') }}</h5>
<h5>Total: Rp
    {{ fmod($pengeluaran->total, 1) == 0 ? number_format($pengeluaran->total, 0, ',', '.') : number_format($pengeluaran->total, 2, ',', '.') }}
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
        @foreach ($pengeluaran->details as $detail)
            <tr>
                <td>{{ $detail->outcome_id ? $detail->outcome->nama_list_out : $detail->custom_rincian }}</td>
                <td class="d-flex justify-content-between">
                    <span>Rp</span>
                    <span>{{ fmod($detail->nominal, 1) == 0 ? number_format($detail->nominal, 0, ',', '.') : number_format($detail->nominal, 2, ',', '.') }}</span>
                </td>
                <td>{{ $detail->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

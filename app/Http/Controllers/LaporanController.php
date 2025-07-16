<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Gib;
use App\Models\Doom;
use App\Models\Gess;
use App\Models\PemasukanHeader;
use App\Models\PengeluaranHeader;
use App\Models\PemasukanDetail;
use App\Models\PengeluaranDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Laporan',
        );
        return view('laporan.index', $data);
    }

    public function generate(Request $request)
    {
        $type = $request->type ?? 'laporan';

        $start = $request->start 
            ? Carbon::parse($request->start)->startOfDay()->toDateTimeString()
            : now()->startOfMonth()->startOfDay()->toDateTimeString();

        $end = $request->end 
            ? Carbon::parse($request->end)->endOfDay()->toDateTimeString()
            : now()->endOfDay()->toDateTimeString();

        // Handle GIB report
        if ($type === 'gib') {
            $data = [
                'title' => 'Laporan GIB',
                'items' => Gib::whereBetween('tanggal', [$start, $end])->orderBy('tanggal')->get(),
                'start' => Carbon::parse($start)->format('d M Y'),
                'end' => Carbon::parse($end)->format('d M Y'),
            ];
            return Pdf::loadView('laporan.gib', $data)->stream("laporan_gib_{$start}_to_{$end}.pdf");
        }

        // Handle GESS report
        if ($type === 'gess') {
            $data = [
                'title' => 'Laporan GESS',
                'items' => Gess::whereBetween('tanggal', [$start, $end])->orderBy('tanggal')->get(),
                'start' => Carbon::parse($start)->format('d M Y'),
                'end' => Carbon::parse($end)->format('d M Y'),
            ];
            return Pdf::loadView('laporan.gess', $data)->stream("laporan_gess_{$start}_to_{$end}.pdf");
        }

        // Handle DOOM report
        if ($type === 'doom') {
            $data = [
                'title' => 'Laporan DOOM',
                'items' => Doom::whereBetween('tanggal', [$start, $end])->orderBy('tanggal')->get(),
                'start' => Carbon::parse($start)->format('d M Y'),
                'end' => Carbon::parse($end)->format('d M Y'),
            ];
            return Pdf::loadView('laporan.doom', $data)->stream("laporan_doom_{$start}_to_{$end}.pdf");
        }

        // Default: laporan umum
        $datapemasukan = PemasukanHeader::with('details')
            ->whereBetween('tanggal', [$start, $end])
            ->whereHas('details', fn ($q) => $q->whereNotNull('income_id'))
            ->orderBy('tanggal')->get()->groupBy('tanggal');

        $datapemasukanlain = PemasukanHeader::with('details')
            ->whereBetween('tanggal', [$start, $end])
            ->whereHas('details', fn ($q) => $q->whereNull('income_id'))
            ->orderBy('tanggal')->get()->groupBy('tanggal');

        $datapengeluaran = PengeluaranHeader::with(['details' => fn ($q) => $q->whereNotNull('outcome_id')])
            ->whereBetween('tanggal', [$start, $end])
            ->whereHas('details', fn ($q) => $q->whereNotNull('outcome_id'))
            ->orderBy('tanggal')->get()->groupBy('tanggal');

        $datapengeluaranlain = PengeluaranHeader::with(['details' => fn ($q) => $q->whereNull('outcome_id')])
            ->whereBetween('tanggal', [$start, $end])
            ->whereHas('details', fn ($q) => $q->whereNull('outcome_id'))
            ->orderBy('tanggal')->get()->groupBy('tanggal');

        $totalGib = Gib::whereBetween('tanggal', [$start, $end])->sum('nominal');
        $totalDoom = Doom::whereBetween('tanggal', [$start, $end])->sum('nominal');
        $totalGess = Gess::whereBetween('tanggal', [$start, $end])->sum('nominal');

        $formattedPemasukan = $datapemasukan->mapWithKeys(fn ($group, $tanggal) => [
            Carbon::parse($tanggal)->translatedFormat('d M') => $group
        ]);

        $formattedPemasukanLain = $datapemasukanlain->mapWithKeys(fn ($group, $tanggal) => [
            Carbon::parse($tanggal)->translatedFormat('d M') => $group
        ]);

        $formattedPengeluaran = $datapengeluaran->mapWithKeys(fn ($group, $tanggal) => [
            Carbon::parse($tanggal)->translatedFormat('d M') => $group
        ]);

        $formattedPengeluaranLain = $datapengeluaranlain->mapWithKeys(fn ($group, $tanggal) => [
            Carbon::parse($tanggal)->translatedFormat('d M') => $group
        ]);

        $startCarbon = Carbon::parse($start);
        $initialSaldo = Saldo::first()?->saldo_awal ?? 0;

        $totalMasukBefore = PemasukanDetail::whereHas('header', fn ($q) => $q->where('tanggal', '<', $startCarbon))
            ->sum('nominal');
        $totalGibBefore = Gib::where('tanggal', '<', $startCarbon)->sum('nominal');
        $totalDoomBefore = Doom::where('tanggal', '<', $startCarbon)->sum('nominal');
        $totalGessBefore = Gess::where('tanggal', '<', $startCarbon)->sum('nominal');
        $totalKeluarBefore = PengeluaranDetail::whereHas('header', fn ($q) => $q->where('tanggal', '<', $startCarbon))
            ->sum('nominal');

        $totalMasukBefore += $totalGibBefore + $totalDoomBefore + $totalGessBefore;
        $saldoAwalValue = $initialSaldo + $totalMasukBefore - $totalKeluarBefore;

        $data = [
            'title' => 'Laporan Umum',
            'start' => Carbon::parse($start)->format('d M Y'),
            'end' => Carbon::parse($end)->format('d M Y'),
            'datapemasukan' => $formattedPemasukan,
            'datapemasukanlain' => $formattedPemasukanLain,
            'datapengeluaran' => $formattedPengeluaran,
            'datapengeluaranlain' => $formattedPengeluaranLain,
            'totalGib' => $totalGib,
            'totalDoom' => $totalDoom,
            'totalGess' => $totalGess,
            'saldoawal' => $saldoAwalValue,
        ];

        return Pdf::loadView('laporan.laporan', $data)
            ->stream("laporan_{$start}_to_{$end}.pdf");
    }
}

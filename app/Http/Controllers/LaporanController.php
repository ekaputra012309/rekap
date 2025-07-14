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
        $start = $request->start 
            ? Carbon::parse($request->start)->startOfDay()->toDateTimeString()
            : now()->startOfMonth()->startOfDay()->toDateTimeString();

        $end = $request->end 
            ? Carbon::parse($request->end)->endOfDay()->toDateTimeString()
            : now()->endOfDay()->toDateTimeString();

        $datapemasukan = PemasukanHeader::with('details')
                            ->whereBetween('tanggal', [$start, $end])
                            ->whereHas('details', function ($q) {
                                $q->whereNotNull('income_id');
                            })
                            ->orderBy('tanggal')
                            ->get()
                            ->groupBy('tanggal'); // Group after fetching

        $datapemasukanlain = PemasukanHeader::with('details')
                            ->whereBetween('tanggal', [$start, $end])
                            ->whereHas('details', function ($q) {
                                $q->whereNull('income_id');
                            })
                            ->orderBy('tanggal')
                            ->get()
                            ->groupBy('tanggal');

        $datapengeluaran = PengeluaranHeader::with(['details' => function ($q2) {
                                $q2->whereNotNull('outcome_id');
                            }])
                            ->whereBetween('tanggal', [$start, $end])
                            ->whereHas('details', function ($q2) {
                                $q2->whereNotNull('outcome_id');
                            })
                            ->orderBy('tanggal')
                            ->get()
                            ->groupBy('tanggal');                        

        $datapengeluaranlain = PengeluaranHeader::with(['details' => function ($q2) {
                                $q2->whereNull('outcome_id');
                            }])
                            ->whereBetween('tanggal', [$start, $end])
                            ->whereHas('details', function ($q2) {
                                $q2->whereNull('outcome_id');
                            })
                            ->orderBy('tanggal')
                            ->get()
                            ->groupBy('tanggal');

        $totalGib = Gib::whereBetween('tanggal', [$start, $end])->sum('nominal');
        $totalDoom = Doom::whereBetween('tanggal', [$start, $end])->sum('nominal');
        $totalGess = Gess::whereBetween('tanggal', [$start, $end])->sum('nominal');

        // Optional: format tanggal inside blade, or here if you must
        // Example of formatting tanggal key if needed:
        $formattedPemasukan = $datapemasukan->mapWithKeys(function ($group, $tanggal) {
            return [Carbon::parse($tanggal)->translatedFormat('d M') => $group];
        });

        $formattedPemasukanLain = $datapemasukanlain->mapWithKeys(function ($group, $tanggal) {
            return [Carbon::parse($tanggal)->translatedFormat('d M') => $group];
        });

        $formattedPengeluaran = $datapengeluaran->mapWithKeys(function ($group, $tanggal) {
            return [Carbon::parse($tanggal)->translatedFormat('d M') => $group];
        });

        $formattedPengeluaranLain = $datapengeluaranlain->mapWithKeys(function ($group, $tanggal) {
            return [Carbon::parse($tanggal)->translatedFormat('d M') => $group];
        });
        
        // Convert $start to Carbon for consistent comparison
        $startCarbon = Carbon::parse($start);

        // Get initial saldo if any
        $initialSaldo = Saldo::first()?->saldo_awal ?? 0;

        // Total pemasukan before start date
        $totalMasukBefore = PemasukanDetail::whereHas('header', function ($q) use ($startCarbon) {
            $q->where('tanggal', '<', $startCarbon);
        })->sum('nominal');

        // Include gib, doom, gess before start
        $totalGibBefore = Gib::where('tanggal', '<', $startCarbon)->sum('nominal');
        $totalDoomBefore = Doom::where('tanggal', '<', $startCarbon)->sum('nominal');
        $totalGessBefore = Gess::where('tanggal', '<', $startCarbon)->sum('nominal');

        // Total pengeluaran before start date
        $totalKeluarBefore = PengeluaranDetail::whereHas('header', function ($q) use ($startCarbon) {
            $q->where('tanggal', '<', $startCarbon);
        })->sum('nominal');

        // Add all to pemasukan before
        $totalMasukBefore += $totalGibBefore + $totalDoomBefore + $totalGessBefore;

        // Final saldo awal calculation
        $saldoAwalValue = $initialSaldo + $totalMasukBefore - $totalKeluarBefore;

        $dat2 = [
            'tgl' => $startCarbon,
            'si' => $initialSaldo,
            'tm' => $totalMasukBefore,
            'tk' => $totalKeluarBefore,
            'sa' => $saldoAwalValue,
        ];
        // dd($dat2);
        $data = [
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

        $pdf = Pdf::loadView('laporan.cetak', $data);
        return $pdf->stream("laporan_{$start}_to_{$end}.pdf");
    }
}

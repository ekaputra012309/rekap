<?php

namespace App\Http\Controllers;

use App\Models\Outcomes;
use App\Models\PengeluaranHeader;
use App\Models\PengeluaranDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Pengeluaran',
        );
        return view('pengeluaran.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = PengeluaranHeader::with('details')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })
                ->editColumn('tanggal', function ($row) {
                    // Format: Jumat, 07 Juni 2025
                    return Carbon::parse($row->tanggal)->translatedFormat('l, d F Y');
                })
                ->editColumn('total', function ($row) {
                    if (fmod($row->total, 1) == 0) {
                        return 'Rp ' . number_format($row->total, 0, ',', '.');
                    } else {
                        return 'Rp ' . number_format($row->total, 2, ',', '.');
                    }
                })
                ->editColumn('oleh', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('action', function ($row) {
                    return '<button type="button" class="btn btn-secondary btn-sm showDetail" data-id="' . $row->id . '"><i class="fas fa-search"></i> Detail</button>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }

        abort(403);
    }

    public function create()
    {
        $data = array(
            'title' => 'Pengeluaran',
            'outcomes' => Outcomes::all(),
            'datenow' => \Carbon\Carbon::now()->format('Y-m-d'),
        );
        return view('pengeluaran.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.outcome_id' => 'required',
            'details.*.nominal' => 'required|numeric|min:0',
            'details.*.keterangan' => 'nullable|string',
        ]);

        foreach ($request->details as $index => $detail) {
            if ($detail['outcome_id'] === 'custom' && empty($detail['custom_rincian'])) {
                return redirect()->back()->withErrors(['details.' . $index . '.custom_rincian' => 'Rincian custom wajib diisi jika memilih Custom.'])->withInput();
            }
        }

        $header = PengeluaranHeader::create([
            'tanggal' => $request->tanggal,
            'user_id' => $request->user_id,
            'total' => 0, // Temporary
        ]);

        $total = 0;

        foreach ($request->details as $detail) {
            $header->details()->create([
                'outcome_id' => $detail['outcome_id'] !== 'custom' ? $detail['outcome_id'] : null,
                'custom_rincian' => $detail['outcome_id'] === 'custom' ? $detail['custom_rincian'] : null,
                'nominal' => $detail['nominal'],
                'keterangan' => $detail['keterangan'] ?? null,
            ]);

            $total += $detail['nominal'];
        }

        $header->update(['total' => $total]);

        return redirect()->route('pengeluaran.index')->with('toast', [
            'type' => 'success',
            'message' => 'pengeluaran berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        $pengeluaran = PengeluaranHeader::with('details.outcome')->findOrFail($id);

        return view('pengeluaran.detail', compact('pengeluaran'));
    }

    public function edit(PengeluaranHeader $pengeluaran)
    {
        $data = array(
            'title' => 'Pengeluaran',
            'pengeluaran' => $pengeluaran,
            'outcomes' => Outcomes::all(),
        );
        return view('pengeluaran.edit', $data);
    }

    public function update(Request $request, PengeluaranHeader $pengeluaran)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.nominal' => 'required|numeric|min:0',
        ]);

        $pengeluaran->update([
            'tanggal' => $request->tanggal,
        ]);

        // Prepare detail IDs for sync
        $existingIds = $pengeluaran->details->pluck('id')->toArray();
        $incomingIds = collect($request->details)->pluck('id')->filter()->toArray();
        $deleteIds = array_diff($existingIds, $incomingIds);

        // Delete removed rows
        if (count($deleteIds)) {
            $pengeluaran->details()->whereIn('id', $deleteIds)->delete();
        }

        $total = 0;

        foreach ($request->details as $detail) {
            if (isset($detail['id'])) {
                // Update existing detail
                $item = $pengeluaran->details()->find($detail['id']);
                if ($item) {
                    $item->update([
                        'outcome_id' => isset($detail['outcome_id']) && $detail['outcome_id'] != 'custom' ? $detail['outcome_id'] : null,
                        'custom_rincian' => (isset($detail['outcome_id']) && $detail['outcome_id'] == 'custom') ? $detail['custom_rincian'] : null,
                        'nominal' => $detail['nominal'],
                        'keterangan' => $detail['keterangan'] ?? null,
                    ]);
                }
            } else {
                // Create new detail
                $pengeluaran->details()->create([
                    'outcome_id' => isset($detail['outcome_id']) && $detail['outcome_id'] != 'custom' ? $detail['outcome_id'] : null,
                    'custom_rincian' => (isset($detail['outcome_id']) && $detail['outcome_id'] == 'custom') ? $detail['custom_rincian'] : null,
                    'nominal' => $detail['nominal'],
                    'keterangan' => $detail['keterangan'] ?? null,
                ]);
            }

            $total += $detail['nominal'];
        }

        $pengeluaran->update(['total' => $total]);

        return redirect()->route('pengeluaran.index')->with('toast', [
            'type' => 'success',
            'message' => 'pengeluaran berhasil diupdate.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:pengeluaran_headers,id',
        ]);

        // Delete details first
        PengeluaranDetail::whereIn('pengeluaran_header_id', $ids)->delete();

        // Then delete headers
        PengeluaranHeader::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

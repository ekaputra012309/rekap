<?php

namespace App\Http\Controllers;

use App\Models\Incomes;
use App\Models\PemasukanHeader;
use App\Models\PemasukanDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PemasukanController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Pemasukan',
        );
        return view('pemasukan.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = PemasukanHeader::with('details')->get();

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
            'title' => 'Pemasukan',
            'incomes' => Incomes::all(),
            'datenow' => \Carbon\Carbon::now()->format('Y-m-d'),
        );
        return view('pemasukan.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.income_id' => 'required',
            'details.*.nominal' => 'required|numeric|min:0',
            'details.*.keterangan' => 'nullable|string',
        ]);

        foreach ($request->details as $index => $detail) {
            if ($detail['income_id'] === 'custom' && empty($detail['custom_rincian'])) {
                return redirect()->back()->withErrors(['details.' . $index . '.custom_rincian' => 'Rincian custom wajib diisi jika memilih Custom.'])->withInput();
            }
        }

        $header = PemasukanHeader::create([
            'tanggal' => $request->tanggal,
            'user_id' => $request->user_id,
            'total' => 0, // Temporary
        ]);

        $total = 0;

        foreach ($request->details as $detail) {
            $header->details()->create([
                'income_id' => $detail['income_id'] !== 'custom' ? $detail['income_id'] : null,
                'custom_rincian' => $detail['income_id'] === 'custom' ? $detail['custom_rincian'] : null,
                'nominal' => $detail['nominal'],
                'keterangan' => $detail['keterangan'] ?? null,
            ]);

            $total += $detail['nominal'];
        }

        $header->update(['total' => $total]);

        return redirect()->route('pemasukan.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pemasukan berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        $pemasukan = PemasukanHeader::with('details.income')->findOrFail($id);

        return view('pemasukan.detail', compact('pemasukan'));
    }

    public function edit(PemasukanHeader $pemasukan)
    {
        $data = array(
            'title' => 'Pemasukan',
            'pemasukan' => $pemasukan,
            'incomes' => Incomes::all(),
        );
        return view('pemasukan.edit', $data);
    }

    public function update(Request $request, PemasukanHeader $pemasukan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.nominal' => 'required|numeric|min:0',
        ]);

        $pemasukan->update([
            'tanggal' => $request->tanggal,
        ]);

        // Prepare detail IDs for sync
        $existingIds = $pemasukan->details->pluck('id')->toArray();
        $incomingIds = collect($request->details)->pluck('id')->filter()->toArray();
        $deleteIds = array_diff($existingIds, $incomingIds);

        // Delete removed rows
        if (count($deleteIds)) {
            $pemasukan->details()->whereIn('id', $deleteIds)->delete();
        }

        $total = 0;

        foreach ($request->details as $detail) {
            if (isset($detail['id'])) {
                // Update existing detail
                $item = $pemasukan->details()->find($detail['id']);
                if ($item) {
                    $item->update([
                        'income_id' => isset($detail['income_id']) && $detail['income_id'] != 'custom' ? $detail['income_id'] : null,
                        'custom_rincian' => (isset($detail['income_id']) && $detail['income_id'] == 'custom') ? $detail['custom_rincian'] : null,
                        'nominal' => $detail['nominal'],
                        'keterangan' => $detail['keterangan'] ?? null,
                    ]);
                }
            } else {
                // Create new detail
                $pemasukan->details()->create([
                    'income_id' => isset($detail['income_id']) && $detail['income_id'] != 'custom' ? $detail['income_id'] : null,
                    'custom_rincian' => (isset($detail['income_id']) && $detail['income_id'] == 'custom') ? $detail['custom_rincian'] : null,
                    'nominal' => $detail['nominal'],
                    'keterangan' => $detail['keterangan'] ?? null,
                ]);
            }

            $total += $detail['nominal'];
        }

        $pemasukan->update(['total' => $total]);

        return redirect()->route('pemasukan.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pemasukan berhasil diupdate.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:pemasukan_headers,id',
        ]);

        // Delete details first
        PemasukanDetail::whereIn('pemasukan_header_id', $ids)->delete();

        // Then delete headers
        PemasukanHeader::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

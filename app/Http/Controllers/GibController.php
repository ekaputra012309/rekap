<?php

namespace App\Http\Controllers;

use App\Models\Gib;
use App\Models\Bayar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class GibController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'GIB',
        );
        return view('gib.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Gib::orderBy('tanggal', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="row-checkbox" value="'.$row->id.'">';
                })
                ->editColumn('tanggal', function ($row) {
                    return Carbon::parse($row->tanggal)->translatedFormat('j M Y'); // contoh: 5 Feb 2025
                })
                ->editColumn('nominal', function ($row) {
                    return 'Rp ' . number_format($row->nominal, 0, ',', '.');
                })
                ->addColumn('metode_bayar', function ($row) {
                    return match ($row->bayar_id) {
                        1 => 'Tunai',
                        2 => 'Transfer',
                        default => 'Tidak diketahui',
                    };
                })
                ->rawColumns(['checkbox'])
                ->make(true);
        }

        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bayar = Bayar::all();
        $data = array(
            'title' => 'GIB',
            'datenow' => \Carbon\Carbon::now()->format('Y-m-d'),
            'bayar' => $bayar,
        );
        return view('gib.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([            
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'bayar_id' => 'required|exists:bayars,id',
            'user_id' => 'required|exists:users,id',
        ]);
        
        Gib::create($request->all());
        return redirect('/gib')->with('toast', [
            'type' => 'success', 
            'message' => 'Added gib successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gib $gib)
    {
        $bayar = Bayar::all();
        $data = array(
            'title' => 'GIB',
            'gib' => $gib,
            'bayar' => $bayar,
        );
        return view('gib.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gib $gib)
    {
        $request->validate([            
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'bayar_id' => 'required|exists:bayars,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $gib->update($request->all());
        return redirect('/gib')->with('toast', [
            'type' => 'success', 
            'message' => 'Update gib successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Gib::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

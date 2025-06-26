<?php

namespace App\Http\Controllers;

use App\Models\Doom;
use App\Models\Bayar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Doom',
        );
        return view('doom.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Doom::orderBy('tanggal', 'desc');

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
            'title' => 'Doom',
            'datenow' => \Carbon\Carbon::now()->format('Y-m-d'),
            'bayar' => $bayar,
        );
        return view('doom.add', $data);
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
        
        Doom::create($request->all());
        return redirect('/doom')->with('toast', [
            'type' => 'success', 
            'message' => 'Added doom successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doom $doom)
    {
        $bayar = Bayar::all();
        $data = array(
            'title' => 'Doom',
            'doom' => $doom,
            'bayar' => $bayar,
        );
        return view('doom.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doom $doom)
    {
        $request->validate([            
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'bayar_id' => 'required|exists:bayars,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $doom->update($request->all());
        return redirect('/doom')->with('toast', [
            'type' => 'success', 
            'message' => 'Update doom successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Doom::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

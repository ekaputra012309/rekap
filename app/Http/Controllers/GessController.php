<?php

namespace App\Http\Controllers;

use App\Models\Gess;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class GessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'GESS',
        );
        return view('gess.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Gess::orderBy('tanggal', 'desc');

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
        $data = array(
            'title' => 'GESS',
            'datenow' => \Carbon\Carbon::now()->format('Y-m-d'),
        );
        return view('gess.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([            
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|string|max:255',
            'kaleng' => 'required|integer|min:1',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        gess::create($request->all());
        return redirect('/gess')->with('toast', [
            'type' => 'success', 
            'message' => 'Added gess successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gess $gess)
    {
        $data = array(
            'title' => 'GESS',
            'gess' => $gess,
        );
        return view('gess.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gess $gess)
    {
        $request->validate([            
            'tanggal' => 'required|date',
            'nama_donatur' => 'required|string|max:255',
            'kaleng' => 'required|integer|min:1',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $gess->update($request->all());
        return redirect('/gess')->with('toast', [
            'type' => 'success', 
            'message' => 'Update gess successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Gess::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

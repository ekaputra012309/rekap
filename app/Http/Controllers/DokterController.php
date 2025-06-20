<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Dokter',
        );
        return view('dokter.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Dokter::with('poli');
            
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="row-checkbox" value="'.$row->id.'">';
                })
                ->filterColumn('poli.nama_poli', function($query, $keyword) {
                    $query->whereHas('poli', function($q) use ($keyword) {
                        $q->where('nama_poli', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('poli.nama_poli', function ($row) {
                    return $row->poli->nama_poli ?? '-';
                })
                ->rawColumns(['checkbox'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $poli = Poliklinik::all();
        $data = array(
            'title' => 'Dokter',
            'datapoli' => $poli,
        );
        return view('dokter.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'poli_id' => 'required|exists:polikliniks,id',
            'keterangan' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Dokter::create($request->all());
        return redirect('/dokter')->with('toast', [
            'type' => 'success', 
            'message' => 'Added dokter successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        $poli = Poliklinik::all();
        $data = array(
            'title' => 'Dokter',
            'datapoli' => $poli,
            'dokter' => $dokter,
        );
        return view('dokter.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'poli_id' => 'required|exists:polikliniks,id',
            'keterangan' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $dokter->update($request->all());
        return redirect('/dokter')->with('toast', [
            'type' => 'success', 
            'message' => 'Update dokter successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Dokter::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

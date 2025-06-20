<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Poliklinik',
        );
        return view('poliklinik.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Poliklinik::all();
            
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="row-checkbox" value="'.$row->id.'">';
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
        $data = array(
            'title' => 'Poliklinik',
        );
        return view('poliklinik.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_poli' => 'required|string|max:255',
            'nama_poli' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Poliklinik::create($request->all());
        return redirect('/poliklinik')->with('toast', [
            'type' => 'success', 
            'message' => 'Added poliklinik successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poliklinik $poliklinik)
    {
        $data = array(
            'title' => 'Poliklinik',
            'datapoli' => $poliklinik,
        );
        return view('poliklinik.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poliklinik $poliklinik)
    {
        $request->validate([
            'kode_poli' => 'required|string|max:255',
            'nama_poli' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $poliklinik->update($request->all());
        return redirect('/poliklinik')->with('toast', [
            'type' => 'success', 
            'message' => 'Update poliklinik successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Poliklinik::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

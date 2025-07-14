<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaldoController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Saldo Awal',
        );
        return view('saldo.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Saldo::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="row-checkbox" value="'.$row->id.'">';
                })
                ->editColumn('saldo_awal', function ($row) {
                    $value = abs($row->saldo_awal);
                    $formatted = number_format($value, 0, ',', '.');
                    
                    return $row->saldo_awal < 0 ? "Rp ({$formatted})" : "Rp {$formatted}";
                })                
                ->rawColumns(['checkbox'])
                ->make(true);
        }

        abort(403);
    }

    public function edit(Saldo $saldo)
    {
        $data = array(
            'title' => 'Saldo Awal',
            'saldo' => $saldo,
        );
        return view('saldo.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saldo $saldo)
    {
        $request->validate([
            'saldo_awal' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);
        
        $saldo->update($request->all());
        return redirect('/saldo')->with('toast', [
            'type' => 'success', 
            'message' => 'Update saldo successfully.',
        ]);
    }
}

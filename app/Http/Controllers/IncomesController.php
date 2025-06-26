<?php

namespace App\Http\Controllers;

use App\Models\Incomes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'List Incomes',
        );
        return view('incomes.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Incomes::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="row-checkbox" value="'.$row->id.'">';
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
            'title' => 'List Incomes',
        );
        return view('incomes.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([            
            'nama_list_in' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Incomes::create($request->all());
        return redirect('/income')->with('toast', [
            'type' => 'success', 
            'message' => 'Added incomes successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incomes $income)
    {
        $data = array(
            'title' => 'List Incomes',
            'income' => $income,
        );
        return view('incomes.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incomes $income)
    {
        $request->validate([            
            'nama_list_in' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $income->update($request->all());
        return redirect('/income')->with('toast', [
            'type' => 'success', 
            'message' => 'Update incomes successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Incomes::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

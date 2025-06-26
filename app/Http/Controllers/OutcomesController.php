<?php

namespace App\Http\Controllers;

use App\Models\Outcomes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OutcomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'List outcomes',
        );
        return view('outcomes.index', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Outcomes::query();

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
            'title' => 'List outcomes',
        );
        return view('outcomes.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([            
            'nama_list_out' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        outcomes::create($request->all());
        return redirect('/outcome')->with('toast', [
            'type' => 'success', 
            'message' => 'Added outcomes successfully.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outcomes $outcome)
    {
        $data = array(
            'title' => 'List outcomes',
            'outcome' => $outcome,
        );
        return view('outcomes.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outcomes $outcome)
    {
        $request->validate([            
            'nama_list_out' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $outcome->update($request->all());
        return redirect('/outcome')->with('toast', [
            'type' => 'success', 
            'message' => 'Update outcomes successfully.',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Outcomes::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}

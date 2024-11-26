<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
	{
	    if(request()->ajax()) {
            $data = Unit::orderBy('id', 'desc');
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a onClick="editFunc(' . $row->id . ')" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a> 
					<a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
	    return view('unit.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
            'unit_name' => 'required',
        ]);

	    $id = $request->id;

	    $unit   =   Unit::updateOrCreate(
	    	        [
	    	         'id' => $id
	    	        ],
	                [
	                'unit_code' => 'UT' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5),
	                'unit_name' => $request->unit_name
	                ]);

	    return Response()->json($unit);

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\blog  $blog
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{
	    $where = array('id' => $request->id);
	    $unit  = Unit::where($where)->first();

	    return Response()->json($unit);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\blog  $blog
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
	    $unit = Unit::where('id',$request->id)->delete();

	    return Response()->json($unit);
	}
}

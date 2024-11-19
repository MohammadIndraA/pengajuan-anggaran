<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
	{
	    if(request()->ajax()) {
            $data = Departement::query();
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a onClick="editFunc(' . $row->id . ')" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a> 
					<a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
	    return view('departement.index');
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
            'departement_name' => 'required',
        ]);

	    $id = $request->id;

	    $departement   =   Departement::updateOrCreate(
	    	        [
	    	         'id' => $id
	    	        ],
	                [
	                'departement_code' => 'DT' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5),
	                'departement_name' => $request->departement_name
	                ]);

	    return Response()->json($departement);

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
	    $departement  = Departement::where($where)->first();

	    return Response()->json($departement);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\blog  $blog
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
	    $departement = Departement::where('id',$request->id)->delete();

	    return Response()->json($departement);
	}
}

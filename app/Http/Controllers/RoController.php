<?php

namespace App\Http\Controllers;

use App\Models\Ro;
use Illuminate\Http\Request;

class RoController extends Controller
{
    public function index()
	{
	    if(request()->ajax()) {
            $data = Ro::orderBy('id', 'desc');
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a onClick="editFunc(' . $row->id . ')" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a> 
					<a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
	    return view('ro.index');
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
            'ro_name' => 'required',
        ]);

	    $id = $request->id;

	    $ro   =   Ro::updateOrCreate(
	    	        [
	    	         'id' => $id
	    	        ],
	                [
	                'ro_code' => 'RO' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5),
	                'ro_name' => $request->ro_name
	                ]);

	    return Response()->json($ro);

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
	    $ro  = Ro::where($where)->first();

	    return Response()->json($ro);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\blog  $blog
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
	    $ro = Ro::where('id',$request->id)->delete();

	    return Response()->json($ro);
	}
}

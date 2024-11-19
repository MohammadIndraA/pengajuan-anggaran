<?php

namespace App\Http\Controllers;

use App\Models\Kro;
use Illuminate\Http\Request;

class KroController extends Controller
{
    public function index()
	{
	    if(request()->ajax()) {
            $data = Kro::query();
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a onClick="editFunc(' . $row->id . ')" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a> 
					<a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
	    return view('kro.index');
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
            'kro_name' => 'required',
        ]);

	    $id = $request->id;

	    $kro   =   Kro::updateOrCreate(
	    	        [
	    	         'id' => $id
	    	        ],
	                [
	                'kro_code' => 'KM' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5),
	                'kro_name' => $request->kro_name
	                ]);

	    return Response()->json($kro);

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
	    $kro  = Kro::where($where)->first();

	    return Response()->json($kro);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\blog  $blog
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
	    $kro = Kro::where('id',$request->id)->delete();

	    return Response()->json($kro);
	}
}

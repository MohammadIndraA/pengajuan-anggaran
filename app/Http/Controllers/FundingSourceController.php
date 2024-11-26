<?php

namespace App\Http\Controllers;

use App\Models\FundingSource;
use Illuminate\Http\Request;

class FundingSourceController extends Controller
{
    public function index()
	{
	    if(request()->ajax()) {
            $data = FundingSource::orderBy('id', 'desc');
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a onClick="editFunc(' . $row->id . ')" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a> 
					<a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
	    return view('funding_source.index');
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
            'funding_source_name' => 'required',
        ]);

	    $id = $request->id;

	    $funding_source   =   FundingSource::updateOrCreate(
	    	        [
	    	         'id' => $id
	    	        ],
	                [
	                'funding_source_code' => 'FS' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5),
	                'funding_source_name' => $request->funding_source_name
	                ]);

	    return Response()->json($funding_source);

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
	    $funding_source  = FundingSource::where($where)->first();

	    return Response()->json($funding_source);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\blog  $blog
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
	    $funding_source = FundingSource::where('id',$request->id)->delete();

	    return Response()->json($funding_source);
	}
}

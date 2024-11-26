<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Province;
use App\Models\RegencyCity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index(Request $request) {

        if(request()->ajax()) {
            if (Auth::user()->role === "province") {
                $data = User::with(['province', 'regency_city'])->where('role', "regency")
                            ->where('province_id', Auth::user()->province_id)                
                            ->orderBy('id', 'desc');
            }
            if (Auth::user()->role === "departement") {
                if($request->is('manage-account-province')) {
                    $data = User::with(['province', 'regency_city'])->where('role', "province")->orderBy('id', 'desc');
                }elseif ($request->is('manage-account-regency')) {
                    $data = User::with(['province', 'regency_city'])->where('role', "regency")->orderBy('id', 'desc');
                }
            }
            if ( Auth::user()->role === "pusat") {
                if($request->is('manage-account-province')) {
                    $data = User::with(['province', 'regency_city'])->where('role', "province")->orderBy('id', 'desc');
                }elseif ($request->is('manage-account-regency')) {
                    $data = User::with(['province', 'regency_city'])->where('role', "regency")->orderBy('id', 'desc');
                }elseif ($request->is('manage-account-departement')) {
                    $data = User::with(['province', 'regency_city'])->where('role', "departement")->orderBy('id', 'desc');
            }
        }
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a href="'. url('/user-edit', $row->id) . '" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a>
                    <a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
        return view('user.index');
    }

    public function create(Request $request){
       $type = $request->type;
        $provinces = Province::all();
        $regency_cities = RegencyCity::all();
        $departement = Departement::all();
        return view('user.add', compact('provinces','regency_cities', 'departement', 'type'));
    }


    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|min:5',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'role' => 'required|min:5',
            'region' => 'required|min:5',
            'province_id' => 'required',
        ]);
        // Tambahkan validasi tambahan jika role bukan "province"
        if ($request->role !== "province") {
            $additionalData = $request->validate([
                'regency_city_id' => 'required',
            ]);

            // Gabungkan data tambahan dengan data sebelumnya
            $data = array_merge($data, $additionalData);
        }
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return redirect('manage-account-'.$request->role)->with('success', 'Data berhasil di tambahkan');
    }

    public function edit($id){
        $provinces = Province::all();
        $regency_cities = RegencyCity::all();
        $departement = Departement::all();
        $data = User::find($id);
        return view('user.edit',compact('provinces','regency_cities', 'departement','data'));
    }

    public function update($id, Request $request){
        $data = $request->validate([
            'name' => 'required|min:5',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'role' => 'required|min:5',
            'region' => 'required|min:5',
            'province_id' => 'required',
        ]);
        if ($request->role !== "province") {
            $request->validate([
            'regency_city_id' => 'required',
        ]);
        }
        $user = User::find($id);
        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password']= $user->password;
        }
        $user->update($data);
        return redirect('manage-account-'.$request->role)->with('success', 'Data berhasil di update');

    }
    public function delete(Request $request){
        $user = User::where('id',$request->id)->delete();

	    return Response()->json($user);

    }

    public function data_show(Request $request){  
        if(request()->ajax()) {
            if($request->is('manage-account-province')) {
                $data = User::with(['province', 'regency_city'])->where('role', "province")->orderBy('id', 'desc');
                if (Auth::user()->role === "departement") {
                    $data = $data->where('province_id', Auth::user()->province_id);
                }
            } 
            if($request->is('manage-account-regency')) {
                $data = User::with(['province', 'regency_city'])  
                ->where('role', 'regency')  
                ->when(Auth::user()->role !== "pusat", function ($query) {  
                    $query->whereHas('regency_city', function ($query) {  
                        $query->where('province_id', Auth::user()->province_id);  
                    });  
                }) 
                ->orderBy('id', 'desc');
            }
            if($request->is('manage-account-departement')) {
                $data = User::with(['province', 'regency_city'])->where('role', "departement")->orderBy('id', 'desc');
            }
            if($request->is('manage-account-division')) {
                $data = User::with(['province', 'regency_city'])->where('role', "division")->orderBy('id', 'desc');
            }
	        return datatables()->of($data)
            ->addIndexColumn()
			->addColumn('action', function($row) { 
				return ' <div class="flex"> 
					<a href="'. url('/user-edit', $row->id) . '" class="btn btn-info btn-sm mt-3"> <i class="bi bi-pencil me-1"></i> Edit </a>
                    <a onClick="deleteFunc(' . $row->id . ')" class="btn btn-danger btn-sm mt-3"> <i class="bi bi-trash me-1"></i> Hapus </a> </div> '; }) 
			->rawColumns(['action'])
	        ->make(true);
	    }
        return view('user.data_show');
    }
}

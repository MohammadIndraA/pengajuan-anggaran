<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\DepartementBudgetRequest;
use App\Models\DepartementImport;
use App\Models\Kro;
use App\Models\Program;
use App\Models\ProvinceBudgetRequest;
use App\Models\ProvinceImport;
use App\Models\RegencyBudgetRequest;
use App\Models\RegencyImport;
use App\Models\Ro;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvinceImportController extends Controller
{
    public function index($id) {
        if(request()->ajax()) {
            if (Auth::user()->role === "province") {
                $data = ProvinceImport::where('province_budget_request_id', $id)->get();
            }
            if (Auth::user()->role === "departement") {
                $data = DepartementImport::where('departement_budget_request_id', $id)->get();
            }
            if (Auth::user()->role === "regency") {
                $data = RegencyImport::where('regency_budget_request_id', $id)->get();
            }
	        return datatables()->of($data)
	        ->addIndexColumn()
	        ->make(true);
	    }
        return view('pengajuan_anggaran.show', compact('id'));
    }

    public function create() {
        $program = Program::all();
        $kro = Kro::all();
        $ro = Ro::all();
        $unit = Unit::all();
        $component = Component::all();
        return view('pengajuan_anggaran.addImport', compact('program', 'kro', 'ro', 'unit', 'component'));
    }
    public function store(Request $request) {

        $vallidate = $request->validate([
            'program' => 'required',
            'activity' => 'required',
            'kro' => 'required',
            'ro' => 'required',
            'unit' => 'required',
            'component' => 'required',
            'qty' => 'required',
            'subtotal' => 'required',
        ]);
            $id = $request->id;
        if (Auth::user()->role == "province") {
            $nomor = ProvinceImport::where('province_budget_request_id', $request->id)->count();
            $vallidate['no'] = $nomor+1;
            $vallidate['province_budget_request_id'] = $id;
            $vallidate['total'] = $vallidate['qty'] * $vallidate['subtotal'];
            $provinve = ProvinceImport::create($vallidate);

            // update data ProvinceBudgetRequest
            $data = ProvinceBudgetRequest::where('id', $id)->first();
            $data->budget = $provinve->total + $data->budget;
            $data->save();
        }
        if (Auth::user()->role === "departement") {
            $nomor = DepartementImport::where('departement_budget_request_id', $request->id)->count();
            $vallidate['no'] = $nomor+1;
            $vallidate['departement_budget_request_id'] = $id;
            $vallidate['total'] = $vallidate['qty'] * $vallidate['subtotal'];
            $dev = DepartementImport::create($vallidate);

            // update data Dev
            $data = DepartementBudgetRequest::where('id', $id)->first();
            $data->budget = $dev->total + $data->budget;
            $data->save();
        }
        if (Auth::user()->role == "regency") {
            $nomor = RegencyImport::where('regency_budget_request_id', $request->id)->count();
            $vallidate['no'] = $nomor+1;
            $vallidate['regency_budget_request_id'] = $id;
            $vallidate['total'] = $vallidate['qty'] * $vallidate['subtotal'];
           $regency = RegencyImport::create($vallidate);

            // update data Reg
            $data = RegencyBudgetRequest::where('id', $id)->first();
            $data->budget = $regency->total + $data->budget;
            $data->save();
        }
        

        return view('pengajuan_anggaran.show', compact('id'));
    }
}

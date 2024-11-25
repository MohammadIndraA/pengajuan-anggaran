<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Component;
use App\Models\DepartementBudgetRequest;
use App\Models\DepartementImport;
use App\Models\DivisionBudgetRequest;
use App\Models\DivisionImport;
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
use Exception;

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
            if (Auth::user()->role === "division") {
                $data = DivisionImport::where('division_budget_request_id', $id)->get();
            }
	        return datatables()->of($data)
	        ->addIndexColumn()
            ->addColumn('action', function ($row) use ($id) {
                $actions = '<div class="d-flex flex-column">';
                // Tombol Edit dan Hapus
                $actions .= '<div class="d-inline-block">
                                <a href="' . route('pengajuan-anggaran-import.edit', ['id' => $row->id , 'ids' => $id]) . '" 
                                   class="btn btn-info btn-sm mt-3">
                                   <i class="bi bi-pencil-square me-1"></i>
                                </a>
                             </div>';
            
                $actions .= '</div>';
            
                return $actions;
            })            
                ->rawColumns(['action'])
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
        try{
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
        if (Auth::user()->role == "division") {
            $nomor = DivisionImport::where('division_budget_request_id', $request->id)->count();
            $vallidate['no'] = $nomor+1;
            $vallidate['division_budget_request_id'] = $id;
            $vallidate['total'] = $vallidate['qty'] * $vallidate['subtotal'];
           $regency = DivisionImport::create($vallidate);

            // update data Reg
            $data = DivisionBudgetRequest::where('id', $id)->first();
            $data->budget = $regency->total + $data->budget;
            $data->save();
        }
        return redirect()->route('pengajuan-anggaran-import.index', $id)->with('success', 'Data berhasil tambah');
        ;
 } catch (Exception $e) {
     // Tangani error dan redirect dengan pesan error
     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
 }
    }

    public function edit($id, $ids) {
        $program = Program::all();
        $kro = Kro::all();
        $ro = Ro::all();
        $unit = Unit::all();
        $component = Component::all();
        $activity = Activity::all();
        if (Auth::user()->role == "province") {
            $data = ProvinceImport::where('id', $id)->first();
        }
        if (Auth::user()->role == "regency") {
            $data = RegencyImport::where('id', $id)->first();
        }
        if (Auth::user()->role == "departement") {
            $data = DepartementImport::where('id', $id)->first();
        }
        if (Auth::user()->role == "division") {
            $data = DivisionImport::where('id', $id)->first();
        }
        return view('pengajuan_anggaran.editImport', compact('program', 'kro', 'ro', 'unit', 'component', 'activity', 'id', 'data', 'ids'));
    }

    public function update(Request $request, $id) {
        // Validasi data
        $validated = $request->validate([
            'program' => 'required',
            'activity' => 'required',
            'kro' => 'required',
            'ro' => 'required',
            'unit' => 'required',
            'component' => 'required',
            'qty' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);
        try {
            $validated['total'] = $validated['qty'] * $validated['subtotal'];
            // Cek role user dan update data berdasarkan role
            if (Auth::user()->role == "province") {
                $data = ProvinceImport::findOrFail($id);
                $data->update($validated);
                $totalBudget = ProvinceImport::where('province_budget_request_id', $request->ids)->sum('total');
                $prov = ProvinceBudgetRequest::where('id', $request->ids)->first();
                $prov->budget = $totalBudget;
                $prov->save();
            } elseif (Auth::user()->role == "regency") {
                $data = RegencyImport::findOrFail($id);
                $data->update($validated);
                $totalBudget = RegencyImport::where('regency_budget_request_id', $request->ids)->sum('total');
                $reg = RegencyBudgetRequest::where('id', $request->ids)->first();
                $reg->budget = $totalBudget;
                $reg->save();
            } elseif (Auth::user()->role == "departement") {
                $data = DepartementImport::findOrFail($id);
                $data->update($validated);
                $totalBudget = DepartementImport::where('departement_budget_request_id', $request->ids)->sum('total');
                $dep = DepartementBudgetRequest::where('id', $request->ids)->first();
                $dep->budget = $totalBudget;
                $dep->save();
            }elseif (Auth::user()->role == "division") {
                $data = DivisionImport::findOrFail($id);
                $data->update($validated);
                $totalBudget = DivisionImport::where('division_budget_request_id', $request->ids)->sum('total');
                $dep = DivisionBudgetRequest::where('id', $request->ids)->first();
                $dep->budget = $totalBudget;
                $dep->save();
            } else {
                // Jika role tidak cocok, lemparkan exception
                throw new Exception('Role tidak valid');
            }

    
            // Redirect dengan pesan sukses jika berhasil
            return redirect()->route('pengajuan-anggaran-import.index', $request->ids)
                ->with('success', 'Data berhasil diubah');
        } catch (Exception $e) {
            // Tangani error dan redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

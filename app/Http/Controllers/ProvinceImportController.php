<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Component;
use App\Models\DepartementBudgetRequest;
use App\Models\DepartementImport;
use App\Models\DivisionBudgetRequest;
use App\Models\DivisionImport;
use App\Models\FundingSource;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProvinceImportController extends Controller
{
    public function index($id) {
    
        // dd($data[1]);
       // Menampilkan data  
// foreach ($data as $item) {  
//     echo "Subkomponen: {$item->sub_component_name}, Program: {$item->program_name}, KRO: {$item->kro_name}, Activity: {$item->activity_name}, RO: {$item->ro_name}\n";  
    
//     if ($item->point_sub_component_id) {  
//         echo "  Point: {$item->point_sub_component_name}\n";  
//     }  
//     if ($item->sub_poin_sub_component_id) {  
//         echo "    Detail: {$item->sub_poin_sub_component_name}\n";  
//     }  
//     if ($item->kppn_id) {  
//         echo "      KPPN: {$item->kppn_name}\n";  
//     }  
//     if ($item->point_kppn_id) {  
//         echo "        Kategori: {$item->point_kppn_name}\n";  
//     }  
//     if ($item->sub_poin_sub_kppn_id) {  
//         echo "          KPPN Detail: {$item->sub_poin_sub_kppn_name}\n";  
//     }  
// } 

        if(request()->ajax()) {
            if (Auth::user()->role === "province") {
                $data = ProvinceImport::where('province_budget_request_id', $id)->get();
            }
            if (Auth::user()->role === "departement") {
                $data = DepartementImport::where('departement_budget_request_id', $id)->get();
            }
            if (Auth::user()->role === "regency") {
                // $data = RegencyImport::where('regency_budget_request_id', $id)->get();
                $data = DB::table('sub_components')  
        ->leftJoin('programs', 'sub_components.program_id', '=', 'programs.id')  
        ->leftJoin('kros', 'sub_components.kro_id', '=', 'kros.id')  
        ->leftJoin('activities', 'sub_components.activity_id', '=', 'activities.id')  
        ->leftJoin('ros', 'sub_components.ro_id', '=', 'ros.id')  
        ->leftJoin('point_sub_components', 'sub_components.id', '=', 'point_sub_components.sub_component_id')  
        ->leftJoin('sub_poin_sub_components', 'point_sub_components.id', '=', 'sub_poin_sub_components.point_sub_component_id')  
        ->leftJoin('kppns', 'sub_poin_sub_components.id', '=', 'kppns.sub_poin_sub_component_id')  
        ->leftJoin('point_kppns', 'kppns.id', '=', 'point_kppns.kppn_id')  
        ->leftJoin('sub_poin_sub_kppns', 'point_kppns.id', '=', 'sub_poin_sub_kppns.point_kppn_id')  
        ->select('sub_components.*',   
                 'programs.program_name as program_name',   
                 'kros.kro_name as kro_name',   
                 'activities.activity_name as activity_name',   
                 'ros.ro_name as ro_name',  
                 'point_sub_components.id as point_sub_component_id',  
                 'point_sub_components.point_sub_component_name as point_sub_component_name',  
                 'sub_poin_sub_components.id as sub_poin_sub_component_id',  
                 'sub_poin_sub_components.sub_poin_sub_component_name as sub_poin_sub_component_name',  
                 'kppns.id as kppn_id',  
                 'kppns.kppn_name as kppn_name',  
                 'point_kppns.id as point_kppn_id',  
                 'point_kppns.point_kppn_name as point_kppn_name',  
                 'sub_poin_sub_kppns.id as sub_poin_sub_kppn_id',  
                 'sub_poin_sub_kppns.sub_poin_sub_kppn_name as sub_poin_sub_kppn_name')  
        ->get(); 
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

    public function editData($id) {
        if (Auth::user()->role == "province") {
            $data = DB::table('sub_components')
            ->leftJoin('programs', 'sub_components.program_id', '=', 'programs.id')
            ->leftJoin('province_budget_requests', 'sub_components.province_budget_request_id', '=', 'province_budget_requests.id')
            ->leftJoin('point_sub_components', 'sub_components.id', '=', 'point_sub_components.sub_component_id')
            ->leftJoin('sub_poin_sub_components', 'point_sub_components.id', '=', 'sub_poin_sub_components.point_sub_component_id')
            ->select([
                'sub_components.sub_component_name',
                'sub_components.province_budget_request_id',
                'programs.program_name as program_name',
                'point_sub_components.point_sub_component_name as point_sub_component_name',
                'sub_poin_sub_components.sub_poin_sub_component_name as sub_poin_sub_component_name',
                'sub_poin_sub_components.sumber_dana',
                'province_budget_requests.submission_name',
                'province_budget_requests.submission_date',
            ])
            ->where('sub_components.province_budget_request_id', $id) // Pastikan field di where sesuai dengan kolom
            ->first();
        }
        if (Auth::user()->role == "regency") {
            $data = DB::table('sub_components')  
            ->leftJoin('programs', 'sub_components.program_id', '=', 'programs.id')  
            ->leftJoin('regency_budget_requests', 'sub_components.regency_budget_request_id', '=', 'regency_budget_requests.id')  
            ->leftJoin('point_sub_components', 'sub_components.id', '=', 'point_sub_components.sub_component_id')  
            ->leftJoin('sub_poin_sub_components', 'point_sub_components.id', '=', 'sub_poin_sub_components.point_sub_component_id')  
            ->select('sub_components.sub_component_name', 'sub_components.regency_budget_request_id','programs.program_name as program_name', 'point_sub_components.point_sub_component_name as point_sub_component_name', 'sub_poin_sub_components.sub_poin_sub_component_name as sub_poin_sub_component_name', 'sub_poin_sub_components.sumber_dana', 'regency_budget_requests.submission_name', 'regency_budget_requests.submission_date')
           ->where('sub_components.regency_budget_request_id', $id)
            ->first();
        }
        if (Auth::user()->role == "departement") {
            $data = DB::table('sub_components')
            ->leftJoin('programs', 'sub_components.program_id', '=', 'programs.id')
            ->leftJoin('departement_budget_requests', 'sub_components.departement_budget_request_id', '=', 'departement_budget_requests.id')
            ->leftJoin('point_sub_components', 'sub_components.id', '=', 'point_sub_components.sub_component_id')
            ->leftJoin('sub_poin_sub_components', 'point_sub_components.id', '=', 'sub_poin_sub_components.point_sub_component_id')
            ->select([
                'sub_components.sub_component_name',
                'sub_components.departement_budget_request_id',
                'programs.program_name as program_name',
                'point_sub_components.point_sub_component_name as point_sub_component_name',
                'sub_poin_sub_components.sub_poin_sub_component_name as sub_poin_sub_component_name',
                'sub_poin_sub_components.sumber_dana',
                'departement_budget_requests.submission_name',
                'departement_budget_requests.submission_date',
            ])
            ->where('sub_components.departement_budget_request_id', $id) // Pastikan field di where sesuai dengan kolom
            ->first();
        }
        if (Auth::user()->role == "division") {
            $data = DB::table('sub_components')
            ->leftJoin('programs', 'sub_components.program_id', '=', 'programs.id')
            ->leftJoin('division_budget_requests', 'sub_components.division_budget_request_id', '=', 'division_budget_requests.id')
            ->leftJoin('point_sub_components', 'sub_components.id', '=', 'point_sub_components.sub_component_id')
            ->leftJoin('sub_poin_sub_components', 'point_sub_components.id', '=', 'sub_poin_sub_components.point_sub_component_id')
            ->select([
                'sub_components.sub_component_name',
                'sub_components.division_budget_request_id',
                'programs.program_name as program_name',
                'point_sub_components.point_sub_component_name as point_sub_component_name',
                'sub_poin_sub_components.sub_poin_sub_component_name as sub_poin_sub_component_name',
                'sub_poin_sub_components.sumber_dana',
                'division_budget_requests.submission_name',
                'division_budget_requests.submission_date',
            ])
            ->where('sub_components.division_budget_request_id', $id) // Pastikan field di where sesuai dengan kolom
            ->first();
        }
        $funding_sources = FundingSource::all();
        $programs = Program::all();
        return view('pengajuan_anggaran.show_edit', compact('data', 'id', 'funding_sources', 'programs'));
    }

    public function updateData(Request $request, $id)
    {
        $request->validate([
            'submission_name' => 'required',
            'submission_date' => 'required',
        ]);
    
        try {
            // Tentukan model berdasarkan tipe
            $modelMap = [
                'province' => ProvinceBudgetRequest::class,
                'regency' => RegencyBudgetRequest::class,
                'departement' => DepartementBudgetRequest::class,
                'division' => DivisionBudgetRequest::class,
            ];
    
            $model = $modelMap[$request->type] ?? null;
            if (!$model) {
                return redirect()->back()->with('error', 'Tipe pengajuan tidak valid.');
            }
    
            $data = $model::find($id);
            if (!$data) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }
    
            // Upload File Excel
            if ($request->hasFile('evidence_file')) {
                // Hapus file lama jika ada
                if ($data->evidence_file) {
                    $oldFilePath = 'pengajuan/excel/' . $data->evidence_file;
                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                    }
                }
    
                // Proses unggah file baru
                $file = $request->file('evidence_file');
                $filenameExcel = date('His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pengajuan/excel', $filenameExcel, 'public');
    
                // Simpan nama file baru ke dalam data
                $data->evidence_file = $filenameExcel;
            }
    
            // Update data
            $data->update([
                'submission_name' => $request->submission_name,
                'submission_date' => $request->submission_date,
            ]);
    
            // Redirect dengan pesan sukses
            return redirect('pengajuan-anggaran')
                ->with('success', 'Data berhasil diubah');
        } catch (Exception $e) {
            // Tangani error dan redirect dengan pesan error
            return redirect('pengajuan-anggaran')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
}

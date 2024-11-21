<?php

namespace App\Http\Controllers;

use App\Exports\PengajuanAanggaranExport;
use App\Imports\DepartementImport;
use App\Imports\ProvinceImport;
use App\Imports\RegencyImport;
use App\Models\Activity;
use App\Models\Component;
use App\Models\DepartementBudgetRequest;
use App\Models\FundingSource;
use App\Models\Kro;
use App\Models\Program;
use App\Models\Province;
use App\Models\ProvinceBudgetRequest;
use App\Models\ProvinceImport as ModelsProvinceImport;
use App\Models\RegencyBudgetRequest;
use App\Models\RegencyCity;
use App\Models\Ro;
use App\Models\Unit;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProvinceBudgetRequestsController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
             if (Auth::user()->role === "province") {
                
                 $data = ProvinceBudgetRequest::with('funding_source')->get();
             }

             if (Auth::user()->role === "departement") {
                $data = DepartementBudgetRequest::with('funding_source')->get();
            }
            
            
             if (Auth::user()->role === "regency") {
                 $data = RegencyBudgetRequest::with('funding_source')->get();
             }
            
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <div class="blok">
                <a href="'. route('province-budget-requests.exort', $row->id) . '" class="btn btn-secondary btn-sm mt-3"><i
                                class="bi bi-eye me-1"></i> View</a>
                        <a href="'. route('province-imports.index', $row->id) . '" class="btn btn-info btn-sm mt-3"><i
                                        class="bi bi-pencil me-1"></i>Edit</a>
                        <a href="'. route('province-budget-requests.destroy', $row->id) . '" class="btn btn-sm btn-danger mt-3"><i
                                        class="bi bi-plus me-1">Hapus</i> 
                        </a>
                    </div>';
            })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pengajuan_anggaran.index');
    }

    public function create()
    {
        $funding_sources = FundingSource::all();
        $programs = Program::all();
        return view('pengajuan_anggaran.add', compact('funding_sources','programs'));
    }

    public function store(Request $request, FileUploadService $fileUploadService)
    {
        $request->validate([
            'submission_name' => 'required',
            'submission_date' => 'required',
            'funding_source_id' => 'required',
            'program_id' => 'required',
            'evidence_file' => 'required|array|max:2',
            'evidence_file.*' => 'mimes:xlsx,xls,csv,pdf|max:5048',
        ]);

     if (Auth::user()->role === "province") {
        
         $data = new ProvinceBudgetRequest();
         $data->budget = 0;
         $data->province_id = Auth::user()->province_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source_id = $request->funding_source_id;
         $data->program_id = $request->program_id;
         $data->evidence_file = "";
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

          // Panggil fungsi upload

          $formattedFileName = $fileUploadService->uploadMulti(
            $request->file('evidence_file'), 
            'pengajuan', 
            \App\Imports\ProvinceImport::class, 
            $data
        );
        // Update nama file di model
        $data->update(['evidence_file' => $formattedFileName]);
        }
     if (Auth::user()->role === "regency") {

         $data = new RegencyBudgetRequest();
         $data->budget = 0;
         $data->regency_city_id = Auth::user()->regency_city_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source_id = $request->funding_source_id;
         $data->program_id = $request->program_id;
         $data->evidence_file = "";
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

          // Panggil fungsi upload

          $formattedFileName = $fileUploadService->uploadMulti(
            $request->file('evidence_file'), 
            'pengajuan', 
            \App\Imports\RegencyImport::class, 
            $data
        );
        // Update nama file di model
        $data->update(['evidence_file' => $formattedFileName]);
     }  

     if (Auth::user()->role === "departement") {

         $data = new DepartementBudgetRequest();
         $data->budget = 0;
         $data->regency_city_id = Auth::user()->regency_city_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source_id = $request->funding_source_id;
         $data->program_id = $request->program_id;
         $data->evidence_file = "";
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

         // Panggil fungsi upload

         $formattedFileName = $fileUploadService->uploadMulti(
            $request->file('evidence_file'), 
            'pengajuan', 
            \App\Imports\DepartementImport::class, 
            $data
        );
        // Update nama file di model
        $data->update(['evidence_file' => $formattedFileName]);
     }  
        

        // ... kode lain ...  
        return redirect()->route('province-budget-requests.index');
    }

    public function show($id)
    {
        if(request()->ajax()) {
            $data = ModelsProvinceImport::where('province_budget_request_id', $id)->get();
	        return datatables()->of($data)
	        ->addIndexColumn()
	        ->make(true);
	    }
        return view('pengajuan_anggaran.show', compact('id'));
    }       

    public function edit($id)
    {
        $program = Program::all();
        $kro = Kro::all();
        $ro = Ro::all();
        $unit = Unit::all();
        $component = Component::all();
        $activity = Activity::all();
        return view('pengajuan_anggaran.editImport', compact('program', 'kro', 'ro', 'unit', 'component', 'activity', 'id'));
    }   

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'description' => 'required',
        ]);
        if ($request->type == "province") {
            $data =  ProvinceBudgetRequest::where('id', $id)->first();
        }
        if ($request->type == "regency") {
            $data = RegencyBudgetRequest::where('id', $id)->first();
        }
        if ($request->type == "departement") {
            $data = DepartementBudgetRequest::where('id', $id)->first();
        }
        $data->update([
            'status' => $request->status,
            'deskription' => $request->description
        ]);
        return redirect('pengajuan-anggaran-departement/'. $request->type)->with('success', 'Data berhasil diubah');
    }   

    public function destroy($id)
    {
        try {
            // Coba hapus data
            if (Auth::user()->role === "province") {
                $data = ProvinceBudgetRequest::where('id', $id)->first();
                $data->delete();
            }
            if (Auth::user()->role === "regency") {
                $data = RegencyBudgetRequest::where('id', $id)->first();
                $data->delete();
            }
            if (Auth::user()->role === "departement") {
                $data = DepartementBudgetRequest::where('id', $id)->first();
                $data->delete();
            }
            return redirect()->route('province-budget-requests.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap exception dan tampilkan pesan alert
            return redirect()->route('province-budget-requests.index')->with('error', 'Data tidak dapat dihapus karena memiliki relasi.');
        }
    }

    public function data_show(Request $request)
    {   
        if ($request->ajax()) {
            if ($request->is('pengajuan-anggaran-departement/province')) {
                $data = ProvinceBudgetRequest::with(['funding_source', 'province'])->get();
                $url = 'pengajuan-anggaran-province/edit';
            }
            if ($request->is('pengajuan-anggaran-departement/regency')) {
                $data = RegencyBudgetRequest::with(['funding_source', 'regency_city'])->get();
                $url = 'pengajuan-anggaran-regency/edit';
            }
            if ($request->is('pengajuan-anggaran-departement/departement')) {
                $data = DepartementBudgetRequest::with(['funding_source', 'regency_city'])->get();
                $url = 'pengajuan-anggaran-departement/edit';
            }
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($url) {
                return '
                <div class="blok">
                <a href="'. route('province-budget-requests.edit', $row->id) . '" class="btn btn-secondary btn-sm mt-3"><i
                                class="bi bi-eye me-1"></i> View</a>
                        <a href="'. url($url, $row->id) . '" class="btn btn-info btn-sm mt-3"><i
                                        class="bi bi-pencil me-1"></i>Edit</a>
                        <a href="'. route('province-budget-requests.destroy', $row->id) . '" class="btn btn-sm btn-danger mt-3"><i
                                        class="bi bi-plus me-1">Hapus</i> 
                        </a>
                    </div>';
            })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pengajuan_anggaran.show_data');
    }

    public function data_edit(Request $request, $id) {
        $funding_source = FundingSource::all();
        $regency_city = RegencyCity::all();
        $province = Province::all();
        if ($request->is('pengajuan-anggaran-province/edit/*')) {
            $data = ProvinceBudgetRequest::with(['province'])->where('id', $id)->first();
        }elseif($request->is('pengajuan-anggaran-departement/edit/*')){
            $data = DepartementBudgetRequest::with(['regency_city'])->where('id', $id)->first();
        }else{
            $data = RegencyBudgetRequest::with(['regency_city'])->where('id', $id)->first();
        }
        return view('pengajuan_anggaran.edit', compact('id', 'data', 'funding_source'));
    }

    public function export_data($id){   
        if (Auth::user()->role === "regency") {
            $type = "regency";
        }
        if (Auth::user()->role === "province") {
            $type = "province";
        }
        if (Auth::user()->role === "departement") {
            $type = "departement";
        }
        $import = new PengajuanAanggaranExport($id, $type);  
        return Excel::download($import, 'pengajuan_anggaran.xlsx');
    }
}

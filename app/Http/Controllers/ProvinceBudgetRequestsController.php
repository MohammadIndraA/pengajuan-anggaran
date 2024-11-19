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
use App\Models\ProvinceBudgetRequest;
use App\Models\ProvinceImport as ModelsProvinceImport;
use App\Models\RegencyBudgetRequest;
use App\Models\Ro;
use App\Models\Unit;
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
                
                 $data = ProvinceBudgetRequest::all();
             }

             if (Auth::user()->role === "departement") {
                $data = DepartementBudgetRequest::all();
            }
            
            
             if (Auth::user()->role === "regency") {
                 $data = RegencyBudgetRequest::all();
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
        $funding_source = FundingSource::all();
        return view('pengajuan_anggaran.add', compact('funding_source'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submission_name' => 'required',
            'submission_date' => 'required',
            'funding_source' => 'required',
            'evidence_file' => 'required|mimes:xlsx,xls,csv',
        ]);
        // dd($request->all());
        $file= $request->file('evidence_file');
        $filename= date('YmdHi').$file->getClientOriginalName();

        $path = $file->storeAs('pengajuan', $filename);

     if (Auth::user()->role === "province") {
        
         $data = new ProvinceBudgetRequest();
         $data->budget = 0;
         $data->province_id = Auth::user()->province_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source = $request->funding_source;
         $data->evidence_file = $filename;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

         $import = new ProvinceImport($id);  
         Excel::import($import, $request->file('evidence_file'));  
 
         $totalBudget = $import->getTotal(); // Ambil total dari ProvinceImport  
         $data->update(['budget' => $totalBudget]); // Update nilai budget 
     }
     if (Auth::user()->role === "regency") {

         $data = new RegencyBudgetRequest();
         $data->budget = 0;
         $data->regency_city_id = Auth::user()->regency_city_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source = $request->funding_source;
         $data->evidence_file = $filename;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

         $import = new RegencyImport($id);  
         Excel::import($import, $request->file('evidence_file'));  
 
         $totalBudget = $import->getTotal(); // Ambil total dari ProvinceImport  
         $data->update(['budget' => $totalBudget]); // Update nilai budget 
     }  

     if (Auth::user()->role === "departement") {

         $data = new DepartementBudgetRequest();
         $data->budget = 0;
         $data->regency_city_id = Auth::user()->regency_city_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source = $request->funding_source;
         $data->evidence_file = $filename;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

         $import = new DepartementImport($id);  
         Excel::import($import, $request->file('evidence_file'));  
 
         $totalBudget = $import->getTotal(); // Ambil total dari ProvinceImport  
         $data->update(['budget' => $totalBudget]); // Update nilai budget 
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
        ]);
        if ($request->type == "province") {
            $data =  ProvinceBudgetRequest::where('id', $id)->first();
        }
        if ($request->type == "regency") {
            $data = RegencyBudgetRequest::where('id', $id)->first();
        }
        $data->update($request->all());
        return redirect()->route('pengajuan-anggaran-departement');
    }   

    public function destroy($id)
    {
        try {
            // Coba hapus data
            ProvinceBudgetRequest::where('id', $id)->delete();
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
                $data = ProvinceBudgetRequest::all();
            }
            if ($request->is('pengajuan-anggaran-departement/regency')) {
                $data = RegencyBudgetRequest::all();
            }
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <div class="blok">
                <a href="'. route('province-budget-requests.edit', $row->id) . '" class="btn btn-secondary btn-sm mt-3"><i
                                class="bi bi-eye me-1"></i> View</a>
                        <a href="'. route('pengajuan-anggaran.edit', $row->id) . '" class="btn btn-info btn-sm mt-3"><i
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

    public function data_edit($id) {
        $funding_source = FundingSource::all();
        $data = ProvinceBudgetRequest::where('id', $id)->first();
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

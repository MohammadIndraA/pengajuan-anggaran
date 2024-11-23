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
use App\Models\ProposalFiles;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProvinceBudgetRequestsController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
             if (Auth::user()->role === "province") {
                
                 $data = ProvinceBudgetRequest::with(['funding_source','proposal_file'])
                 ->where('province_id', Auth::user()->province_id)
                 ->get();
             }

             if (Auth::user()->role === "departement") {
                $data = DepartementBudgetRequest::with(['funding_source','proposal_file'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                ->get();
            }
            
            
             if (Auth::user()->role === "regency") {
                 $data = RegencyBudgetRequest::with(['funding_source','proposal_file'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                 ->get();
             }
            
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actions = '<div class="d-flex flex-column">';
            
                // Jika file proposal tersedia, tambahkan tombol Doc Excel
                if ($row->proposal_file_id && $row->proposal_file) {
                    $url = url('/view-pdf/' . $row->proposal_file->proposal_title);
                    // $url = Storage::url($row->proposal_file->file_path);
                    $actions .= '<a href="' . $url . '" class="btn btn-secondary btn-sm mt-3" target="_blank">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Doc Proposal
                                 </a>';
                }
            
                // Tambahkan tombol Doc Proposal
                $actions .= '<a href="' . route('pengajuan-anggaran.exort', ['id' => $row->id , 'type' => Auth::user()->role]) . '" 
                                class="btn btn-warning btn-sm mt-3" >
                                <i class="bi bi-file-earmark-pdf me-1"></i> Doc Excel
                             </a>';
            
                // Tombol Edit dan Hapus
                $actions .= '<div class="d-inline-block">
                                <a href="' . route('pengajuan-anggaran-import.index', $row->id) . '" 
                                   class="btn btn-info btn-sm mt-3">
                                   <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <a href="' . route('pengajuan-anggaran.destroy', ['id' => $row->id , 'type' => Auth::user()->role]) . '" 
                                   class="btn btn-sm btn-danger mt-3" 
                                   onclick="return confirm(\'Are you sure you want to delete this item?\')">
                                   <i class="bi bi-trash me-1"></i> Hapus
                                </a>
                             </div>';
            
                $actions .= '</div>';
            
                return $actions;
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

    public function store(Request $request)
    {
        $request->validate([
            'submission_name' => 'required',
            'submission_date' => 'required',
            'funding_source_id' => 'required',
            'program_id' => 'required',
            'evidence_file' => 'required|mimes:xlsx,xls,csv|max:2048',
            'proposal_file_id' => 'required|mimes:pdf|max:7048',
        ]);

        // Upload File Excel
        if ($request->file('evidence_file')) {
            $file= $request->file('evidence_file');
            $filenameExcel= date('his').$file->getClientOriginalName();
            $path = $file->storeAs('pengajuan/excel', $filenameExcel,'public');
        }

        // Upload File Pdf
        if ($request->file('proposal_file_id')) {
            $filePdf= $request->file('proposal_file_id');
            $filenamePdf = date('his').$filePdf->getClientOriginalName();
            $pathPdf = $filePdf->storeAs('pengajuan/proposal', $filenamePdf, 'public');

            //  Create Tabel Proposal
            $proposal = new ProposalFiles();
            $proposal->proposal_title = $filenamePdf;
            $proposal->file_path = $pathPdf;
            $proposal->save();
        }

     if (Auth::user()->role === "province") {
        
         $data = new ProvinceBudgetRequest();
         $data->budget = 0;
         $data->province_id = Auth::user()->province_id;
         $data->deskription = '-';
         $data->submission_name = $request->submission_name;
         $data->submission_date = $request->submission_date;
         $data->funding_source_id = $request->funding_source_id;
         $data->proposal_file_id = $proposal->id ?? 0;
         $data->program_id = $request->program_id;
         $data->evidence_file = $filenameExcel;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();
         $id = $data->id;  

        //  Import Excel
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
         $data->funding_source_id = $request->funding_source_id;
         $data->program_id = $request->program_id;
         $data->proposal_file_id = $proposal->id ?? 0;
         $data->evidence_file = $filenameExcel;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

          //  Import Excel
          $import = new RegencyImport($id);  
          Excel::import($import, $request->file('evidence_file'));  
          $totalBudget = $import->getTotal(); // Ambil total dari RegencyImport  
          $data->update(['budget' => $totalBudget]); // Update nilai budget 
 
        
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
         $data->proposal_file_id = $proposal->id ?? 0;
         $data->evidence_file = $filenameExcel;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();

         $id = $data->id;  

          //  Import Excel
          $import = new DepartementImport($id);  
          Excel::import($import, $request->file('evidence_file'));  
          $totalBudget = $import->getTotal(); // Ambil total dari DepartementImport  
          $data->update(['budget' => $totalBudget]); // Update nilai budget 

     }  
        

        // ... kode lain ...  
        return redirect()->route('pengajuan-anggaran.index');
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

    public function destroy($id , $type)
    {
        try {
            // Coba hapus data
            if (Auth::user()->role === "province") {
                if ($type === "regency") {
                    $data = RegencyBudgetRequest::where('id', $id)->first();
                }else{
                    $data = ProvinceBudgetRequest::where('id', $id)->first();
                }
                $data->delete();
            }
            if (Auth::user()->role === "regency") {
                $data = RegencyBudgetRequest::where('id', $id)->first();
                $data->delete();
            }
            if (Auth::user()->role === "departement" || Auth::user()->role === "pusat" || Auth::user()->role === "admin") {
                if ($type === "regency") {
                    $data = RegencyBudgetRequest::where('id', $id)->first();
                }elseif ($type === "province") {
                    $data = ProvinceBudgetRequest::where('id', $id)->first();
                }else{
                    $data = DepartementBudgetRequest::where('id', $id)->first();
                }
                $data->delete();
            }
            return redirect(Auth::user()->role === $type 
            ? route('pengajuan-anggaran.index') 
            : url('pengajuan-anggaran-departement/' . $type))->with('success', 'Data berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap exception dan tampilkan pesan alert
            return redirect(Auth::user()->role === $type 
            ? route('pengajuan-anggaran.index') 
            : url('pengajuan-anggaran-departement/' . $type))->with('error', 'Data tidak dapat dihapus karena memiliki relasi.');
        }
    }

    public function data_show(Request $request)
    {   
        if ($request->ajax()) {
            if ($request->is('pengajuan-anggaran-departement/province')) {
                $data = ProvinceBudgetRequest::with(['funding_source', 'province'])
                ->where('province_id', Auth::user()->province_id)      
                ->get();
                $url = 'pengajuan-anggaran-province/edit';
                $type = 'province';
            }
            if ($request->is('pengajuan-anggaran-departement/regency')) {
                $data = RegencyBudgetRequest::with(['funding_source', 'regency_city'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                ->get();
                $url = 'pengajuan-anggaran-regency/edit';
                $type = 'regency';
            }
            if ($request->is('pengajuan-anggaran-departement/departement')) {
                $data = DepartementBudgetRequest::with(['funding_source', 'regency_city'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                ->get();
                $url = 'pengajuan-anggaran-departement/edit';
                $type = 'departement';
            }
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($url , $type) {
                $actions = '<div class="d-flex flex-wrap">';

                // Baris pertama: Doc Proposal dan Doc Excel
                if ($row->proposal_file_id && $row->proposal_file) {
                    $pdf = url('/view-pdf/' . $row->proposal_file->proposal_title);
                    $actions .= '<div class="p-1">
                                    <a href="' . $pdf . '" class="btn btn-secondary btn-sm w-100" target="_blank">
                                        <i class="bi bi-file-earmark-excel me-1"></i> Doc Proposal
                                    </a>
                                 </div>';
                }
                
                $actions .= '<div class="p-1">
                                <a href="' . route('pengajuan-anggaran.exort', ['id' => $row->id , 'type' => $type]) . '" 
                                   class="btn btn-warning btn-sm w-100">
                                   <i class="bi bi-file-earmark-pdf me-1"></i> Doc Excel
                                </a>
                             </div>';
                
                // Baris kedua: Edit dan Hapus
                $actions .= '<div class="p-1">
                                <a href="'  . url($url, $row->id) .  '" 
                                   class="btn btn-info btn-sm w-100">
                                   <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                             </div>';
                
                $actions .= '<div class="p-1">
                                <a href="' . route('pengajuan-anggaran.destroy', ['id' => $row->id , 'type' => $type]) . '" 
                                   class="btn btn-sm btn-danger w-100" 
                                   onclick="return confirm(\'Are you sure you want to delete this item?\')">
                                   <i class="bi bi-trash me-1"></i> Hapus
                                </a>
                             </div>';
                
                $actions .= '</div>';
                
                return $actions;
                
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

    public function export_data($id, $type){
        $import = new PengajuanAanggaranExport($id, $type);  
        return Excel::download($import, 'pengajuan_anggaran.xlsx');
    }

    public function show_proposal($filename){
        $path = storage_path('app/public/pengajuan/proposal/' . $filename);
  
        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }
    
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

   
    
}

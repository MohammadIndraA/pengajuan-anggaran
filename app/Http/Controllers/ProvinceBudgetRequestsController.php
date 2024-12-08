<?php

namespace App\Http\Controllers;

use App\Exports\PengajuanAanggaranExport;
use App\Imports\DepartementImport;
use App\Imports\DivisionImport;
use App\Imports\ProvinceImport;
use App\Imports\RegencyImport;
use App\Models\Activity;
use App\Models\Component;
use App\Models\DepartementBudgetRequest;
use App\Models\DivisionBudgetRequest;
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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Matrix\Operators\Division;
use Yajra\DataTables\Facades\DataTables;

class ProvinceBudgetRequestsController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
             if (Auth::user()->role === "province") {
                
                 $data = ProvinceBudgetRequest::with(['funding_source','proposal_file'])
                 ->where('province_id', Auth::user()->province_id)
                 ->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                ->latest()
                 ->get();
             }

             if (Auth::user()->role === "departement") {
                $data = DepartementBudgetRequest::with(['funding_source','proposal_file'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                ->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                ->latest()
                ->get();
            }
            
            
             if (Auth::user()->role === "regency") {
                 $data = RegencyBudgetRequest::with(['funding_source','proposal_file'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                ->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                ->latest()
                 ->get();
             }

             if (Auth::user()->role === "division") {
                 $data = DivisionBudgetRequest::with(['funding_source','proposal_file'])
                ->where('regency_city_id', Auth::user()->regency_city_id)
                ->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                ->latest()
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
            

                if ($row->evidence_file) {
                    $url = url('/view-excel/' . $row->evidence_file);
                    // $url = Storage::url($row->proposal_file->file_path);
                    $actions .= '<a href="' . $url . '" 
                    class="btn btn-warning btn-sm mt-3" >
                    <i class="bi bi-file-earmark-pdf me-1"></i> Doc Excel
                      </a>';
                }
                // Tombol Edit dan Hapus
                $actions .= '<div class="d-inline-block">
                                <a href="' . route('pengajuan-anggaran.edit-data', $row->id) . '" 
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
            'evidence_file' => 'required|mimes:xlsx,xls,csv|max:2048',
            'proposal_file_id' => 'nullable|mimes:pdf|max:7048',
        ]);
    try{
        // Upload File Excel
        if ($request->file('evidence_file')) {
            $file= $request->file('evidence_file');
             // Tentukan wilayah berdasarkan role pengguna
            if (Auth::user()->role === "province") {
                $wilayah = Auth::user()->province->name;
            } else {
                $wilayah = Auth::user()->regency_city->name;
            }
            $filenameExcel= date('his'). '-' . $wilayah. '-' .$file->getClientOriginalName();
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
         $data->proposal_file_id = $proposal->id ?? null;
         $data->program_id = $request->program_id;
         $data->evidence_file = $filenameExcel;
         $data->is_imported = 1;
         $data->status = 'pending';
         $data->save();
         $id = $data->id;  

        //  Import Excel
        $import = new RegencyImport($id); 
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
         $data->proposal_file_id = $proposal->id ?? null;
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
          $import = new RegencyImport($id); 
          Excel::import($import, $request->file('evidence_file'));  
          $totalBudget = $import->getTotal(); // Ambil total dari DepartementImport  
          $data->update(['budget' => $totalBudget]); // Update nilai budget 

     }  

     if (Auth::user()->role === "division") {

         $data = new DivisionBudgetRequest();
         $data->budget = 0;
         $data->regency_city_id = Auth::user()->regency_city_id;
         $data->province_id = Auth::user()->province_id;
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
          $totalBudget = $import->getTotal(); // Ambil total dari DepartementImport  
          $data->update(['budget' => $totalBudget]); // Update nilai budget 

     }  
        
            return redirect()->route('pengajuan-anggaran.index')->with('success', 'Data berhasil ditambahkan');
        } catch (Exception $e) {
            // Tangani error dan redirect dengan pesan error
            return redirect()->route('pengajuan-anggaran.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        return view('pengajuan_anggaran.addImport', compact('program', 'kro', 'ro', 'unit', 'component', 'activity', 'id'));
    }   

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'description' => 'required',
        ]);
    try{
        if ($request->type == "province") {
            $data =  ProvinceBudgetRequest::where('id', $id)->first();
        }
        if ($request->type == "regency") {
            $data = RegencyBudgetRequest::where('id', $id)->first();
        }
        if ($request->type == "departement") {
            $data = DepartementBudgetRequest::where('id', $id)->first();
        }
        if ($request->type == "division") {
            $data = DivisionBudgetRequest::where('id', $id)->first();
        }
        $data->update([
            'status' => $request->status,
            'deskription' => $request->description
        ]);
         // Redirect dengan pesan sukses jika berhasil
         return redirect('pengajuan-anggaran-departement/'. $request->type)->with('success', 'Data berhasil diubah');
    } catch (Exception $e) {
        // Tangani error dan redirect dengan pesan error
        return redirect('pengajuan-anggaran-departement/'. $request->type)->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    }   

    public function destroy($id , $type)
    {
        try {
            // Coba hapus data
            $data = null;

        // Tentukan data berdasarkan peran pengguna dan tipe
        switch (Auth::user()->role) {
            case 'province':
                if ($type === 'regency') {
                    $data = RegencyBudgetRequest::find($id);
                } else {
                    $data = ProvinceBudgetRequest::find($id);
                }
                break;

            case 'regency':
                $data = RegencyBudgetRequest::find($id);
                break;

            case 'division':
                $data = DivisionBudgetRequest::find($id);
                break;

            case 'departement':
            case 'pusat':
                if ($type === 'regency') {
                    $data = RegencyBudgetRequest::find($id);
                } elseif ($type === 'province') {
                    $data = ProvinceBudgetRequest::find($id);
                } else {
                    $data = DepartementBudgetRequest::find($id);
                }
                break;

            default:
                return redirect()->back()->with('error', 'Peran pengguna tidak valid.');
        }

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        // Hapus data
        $data->delete();

        // Hapus file terkait jika ada
        if ($data->evidence_file) {
            $oldFilePath = 'pengajuan/excel/' . $data->evidence_file;
            if (Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }
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
         // Role Province
         if (Auth::user()->role === "departement") {
            if ($request->is('pengajuan-anggaran-departement/province')) {
                $province_regency = Province::where('id', Auth::user()->province_id)->get();
            }elseif ($request->is('pengajuan-anggaran-departement/regency')) {
                $province_regency = RegencyCity::with('province')->where('province_id', Auth::user()->province_id)->get();
            }
        }elseif (Auth::user()->role === "province") {
             $province_regency = RegencyCity::with('province')->where('province_id', Auth::user()->province_id)->get();
        }else{
                // pusat
                if ($request->is('pengajuan-anggaran-departement/province')) {
                    $province_regency = Province::all();
                }elseif ($request->is('pengajuan-anggaran-departement/regency')) {
                    $province_regency = RegencyCity::with('province')->get();
                }elseif($request->is('pengajuan-anggaran-departement/division')){
                    $province_regency = RegencyCity::with('province')->get();
                }elseif ($request->is('pengajuan-anggaran-departement/departement')) {
                    $province_regency = RegencyCity::with('province')->get();
                }
         }
         for ($i=0; $i < count($province_regency) ; $i++) { 
             // ambil nama regency
             $name_regency[] = [
                 'id' => $province_regency[$i]->id,
                 'name' => $province_regency[$i]->name
             ];
         } 
        if ($request->ajax()) {
            if ($request->is('pengajuan-anggaran-departement/province')) {
                $query = ProvinceBudgetRequest::with(['funding_source', 'province']);
                if (Auth::user()->role !== "pusat") {
                    $query = ProvinceBudgetRequest::with(['funding_source', 'province'])->where('province_id', Auth::user()->province_id);                 
                }
                  
               $data =  $query->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                 ->when($request->has('state') && $request->state != "" , function($data) use ($request) {
                    $data->where('province_id', $request->state);
                }) 
                ->latest()
                ->get();
                $url = 'pengajuan-anggaran-province/edit';
                $type = 'province';
            }
            if ($request->is('pengajuan-anggaran-departement/regency')) {
                $query = RegencyBudgetRequest::with(['funding_source', 'regency_city'])  
                ->when(Auth::user()->role !== "pusat", function ($query) {  
                    $query->whereHas('regency_city', function ($query) {  
                        $query->where('province_id', Auth::user()->province_id);  
                    });  
                });
                // Tambahkan filter berdasarkan parameter request
                $data = $query->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                        $query->where('status', $request->status);
                    })
                    ->when($request->has('state') && $request->state != "", function ($query) use ($request) {
                        $query->where('regency_city_id', $request->state);
                    })
                    ->latest()
                    ->get();
            
                $url = 'pengajuan-anggaran-regency/edit';
                $type = 'regency';
            }            
            if ($request->is('pengajuan-anggaran-departement/departement')) {
                $data = DepartementBudgetRequest::with(['funding_source', 'regency_city'])
                ->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                ->when($request->has('state') && $request->state != "" , function($data) use ($request) {
                   $data->where('regency_city_id', $request->state);
               }) 
                ->latest()
                ->get();
                $url = 'pengajuan-anggaran-departement/edit';
                $type = 'departement';
            }
            if ($request->is('pengajuan-anggaran-departement/division')) {
                $data = DivisionBudgetRequest::with(['funding_source', 'regency_city'])
                ->when($request->has('status') && $request->status != "" , function($data) use ($request) {
                    $data->where('status', $request->status);
                })
                ->when($request->has('state') && $request->state != "" , function($data) use ($request) {
                   $data->where('regency_city_id', $request->state);
               }) 
                ->latest()
                ->get();
                $url = 'pengajuan-anggaran-division/edit';
                $type = 'division';
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
                if ($row->evidence_file) {
                    $uri = url('/view-excel/' . $row->evidence_file);
                    // $url = Storage::url($row->proposal_file->file_path);
                    $actions .=  '<div class="p-1">
                    <a href="' . $uri . '" 
                       class="btn btn-warning btn-sm w-100">
                       <i class="bi bi-file-earmark-pdf me-1"></i> Doc Excel
                    </a>
                 </div>';
                }
                
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
        return view('pengajuan_anggaran.show_data', compact('province_regency', 'name_regency'));
    }

    public function data_edit(Request $request, $id) {
        $funding_source = FundingSource::all();
        $regency_city = RegencyCity::all();
        $province = Province::all();
        if ($request->is('pengajuan-anggaran-province/edit/*')) {
            $data = ProvinceBudgetRequest::with(['province'])->where('id', $id)->first();
        }elseif($request->is('pengajuan-anggaran-departement/edit/*')){
            $data = DepartementBudgetRequest::with(['regency_city'])->where('id', $id)->first();
        }elseif($request->is('pengajuan-anggaran-regency/edit/*')){
            $data = RegencyBudgetRequest::with(['regency_city'])->where('id', $id)->first();
        }else{
            $data = DivisionBudgetRequest::with(['regency_city'])->where('id', $id)->first();
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
    public function show_excel($filename){
        $path = storage_path('app/public/pengajuan/excel/' . $filename);
  
        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }
    
        return response()->file($path, [
            'Content-Type' => 'application/xlsx',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

   
    
}

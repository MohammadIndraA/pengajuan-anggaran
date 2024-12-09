<?php

namespace App\Http\Controllers;

use App\Models\DepartementBudgetRequest;
use App\Models\DivisionBudgetRequest;
use App\Models\Province;
use App\Models\ProvinceBudgetRequest;
use App\Models\ProvinceImport;
use App\Models\RegencyBudgetRequest;
use App\Models\RegencyCity;
use App\Models\RegencyImport;
use App\Models\SubComponent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;
use File;
use function Illuminate\Log\log;

class LaporanController extends Controller
{
    public function index(Request $request) {

        $provinces = Province::select('name', 'id as location_id', DB::raw("'province' as location_type"))
                    ->get()
                    ->toArray();  // Mengonversi hasil ke array biasa

                $regencyCities = RegencyCity::select('name', 'id as location_id', DB::raw("'regency' as location_type"))
                    ->get()
                    ->toArray();  // Mengonversi hasil ke array biasa

                // Gabungkan hasil
                $state = array_merge($provinces, $regencyCities);  
               
        if ($request->ajax()) {
      // Ambil data dari masing-masing tabel
      $provincesBudget = DB::table('province_budget_requests')
      ->leftJoin('provinces', 'province_budget_requests.province_id', '=', 'provinces.id')
      ->select(
          'province_budget_requests.submission_name',
          'province_budget_requests.budget',
          'province_budget_requests.status',
          'province_budget_requests.created_at',
          'province_budget_requests.updated_at',
          'provinces.name as province_name',
          'provinces.id as province_id',
          DB::raw('NULL as regency_name'),
          DB::raw('NULL as regency_city_id'),
          'province_budget_requests.id as province_budget_request_id'
      )
      ->where('province_budget_requests.status', 'approved')
      ->get();

  $regencyBudget = DB::table('provinces')
      ->rightJoin('regency_cities', 'provinces.id', '=', 'regency_cities.province_id')
      ->rightJoin('regency_budget_requests', 'regency_cities.id', '=', 'regency_budget_requests.regency_city_id')
      ->select(
          'regency_budget_requests.submission_name',
          'regency_budget_requests.budget',
          'regency_budget_requests.status',
          'regency_budget_requests.created_at',
          'regency_budget_requests.updated_at',
          'provinces.name as province_name',
          'regency_cities.id as regency_city_id',
          'regency_cities.name as regency_name',
          'provinces.id as province_id',
          'regency_budget_requests.id as regency_budget_request_id'
      )
      ->where('regency_budget_requests.status', 'approved')
      ->get();

  $departmentRequests = DB::table('provinces')
      ->rightJoin('regency_cities', 'provinces.id', '=', 'regency_cities.province_id')
      ->rightJoin('departement_budget_requests', 'regency_cities.id', '=', 'departement_budget_requests.regency_city_id')
      ->select(
          'departement_budget_requests.submission_name',
          'departement_budget_requests.budget',
          'departement_budget_requests.status',
          'departement_budget_requests.created_at',
          'departement_budget_requests.updated_at',
          'provinces.name as province_name',
          'regency_cities.id as regency_city_id',
          'regency_cities.name as regency_name',
          'provinces.id as province_id',
          'departement_budget_requests.id as departement_budget_request_id'
      )
      ->where('departement_budget_requests.status', 'approved')
      ->get();

  $divisionRequests = DB::table('provinces')
      ->rightJoin('regency_cities', 'provinces.id', '=', 'regency_cities.province_id')
      ->rightJoin('division_budget_requests', 'regency_cities.id', '=', 'division_budget_requests.regency_city_id')
      ->select(
          'division_budget_requests.submission_name',
          'division_budget_requests.budget',
          'division_budget_requests.status',
          'division_budget_requests.created_at',
          'division_budget_requests.updated_at',
          'provinces.name as province_name',
          'regency_cities.id as regency_city_id',
          'regency_cities.name as regency_name',
          'provinces.id as province_id',
          'division_budget_requests.id as division_budget_request_id'
      )
      ->where('division_budget_requests.status', 'approved')
      ->get();

  // Gabungkan data
  $data = collect($provincesBudget)
      ->concat($regencyBudget)
      ->concat($departmentRequests)
      ->concat($divisionRequests);

  // Filter berdasarkan status
  if ($request->filled('status')) {
      $status = explode(',', $request->status);
      if (count($status) === 2) {
          $statusId = $status[0];
          $statusType = $status[1];

          $data = $data->filter(function ($item) use ($statusId, $statusType) {
              return $statusType === 'province'
                  ? $item->province_id == $statusId
                  : $item->regency_city_id == $statusId;
          });
      }
  }

  // Filter berdasarkan rentang tanggal
  if ($request->filled('from_date') && $request->filled('to_date')) {
      $data = $data->filter(function ($item) use ($request) {
          return $item->updated_at >= $request->from_date && $item->updated_at <= $request->to_date;
      });
  }

            return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        }
        return view('laporan.laporan', compact('state'));
    }

    public function generatePDF(Request $request)
    {
        $data = json_decode($request->data, true);

        // Validasi data agar tidak terjadi error jika key tidak ada
        if (!empty($data)) {
            // Variabel untuk menyimpan hasil query
            $regencys = [];
            $regencys_name = [];
            $prov = null;
            $regency = null;
            // Cek dan ambil data untuk regency_budget_request_id
            if (isset($data[0]['regency_budget_request_id'])) {
                $model = 'regency_budget_requests';
                $id = $data[0]['regency_budget_request_id'];
                $subComponent = new SubComponent();
                $regency = $subComponent->scopeWithFullDetails(DB::table('sub_components'), $model, 'regency_budget_request_id', $id)
                ->where('regency_budget_requests.status', 'approved')
                ->get();
                dd($regency[1]->point_sub_components);
            }
        
            // Cek dan ambil data untuk province_budget_request_id
            if (isset($data[0]['province_budget_request_id'])) {
                $model = 'province_budget_requests';
                $id = $data[0]['province_budget_request_id'];
                $subComponent = new SubComponent();
                $prov = $subComponent->scopeWithFullDetails(DB::table('sub_components'), $model, 'province_budget_request_id', $id)
                ->where('province_budget_requests.status', 'approved')
                ->get();
        
                // Ambil semua regency_budget_request_id dari $data
                $regency_ids = array_column($data, 'regency_budget_request_id');
                $regencys_name = array_column($data, 'regency_name');
        
                // Query semua regency data berdasarkan ID
                if (!empty($regency_ids)) {
                    foreach ($regency_ids as $id) {
                        $regencys[$id] = $model = 'regency_budget_requests';
                        $id = $data[0]['regency_budget_request_id'];
                        $subComponent = new SubComponent();
                        $regencys = $subComponent->scopeWithFullDetails(DB::table('sub_components'), $model, 'regency_budget_request_id', $id)
                        ->get();
                    }
                }
            }
            // Debug hasil jika diperlukan
            // dd(compact('regency', 'prov', 'regencys'));
        }
        // dd($data[0]['regency_budget_request_id']);
        // Ambil tanggal dari request
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $view = $prov != null ? 'laporan.laporan_province' : 'laporan.index';
        $pdf = Pdf::loadView($view, compact('data', 'from_date', 'to_date', 'regency','prov', 'regencys', 'regencys_name'));        
        return $pdf->download('laporan.pdf'); 
    }

    public function downloadExcelAsZip(Request $request) 
    {
        try {
            // Ambil daftar kabupaten/kota berdasarkan provinsi user
            $provinceId = Auth::user()->province_id;
            $provinceRegency = RegencyCity::with('province')
                ->where('province_id', $provinceId)
                ->get();
    
            // Ambil data pengajuan anggaran berdasarkan kabupaten/kota yang ditemukan
            $data = RegencyBudgetRequest::whereIn('regency_city_id', $provinceRegency->pluck('id'))->get();
    
            // Validasi jika tidak ada data
            if ($data->isEmpty()) {
                return response()->json(['error' => 'No data available to download'], 404);
            }
    
            // Path untuk file ZIP
            $zipPath = storage_path('laporan.zip');
            $zip = new ZipArchive();
    
            // Membuat ZIP file
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                \Log::error('Failed to open ZIP file', ['zipPath' => $zipPath, 'error' => $zip->getStatusString()]);
                return response()->json(['error' => 'Failed to create ZIP file'], 500);
            }
    
            // Menggabungkan file ke dalam ZIP
            foreach ($data as $item) {
                $fileName = $item->evidence_file;
                $filePath = storage_path('app/public/pengajuan/excel/' . $fileName);
    
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $fileName);
                } else {
                    \Log::warning('File not found: ' . $filePath);
                }
            }
    
            $zip->close();
            // Mengunduh file ZIP jika berhasil
            if (file_exists($zipPath)) {
                return response()->download($zipPath)->deleteFileAfterSend(true);
            }
    
            return response()->json(['error' => 'Failed to generate ZIP file'], 500);
    
        } catch (\Exception $e) {
            \Log::error('Unexpected error during ZIP creation', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An internal error occurred'], 500);
        }
    }
    
}

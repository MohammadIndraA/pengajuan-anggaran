<?php

namespace App\Http\Controllers;

use App\Models\DepartementBudgetRequest;
use App\Models\Province;
use App\Models\ProvinceBudgetRequest;
use App\Models\RegencyBudgetRequest;
use App\Models\RegencyCity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
            //    approved all table
                          // Ambil data Province dan RegencyCity
            $provinces_budget = ProvinceBudgetRequest::select('submission_name', 'budget', 'province_id', 'status', 'created_at','updated_at')
            ->with('province') // Jika ada relasi yang perlu dimuat
            ->where('status', 'approved')
            ->get(); // Jangan konversi menjadi array dulu

            $regency_budget = RegencyBudgetRequest::select('submission_name', 'budget', 'regency_city_id', 'status', 'created_at','updated_at')
            ->with('regency_city') // Jika ada relasi yang perlu dimuat
            ->where('status', 'approved')
            ->get(); // Jangan konversi menjadi array dulu

            $departement_request = DepartementBudgetRequest::select('submission_name', 'budget', 'regency_city_id', 'status', 'created_at','updated_at')
            ->with('regency_city') // Jika ada relasi yang perlu dimuat
            ->where('status', 'approved')
            ->get(); // Jangan konversi menjadi array dulu

            // Gabungkan hasil
            // Gabungkan hasil menggunakan concat
            $data = $provinces_budget->concat($regency_budget)->concat($departement_request);
            if($request->filled('status')&& $request->status != "")
            {
                $status = explode(',', $request->status);
                if ($status[1] == "province") {
                    $data = $data->where('province_id', $status[0]);
                }else{
                    $data = $data->where('regency_city_id', $status[0]);
                }
            }
            if($request->filled('from_date') && $request->filled('to_date'))
            {
                $data = $data->whereBetween('updated_at', [$request->from_date, $request->to_date]);
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
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $pdf = Pdf::loadView('laporan.index', compact('data', 'from_date', 'to_date'));
        return $pdf->download('laporan.pdf');
    }
}

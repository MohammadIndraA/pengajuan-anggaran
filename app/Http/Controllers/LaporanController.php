<?php

namespace App\Http\Controllers;

use App\Models\DepartementBudgetRequest;
use App\Models\DivisionBudgetRequest;
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
            $provinces_budget =DB::table('provinces')
            ->rightJoin('province_budget_requests', 'provinces.id', '=', 'province_budget_requests.province_id')
            ->select('province_budget_requests.submission_name', 'province_budget_requests.budget', 'province_budget_requests.status', 'province_budget_requests.created_at', 'province_budget_requests.updated_at', 'provinces.name as province_name')
            ->where('status', 'approved')
            ->get();

            $regency_budget =DB::table('provinces')
            ->rightJoin('regency_cities', 'provinces.id', '=', 'regency_cities.province_id')
            ->rightJoin('regency_budget_requests', 'regency_cities.id', '=', 'regency_budget_requests.regency_city_id')
            ->select('regency_cities.province_id', 'regency_budget_requests.submission_name', 'regency_budget_requests.budget', 'regency_budget_requests.status', 'regency_budget_requests.created_at', 'regency_budget_requests.updated_at', 'regency_cities.name as regency_name','provinces.name as province_name')
            ->where('status', 'approved')
            ->get();

            $departement_request = DB::table('provinces')
            ->rightJoin('regency_cities', 'provinces.id', '=', 'regency_cities.province_id')
            ->rightJoin('departement_budget_requests', 'regency_cities.id', '=', 'departement_budget_requests.regency_city_id')
            ->select('regency_cities.province_id', 'departement_budget_requests.submission_name', 'departement_budget_requests.budget', 'departement_budget_requests.status', 'departement_budget_requests.created_at', 'departement_budget_requests.updated_at', 'regency_cities.name as regency_name','provinces.name as province_name')
            ->where('status', 'approved')
            ->get();

            $division_request =DB::table('provinces')
            ->rightJoin('regency_cities', 'provinces.id', '=', 'regency_cities.province_id')
            ->rightJoin('division_budget_requests', 'regency_cities.id', '=', 'division_budget_requests.regency_city_id')
            ->select('regency_cities.province_id', 'division_budget_requests.submission_name', 'division_budget_requests.budget', 'division_budget_requests.status', 'division_budget_requests.created_at', 'division_budget_requests.updated_at', 'regency_cities.name as regency_name','provinces.name as province_name')
            ->where('status', 'approved')
            ->get();

            // Gabungkan hasil
            // Gabungkan hasil menggunakan concat
            $data = $provinces_budget->concat($regency_budget)->concat($departement_request)->concat($division_request);
            if($request->filled('status')&& $request->status != "")
            {
                $status = explode(',', $request->status);
                if ($status[1] == "province") {
                    $data = $data->where('province_id', $status[0]);
                }else if ($status[1] == "regency") {
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

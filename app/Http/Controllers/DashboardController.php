<?php

namespace App\Http\Controllers;

use App\Models\DepartementBudgetRequest;
use App\Models\ProvinceBudgetRequest;
use App\Models\RegencyBudgetRequest;
use App\Services\CalculateServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{

    private function calculateExpenditure($model, $period)
    {
        $query = $model::where('status', 'approved');

        switch ($period) {
            case 'daily':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'monthly':
                $query->whereYear('created_at', Carbon::now()->year)
                      ->whereMonth('created_at', Carbon::now()->month);
                break;

            case 'yearly':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        return $query->sum('budget');
    }

    public function index(Request $request, CalculateServices $expenditureService)
    {
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
       $pengajuan_anggaran = $provinces_budget->concat($regency_budget)->concat($departement_request);
       $pengajuan_anggaran = $pengajuan_anggaran->sortByDesc('updated_at'); 
        if ($request->ajax()) {
            return DataTables::of($pengajuan_anggaran)
            ->addIndexColumn()
            ->make(true);
        }

       // Pengeluaran default harian untuk masing-masing scope
       $expenditureProvince = ProvinceBudgetRequest::where('status', 'approved')
       ->whereDate('created_at', Carbon::today())
       ->sum('budget');

        $expenditureRegency = RegencyBudgetRequest::where('status', 'approved')
            ->whereDate('created_at', Carbon::today())
            ->sum('budget');

        $expenditureDep = DepartementBudgetRequest::where('status', 'approved')
            ->whereDate('created_at', Carbon::today())
            ->sum('budget');

   // Cek apakah ada permintaan tipe khusus (monthly/yearly)
   if ($request->has('type')) {
       switch ($request->type) {
           case 'province_monthly':
               $expenditureProvince = $this->calculateExpenditure(ProvinceBudgetRequest::class, 'monthly');
               break;
           case 'province_yearly':
               $expenditureProvince = $this->calculateExpenditure(ProvinceBudgetRequest::class, 'yearly');
               break;

           case 'regency_monthly':
               $expenditureRegency = $this->calculateExpenditure(RegencyBudgetRequest::class, 'monthly');
               break;
           case 'regency_yearly':
               $expenditureRegency = $this->calculateExpenditure(RegencyBudgetRequest::class, 'yearly');
               break;

           case 'departement_monthly':
               $expenditureDep = $this->calculateExpenditure(DepartementBudgetRequest::class, 'monthly');
               break;
           case 'departement_yearly':
               $expenditureDep = $this->calculateExpenditure(DepartementBudgetRequest::class, 'yearly');
               break;
       }
   }

    $amount = $pengajuan_anggaran->where('status', 'approved')->sum('budget');
   // Return hasil ke view
   return view('dashboard.index', compact('expenditureProvince', 'expenditureRegency', 'expenditureDep','amount', 'pengajuan_anggaran'));
    }
}

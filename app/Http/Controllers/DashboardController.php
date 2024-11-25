<?php

namespace App\Http\Controllers;

use App\Models\DepartementBudgetRequest;
use App\Models\DivisionBudgetRequest;
use App\Models\ProvinceBudgetRequest;
use App\Models\RegencyBudgetRequest;
use App\Models\RegencyCity;
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
       ->get(); // Jangan konversi menjadi array dulu

       $regency_budget = RegencyBudgetRequest::select('submission_name', 'budget', 'regency_city_id', 'status', 'created_at','updated_at')
       ->with('regency_city') // Jika ada relasi yang perlu dimuat
       ->get(); // Jangan konversi menjadi array dulu

       $departement_request = DepartementBudgetRequest::select('submission_name', 'budget', 'regency_city_id', 'status', 'created_at','updated_at')
       ->with('regency_city') // Jika ada relasi yang perlu dimuat
       ->get(); // Jangan konversi menjadi array dulu
       $division_request = DivisionBudgetRequest::select('submission_name', 'budget', 'regency_city_id', 'status', 'created_at','updated_at')
       ->with(['regency_city', 'province']) // Jika ada relasi yang perlu dimuat
       ->get(); // Jangan konversi menjadi array dulu

       // Gabungkan hasil
       // Gabungkan hasil menggunakan concat
       $pengajuan_anggaran = $provinces_budget->concat($regency_budget)->concat($departement_request)->concat($division_request);
       $pengajuan_anggaran = $pengajuan_anggaran->sortByDesc('updated_at'); 
        if ($request->ajax()) {
            return DataTables::of($pengajuan_anggaran)
            ->addIndexColumn()
            ->make(true);
        }

       // Pengeluaran default harian untuk masing-masing scope
       if (Auth::user()->role === "departement") {
            $expenditureProvince = ProvinceBudgetRequest::where('status', 'approved')
            ->where('province_id', Auth::user()->province_id)
            ->whereDate('created_at', Carbon::today())
            ->sum('budget');
       }else{
           $expenditureProvince = ProvinceBudgetRequest::where('status', 'approved')
           ->whereDate('created_at', Carbon::today())
           ->sum('budget');
       }
       if (Auth::user()->role === "departement" || Auth::user()->role === "province") {
           $expenditureRegency = RegencyBudgetRequest::where('status', 'approved')
               ->where('regency_city_id', Auth::user()->regency_city_id)
               ->whereDate('created_at', Carbon::today())
               ->sum('budget');
            }else{
           $expenditureRegency = RegencyBudgetRequest::where('status', 'approved')
               ->whereDate('created_at', Carbon::today())
               ->sum('budget');
             }
    
    $expenditureDep = DepartementBudgetRequest::where('status', 'approved')
        ->whereDate('created_at', Carbon::today())
        ->sum('budget');

    $expenditureDivision = DivisionBudgetRequest::where('status', 'approved')
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
               
           case 'division_monthly':
               $expenditureDivision = $this->calculateExpenditure(DivisionBudgetRequest::class, 'monthly');
               break;
           case 'division_yearly':
               $expenditureDivision = $this->calculateExpenditure(DivisionBudgetRequest::class, 'yearly');
               break;
       }
   }

   if (Auth::user()->role === "departement") {
    $amount_prov = $pengajuan_anggaran->where('status', 'approved')
                ->where('province_id', Auth::user()->province_id)
                ->sum('budget');
    $amount_reg = $pengajuan_anggaran->where('status', 'approved')
                ->Where('regency_city_id', Auth::user()->regency_city_id)
                ->sum('budget');
    $amount = $amount_prov + $amount_reg;
   }else{
       $amount = $pengajuan_anggaran->where('status', 'approved')
                   ->sum('budget');
   }

    // chart
    $province_budget_chart = [];
    for ($i = 1; $i <= 12; $i++) {
        $province_budget = ProvinceBudgetRequest::where('status', 'approved')
             ->whereMonth('updated_at', $i)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('budget');
        $province_budget_chart[] = $province_budget;
    }

    $regency_budget_chart = [];
    for ($i = 1; $i <= 12; $i++) {
        $regency_budget = RegencyBudgetRequest::where('status', 'approved')
            ->whereMonth('created_at', $i)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('budget');
        $regency_budget_chart[] = $regency_budget;
    }

    $departement_budget_chart = [];
    for ($i = 1; $i <= 12; $i++) {
        $departement_budget = DepartementBudgetRequest::where('status', 'approved')
            ->whereMonth('created_at', $i)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('budget');
        $departement_budget_chart[] = $departement_budget;
    }

    $division_budget_chart = [];
    for ($i = 1; $i <= 12; $i++) {
        $division_budget = DivisionBudgetRequest::where('status', 'approved')
            ->whereMonth('created_at', $i)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('budget');
        $division_budget_chart[] = $division_budget;
    }



    // Role Province
    $province_regency = RegencyCity::with('province')->where('province_id', Auth::user()->province_id)->get();
    $name_regency = [];
    for ($i=0; $i < count($province_regency) ; $i++) { 
        // ambil nama regency
        $name_regency[] = $province_regency[$i]->name;
            // Bungkus setiap elemen dengan tanda kutip ganda
        $quoted_regency = array_map(function($item) {
            return "\"$item\"";
        }, $name_regency);
        $budget_per_regency[] = RegencyBudgetRequest::where('regency_city_id', $province_regency[$i]->id)
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('budget');
        $budget_per_regency_str = implode(', ', $budget_per_regency);
    }
    $name_regency_str = implode(', ', $quoted_regency);
    // dd($name_regency);

    // Province Role Departemen
    $province_budget_departemen_chart = [];
    for ($i = 1; $i <= 12; $i++) {
        $province_budget_departemen = ProvinceBudgetRequest::whereMonth('created_at', $i)
            ->where('province_id', Auth::user()->province_id)
            ->where('status', 'approved')
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('budget');
        $province_budget_departemen_chart[] = $province_budget_departemen;
    }

    // dd($budget_per_regency_str);
   // Return hasil ke view
   return view('dashboard.index', compact('expenditureProvince', 'expenditureRegency', 'expenditureDep','expenditureDivision','amount', 'pengajuan_anggaran','province_budget_chart','regency_budget_chart','departement_budget_chart','division_budget_chart','name_regency_str','budget_per_regency_str','province_budget_departemen_chart'));
    }
}

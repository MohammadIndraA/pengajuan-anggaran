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
    //    approved all table
   $approved = DB::table('province_budget_requests')
                ->select(
                    'budget',
                    'status',
                    'province_id',
                    DB::raw('NULL as regency_city_id')
                )
                ->where('status', 'approved') // Kondisi WHERE di sini
                ->unionAll(
                    DB::table('regency_budget_requests')
                        ->select(
                            'budget',
                            'status',
                            DB::raw('NULL as province_id'),
                            'regency_city_id'
                        )
                        ->where('status', 'approved') // Kondisi WHERE di sini
                )
                ->unionAll(
                    DB::table('departement_budget_requests')
                        ->select(
                            'budget',
                            'status',
                            DB::raw('NULL as province_id'),
                            'regency_city_id'
                        )
                        ->where('status', 'approved') // Kondisi WHERE di sini
                )
                ->get();
    $amount = $approved->sum('budget');
   // Return hasil ke view
   return view('dashboard.index', compact('expenditureProvince', 'expenditureRegency', 'expenditureDep','amount'));
    }
}

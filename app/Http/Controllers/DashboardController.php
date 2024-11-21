<?php

namespace App\Http\Controllers;

use App\Models\DepartementBudgetRequest;
use App\Models\ProvinceBudgetRequest;
use App\Models\RegencyBudgetRequest;
use App\Services\CalculateServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    
    public function index(Request $request, CalculateServices $expenditureService)
    {
        $type = $request->type ?? 'daily';

        // Province
        $provincial_expenditure = $expenditureService->calculateExpenditure(
            ProvinceBudgetRequest::class, 
            'approved', 
            $request->type
        );

        // regency 
        $regency_expenditure = $expenditureService->calculateExpenditure(
            RegencyBudgetRequest::class, 
            'approved', 
            $request->type
        );

        // departemnet
        $departement_expenditure = $expenditureService->calculateExpenditure(
            DepartementBudgetRequest::class, 
            'approved', 
            $request->type
        );
       

        return view('dashboard.index', compact('provincial_expenditure', 'regency_expenditure', 'departement_expenditure'));
    }
}

<?php

namespace App\Services;

use Carbon\Carbon;

class ExpenditureService
{
    public function calculateExpenditure($model, $status, $type)
    {
        $query = $model::where('status', $status);

        switch ($type) {
            case "daily":
                $query->whereDate('created_at', Carbon::today());
                break;

            case "monthly":
                $query->whereYear('created_at', Carbon::now()->year)
                      ->whereMonth('created_at', Carbon::now()->month);
                break;

            case "yearly":
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        return $query->sum('budget');
    }
}

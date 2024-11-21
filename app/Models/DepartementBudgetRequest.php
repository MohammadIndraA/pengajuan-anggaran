<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartementBudgetRequest extends Model
{
    protected $table = 'departement_budget_requests';
    protected $guarded = ['id'];
    public function funding_source()
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function regency_city()
    {
        return $this->belongsTo(RegencyCity::class);
    }
}

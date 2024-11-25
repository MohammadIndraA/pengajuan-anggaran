<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionBudgetRequest extends Model
{
    protected $table = 'division_budget_requests';

    protected $guarded = ['id'];

    public function funding_source()
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function regency_city()
    {
        return $this->belongsTo(RegencyCity::class);
    }
    public function proposal_file()
    {
        return $this->belongsTo(ProposalFiles::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}

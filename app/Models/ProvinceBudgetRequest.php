<?php

namespace App\Models;

use App\Imports\ProvinceImport;
use App\Models\ProvinceImport as ModelsProvinceImport;
use Illuminate\Database\Eloquent\Model;

class ProvinceBudgetRequest extends Model
{
    protected $table = 'province_budget_requests';
    protected $guarded = ['id'];


    public function ProvinceImports()
    {
        return $this->hasMany(ModelsProvinceImport::class);
    }

    public function funding_source()
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function proposal_file()
    {
        return $this->belongsTo(ProposalFiles::class);
    }

}

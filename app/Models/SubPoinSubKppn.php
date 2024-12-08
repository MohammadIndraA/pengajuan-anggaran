<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubPoinSubKppn extends Model
{
    protected $guarded = ['id'];
    
    public function kppnKategori()
    {
        return $this->belongsTo(PointKppn::class);
    }
}

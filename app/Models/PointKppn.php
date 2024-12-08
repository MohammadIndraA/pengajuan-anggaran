<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointKppn extends Model
{
    protected $guarded = ['id'];
    
    public function kppn()
    {
        return $this->belongsTo(Kppn::class);
    }
    
    public function kppnDetails()
    {
        return $this->hasMany(SubPoinSubKppn::class);
    }
}

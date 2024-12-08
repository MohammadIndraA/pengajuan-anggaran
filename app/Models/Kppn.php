<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kppn extends Model
{
    protected $guarded = ['id'];
    
    public function detail()
    {
        return $this->belongsTo(SubPoinSubComponent::class);
    }
    
    public function kppnKategoris()
    {
        return $this->hasMany(PointKppn::class);
    }
}

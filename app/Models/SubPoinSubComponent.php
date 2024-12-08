<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubPoinSubComponent extends Model
{
    protected $guarded = ['id'];
    
    public function point()
    {
        return $this->belongsTo(PointSubComponent::class);
    }
    
    public function kppns()
    {
        return $this->hasMany(Kppn::class);
    }

}

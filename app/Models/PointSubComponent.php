<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointSubComponent extends Model
{
    protected $guarded = ['id'];
    
    public function subkomponen()
    {
        return $this->belongsTo(SubComponent::class);
    }
    
    public function details()
    {
        return $this->hasMany(SubPoinSubComponent::class);
    }
}
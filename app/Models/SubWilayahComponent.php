<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubWilayahComponent extends Model
{
    protected $guarded = ['id'];
    protected $table = 'sub_wilayah_components';

    public function pointSubComponent()
    {
        return $this->belongsTo(PointSubComponent::class);
    }
}

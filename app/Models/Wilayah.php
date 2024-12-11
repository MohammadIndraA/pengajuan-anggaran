<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayahs';
    protected $guarded = ['id'];

    public function poinSubKomponen()
    {
        return $this->belongsTo(PointSubComponent::class);
    }

    public function subWilayah()
    {
        return $this->hasMany(SubWilayah::class);
    }

}

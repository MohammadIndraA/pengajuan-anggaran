<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegencyCity extends Model
{
    protected $table = 'regency_cities';

    protected $fillable = [
        'name',
        'province_id',
    ];

    protected $with = [
        'province'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}

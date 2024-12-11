<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubWilayah extends Model
{
    protected $guarded = ['id'];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}

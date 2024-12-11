<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'components';
    protected $guarded = ['id']; 

    public function subKomponen()
    {
        return $this->hasMany(SubComponent::class);
    }
}

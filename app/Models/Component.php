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

    public function scopeWithFullDetails($query, $model, $model_id, $id)  
    {  
        return $query  
            ->leftJoin($model, "components.{$model_id}", '=', "{$model}.id")  
            ->leftJoin('programs', 'components.program_id', '=', 'programs.id')  
            ->leftJoin('kros', 'components.kro_id', '=', 'kros.id')  
            ->leftJoin('activities', 'components.activity_id', '=', 'activities.id')  
            ->leftJoin('satkers', 'components.satker_id', '=', 'satkers.id')  
            ->leftJoin('ros', 'components.ro_id', '=', 'ros.id')   
            ->where("components.{$model_id}", $id)  
            // ->where("{$model}.status", 'approved')  
            ->select([  
                'components.*',  
                'programs.program_name as program_name',  
                'kros.kro_name as kro_name',  
                'activities.activity_name as activity_name',  
                'ros.ro_name as ro_name',  
                'satkers.satker_name as satker_name',  
                'satkers.satker_total as satker_total',  
                'satkers.wilayah_name as wilayah_name',  
                'satkers.wilayah_total as wilayah_total',  
            ]);  
    }
}

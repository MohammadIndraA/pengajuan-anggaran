<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
                'programs.program_code as program_code',  
                'programs.program_name as program_name',  
                'programs.total as program_total',  
                'kros.kro_code as kro_code',  
                'kros.kro_name as kro_name',  
                'kros.qty as kro_qty',  
                'kros.satuan as kro_satuan',  
                'kros.total as kro_total',  
                'activities.activity_code as activity_code',  
                'activities.activity_name as activity_name',  
                'activities.total as activity_total',  
                'ros.ro_code as ro_code',  
                'ros.ro_name as ro_name',  
                'ros.qty as ro_qty',  
                'ros.satuan as ro_satuan',  
                'ros.total as ro_total',
                'satkers.satker_name as satker_name',  
                'satkers.satker_total as satker_total',  
                'satkers.wilayah_name as wilayah_name',  
                'satkers.wilayah_total as wilayah_total', 
            ]);  
    }
}

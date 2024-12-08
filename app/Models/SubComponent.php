<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubComponent extends Model
{
    protected $guarded = ['id'];
    
    public function points()
    {
        return $this->hasMany(PointSubComponent::class);
    }

    public function scopeWithFullDetails($query, $model , $model_id, $id)
    {
        return $query
            ->leftJoin('programs', 'sub_components.program_id', '=', 'programs.id')
            ->leftJoin($model, "sub_components.{$model_id}", '=', "{$model}.id")  
            ->leftJoin('kros', 'sub_components.kro_id', '=', 'kros.id')
            ->leftJoin('activities', 'sub_components.activity_id', '=', 'activities.id')
            ->leftJoin('ros', 'sub_components.ro_id', '=', 'ros.id')
            ->leftJoin('point_sub_components', 'sub_components.id', '=', 'point_sub_components.sub_component_id')
            ->leftJoin('sub_poin_sub_components', 'point_sub_components.id', '=', 'sub_poin_sub_components.point_sub_component_id')
            ->leftJoin('kppns', 'sub_poin_sub_components.id', '=', 'kppns.sub_poin_sub_component_id')
            ->leftJoin('point_kppns', 'kppns.id', '=', 'point_kppns.kppn_id')
            ->leftJoin('sub_poin_sub_kppns', 'point_kppns.id', '=', 'sub_poin_sub_kppns.point_kppn_id')
            ->where("sub_components.{$model_id}", $id)  
            ->select([
                'sub_components.*',
                'programs.program_name as program_name',
                'kros.kro_name as kro_name',
                'activities.activity_name as activity_name',
                'ros.ro_name as ro_name',
                'point_sub_components.id as point_sub_component_id',
                'point_sub_components.point_sub_component_name as point_sub_component_name',
                'sub_poin_sub_components.id as sub_poin_sub_component_id',
                'sub_poin_sub_components.sub_poin_sub_component_name as sub_poin_sub_component_name',
                'kppns.id as kppn_id',
                'kppns.kppn_name as kppn_name',
                'point_kppns.id as point_kppn_id',
                'point_kppns.point_kppn_name as point_kppn_name',
                'sub_poin_sub_kppns.id as sub_poin_sub_kppn_id',
                'sub_poin_sub_kppns.sub_poin_sub_kppn_name as sub_poin_sub_kppn_name',
            ]);
        }
}

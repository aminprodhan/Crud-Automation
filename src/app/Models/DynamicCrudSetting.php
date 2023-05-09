<?php

namespace Aminpciu\CrudAutomation\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicCrudSetting extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function form_details(){
        return $this->hasMany(DynamicCrudFormDetail::class,"dynamic_crud_settings_id")->orderBy("sort_id","asc");
    }
    public function formRelations(){
        return $this->hasMany(DynamicCrudFormDetail::class,"dynamic_crud_settings_id")->whereNotNull("relation_name")->groupBy("relation_name");
    }
    public function getTableCondAttribute($value)
    {
        return json_decode($value);
    }
    public function getStyleCustomAttribute($value)
    {
        return json_decode($value);
    }
}

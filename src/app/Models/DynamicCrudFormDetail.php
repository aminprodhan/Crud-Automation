<?php

namespace Aminpciu\CrudAutomation\app\Models;

use App\Models\Inventory\Setup\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DynamicCrudFormDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    public function getDbInfoAttribute($value)
    {
        return json_decode($value);
    }
    public function getEventActionsAttribute($value)
    {
        return json_decode($value);
    }
    public function getParent(){
        return $this->belongsTo(Category::class,"parent_id");
    }
}

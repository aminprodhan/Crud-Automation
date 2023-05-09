<?php
namespace Aminpciu\CrudAutomation\app\Models;
use Illuminate\Database\Eloquent\Model;

class DynamicModel extends Model
{
    protected $fillable = [];
    protected $guarded=[];
    // Constructor to set the table name and fillable fields
    public function __construct($table, $fillable = [])
    {
        $this->table = $table;
        //$this->fillable = $fillable;
        parent::__construct();
    }

    // Dynamically set the table name
    public function setTable($table)
    {
        $this->table = $table;
    }

    // Dynamically set the fillable fields
    public function setFillable($fillable)
    {
        $this->fillable = $fillable;
    }
}

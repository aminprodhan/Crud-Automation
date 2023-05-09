<?php

namespace Aminpciu\CrudAutomation\app\Repository;
use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
use Aminpciu\CrudAutomation\app\Interfaces\CrudConfigInterface;
use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
use Illuminate\Support\Facades\DB;
class CrudConfigRepository extends BaseRepository implements CrudConfigInterface{
    public function __construct()
    {
        $model='Aminpciu\CrudAutomation\app\Models\DynamicCrudAutoConfig';
        $this->setModel($model);
    }
    public function store(){
        $request=request();
        $find=$this->model;
        $this->model->updateOrCreate(
            ['id' => 1],
            [
                "navbar_title" => $request->navbar_title,
                "middleware" => $request->middleware_name,
            ]
        );
        return 1;
        //dd($this->model->firs());
    }
}

?>

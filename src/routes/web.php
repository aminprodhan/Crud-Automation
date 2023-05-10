<?php

use Aminpciu\CrudAutomation\app\Controllers\CrudController;
use Aminpciu\CrudAutomation\app\Controllers\CrudSetupController;
use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Aminpciu\CrudAutomation\app\Helper\CommonTrait;


$def_middleware=['web','aminpciu-package-middleware-group'];
Route::get('config/crud-automation', [CrudSetupController::class,'config'])->name('crud-automation.aminpciu');
Route::post('config/crud-automation', [CrudSetupController::class,'storeConfig'])->name('crud-automation.aminpciu.store');
Route::get('crud-auto/index', [CrudSetupController::class,'index'])->middleware($def_middleware)->name('crud-automation.aminpciu.index');
Route::post('crud-automation/aminpciu/input/truncate', [CrudSetupController::class,'truncate'])->middleware($def_middleware);
Route::post('crud-automation/aminpciu/input/migrate-fresh', [CrudSetupController::class,'migrateFresh'])->middleware($def_middleware);
Route::post('crud-automation/aminpciu/crud/create', [CrudSetupController::class,'store']);
Route::get('crud-automation/aminpciu/crud/table-columns', [CrudSetupController::class,'getTableColumns']);
if(Schema::hasTable('dynamic_crud_settings')) {
    $rGroups=DynamicCrudSetting::get()->groupBy("middleware_name");
    foreach ($rGroups as $middleware => $value) {
        $variableMainRoute=collect($value->toArray())->pluck('route_name');
        foreach ($variableMainRoute as $key => $value) {
            Route::get(str_replace('.','/',$value).'/index', [CrudController::class,'index'])->middleware($def_middleware)->name($value.'.index');
            Route::get(str_replace('.','/',$value).'/create', [CrudController::class,'create'])->middleware($def_middleware)->name($value.'.create');
            Route::get(str_replace('.','/',$value).'/edit', [CrudController::class,'findById'])->middleware($def_middleware)->name($value.'.edit');
            Route::post(str_replace('.','/',$value).'/store', [CrudController::class,'store'])->middleware($def_middleware)->name($value.'.store');
            Route::post(str_replace('.','/',$value).'/delete', [CrudController::class,'delete'])->middleware($def_middleware)->name($value.'.delete');
            Route::post(str_replace('.','/',$value).'/file-remove', [CrudController::class,'handleFileRemove'])->middleware($def_middleware)->name($value.'.file-remove');
        }
    }
}


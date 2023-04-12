<?php

use Aminpciu\CrudAutomation\app\Controllers\CrudController;
use Aminpciu\CrudAutomation\app\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('inspire', Aminpciu\CrudAutomation\app\Controllers\InspirationController::class);
Route::get('inspire/test', [CrudController::class,'index']);
Route::get('config/table-columns', [CrudController::class,'getTableColumns']);
Route::post('crudautomation/aminpciu/crud/create', [CrudController::class,'store']);

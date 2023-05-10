<?php

namespace Aminpciu\CrudAutomation\app\Repository;
use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
use Aminpciu\CrudAutomation\app\Interfaces\CrudConfigInterface;
use Aminpciu\CrudAutomation\app\Interfaces\CrudInputInterface;
use Aminpciu\CrudAutomation\app\Jobs\InitialDataImport;
use Aminpciu\CrudAutomation\app\Lib\GenerateMigrationClass;
use Aminpciu\CrudAutomation\app\Models\DynamicCrudFormDetail;
use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrudInputRepository extends BaseRepository implements CrudInputInterface{
    public $GenerateMigrationClass='';
    public function __construct(GenerateMigrationClass $GenerateMigrationClass)
    {
        $this->setRequest(request());
        $this->GenerateMigrationClass=$GenerateMigrationClass;
    }
    public function store(){
        $request=request();
        $migrateStatus=0;
        $validate_field=[
            "form_name" => "required",
            "model_name" => "required",
            "table_name" => "required",
            "route_name" => "required",
        ];
        $request->validate($validate_field);
        $req_data=$request->all();
        $db_info=$this->GenerateMigrationClass->getMigrationFields($req_data['fields']);
        $db_migr=$db_info['migr_fields'];
        $db_fields=$db_info['db_fields'];
        $init_params=[
            'init_params' => $req_data,
            'fields' => $db_migr
        ];
        //$array_data = eval('return '.$req_data["db"]["init_data"].';');
        //dd($array_data);
        $res['status']=500;$res['message']='Something went wrong!!';
            try {
                DB::beginTransaction();
                $model='App\Models\User';
                $isExist=null;
                if(!empty($req_data['id']))
                    $isExist=DynamicCrudSetting::find($req_data['id']);
                $tableCond=[
                    "where_con" => $request['db']['where_con'],
                    "where_in" => $request['db']['where_in'] ?? '',
                    "where_not_in" => $request['db']['where_not_in'] ?? '',
                    "where_has" => $request['db']['where_has'],
                    "where_doesnt_have" => $request['db']['where_doesnt_have'],
                    "where_null" => $request['db']['where_null'],
                    "where_not_null" => $request['db']['where_not_null'],
                    "order_by" => $request['db']['order_by'],
                    "group_by" => $request['db']['group_by'],
                    "init_data" => json_encode($request['db']['init_data']),
                    "row_per_page" => $request['db']['row_per_page'],
                    ];
                    if(!empty($req_data['style']['css']))
                    {
                        $req_data['style']['css']=nl2br($req_data['style']['css']);
                        $req_data['style']['css_index']=nl2br($req_data['style']['css_index']);
                    }
                    $crud_data=[
                    "form_name" => $req_data['form_name'],
                    "table_name" => $req_data['table_name'],
                    "model_name" => $req_data['model_name'],
                    "route_name" => $req_data['route_name'],
                    "middleware_name" => $req_data['middleware_name'],
                    "style_custom" => json_encode($req_data['style']),
                    "has_timestamp" => $req_data['timestamp'],
                    "has_softdelete" => $req_data['soft_delete'],
                    "log" => HelperTrait::getReqInfo($request),
                    "table_cond" => json_encode($tableCond),
                ];
                if(!empty($req_data['migrate_status']) && empty($req_data['id'])){
                    $crud_data['migrate_status']=1;
                    $crud_data['migration_path']=$req_data['migration_path'];
                    //$crud_data['migration_name']=$this->GenerateMigrationClass->migration_name;
                }
                else if(!empty($req_data['id'])
                    && !empty($req_data['migrate_status'])
                        && empty($isExist->migrate_status)){
                    $crud_data['migrate_status']=1;
                    $crud_data['migration_path']=$req_data['migration_path'];
                    //$crud_data['migration_name']=$this->GenerateMigrationClass->migration_name;
                }
                else if(!empty($req_data['id'])
                    && !empty($req_data['migrate_status'])
                        && !empty($isExist->migrate_status)){
                            $crud_data['migrate_status']=1;
                        }

                if(!empty($crud_data['migrate_status'])){
                    if(empty($isExist->migrate_status))
                        $migrateStatus=1;
                    $this->GenerateMigrationClass
                        ->init($init_params)
                        ->makeMigration()
                        ->makeModel()
                        ->create($isExist);
                    $crud_data['migration_name']=$isExist->migration_name ?? $this->GenerateMigrationClass->migration_name;

                }
                $model=DynamicCrudSetting::updateOrCreate(
                    ['id' => $req_data['id'] ?? null],
                    $crud_data
                );
                $lastRecordId = $model->id;
                DynamicCrudFormDetail::where("dynamic_crud_settings_id",$lastRecordId)->update(["status" => 2]);
                $crud_details_data=HelperTrait::updateValueOfKeys($db_fields,['dynamic_crud_settings_id' => $lastRecordId]);
                foreach($crud_details_data as $row){
                    DynamicCrudFormDetail::updateOrCreate(
                        ['id' => $row['id'] ?? null],
                        $row,
                    );
                }
                DynamicCrudFormDetail::where("dynamic_crud_settings_id",$lastRecordId)->where("status",2)->delete();
                DB::commit();
                if(!empty($req_data["db"]["init_data"])){
                    $array_data = eval('return '.$req_data["db"]["init_data"].';');
                    dispatch(new InitialDataImport($array_data,$req_data['table_name']));
                }
                    $res['status_code']=200;
            }
            catch (\Throwable $error) {
                DB::rollBack();
                $res['message']=($error->getMessage());
                $res['status_code']=500;
            }
            if(!empty($migrateStatus)){
                //if(Schema::hasTable($req_data['table_name'])) {
                Artisan::call('migrate', [
                    '--path' => $this->GenerateMigrationClass->migratePath,
                ]);
                //}
            }
        return $res;
    }
    public function remove(){

    }
    public function truncate(){
        $request=$this->requestData;
        $info=HelperTrait::getRouteInfo($request,$request->id);
        $form_info=$info['form_info'];
        $model=HelperTrait::getModelInfo($form_info);
        $model::truncate();
        return 1;
    }
    public function migrateFresh(){
        $request=$this->requestData;
        $info=HelperTrait::getRouteInfo($request,$request->id);
        $form_info=$info['form_info'];
        $basePath='/database/migrations/';
        if(!empty($form_info->migration_path))
            $basePath.=$form_info->migration_path."/";
        $path=$basePath."".$form_info->migration_name;

        // Artisan::call('migrate:fresh', [
        //     '--path' => $path,
        // ]);
    }
}

?>

<?php
    namespace Aminpciu\CrudAutomation\app\Lib;
    use Illuminate\Support\Facades\File;
    use Aminpciu\CrudAutomation\app\Lib\Migrate;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

    class GenerateMigrationClass extends Migrate{
        public function init($params){
            foreach($params as $key => $val){
                if(!empty($val))
                    $this->$key=$val;
            }
            $this->setModelAndNameSpace($params['init_params']['model_name']);
            return $this;
        }
        public function create($isExist){
            $path=$this->migration_path;
            $content=$this->migration_content;

            $model_path=$this->model_path;
            $model_content=$this->model_content;

            $migration_status=$this->init_params['migration_status'];
            $model_status=$this->init_params['model_status'];
            if(!empty($model_status) ){
                if(!File::isDirectory($this->model_folder)){
                    File::makeDirectory($this->model_folder, 0777, true, true);
                }
                //dd($this->model_path);
                $fileExists = File::exists($this->model_path);
                if(!$fileExists){
                    File::put($model_path, $model_content);
                }

            }

            if(!File::isDirectory($this->migration_folder)){
                File::makeDirectory($this->migration_folder, 0777, true, true);
            }
            //dd($this->migration_folder);
            if($isExist && !empty($isExist->migration_name) && !empty($migration_status)){
                //$repPath=str_replace('/', '\\', $isExist->migration_name);
                //$repPathFolder=str_replace('/', '\\', $this->migration_folder);

                $existLoc=$this->migration_base_folder;
                if(!empty($isExist->migration_path))
                    {
                        $exp=explode("/",$isExist->migration_path);
                        $existLoc.='\\'.implode('\\',$exp);
                    }
                $fpath=$existLoc."\\".$isExist->migration_name;
                $fileExists = File::exists($fpath);
                //dd($fileExists);
                if($fileExists)
                    {
                        File::put($fpath, $content);
                    }
                // else{
                //     $sourcePath=($isExist->migration_path ?? $this->migration_base_folder).'\\'.$isExist->migration_name;
                //     $destinationPath=$fpath;
                //     $fileExists = File::exists($sourcePath);
                //     if($fileExists)
                //         File::move($sourcePath, $destinationPath);
                // }
            }
            else{
                if(!empty($migration_status)){
                    File::put($path, $content);
                }
            }
            return 1;
        }
        public function getMigrationFields($data){
            $res['migr_fields'] =[];
            $res['db_fields'] =[];
            foreach($data as $field){

                if(empty($field['label_name']))
                    continue;

                $db_info=[
                    "nullable" => $field['nullable'],
                    "index_db" => ["index_name" => $field['index_db']['index_name'],"index_type" => $field['index_db']['index_type']],
                    "comments" => $field['comments'],
                    "default_value" => $field['default_value'],
                    "data_length" => $field['data_length'],
                    "field_type" => $field['field_type'],
                    "file_location" => $field['file_location'],
                    "field_name" => $field['field_name'],
                    "auto_code" => $field['auto_code'],
                ];
                $event_actions=[
                    "name" => '',
                    "api" => '',
                    "selector" => '',
                    "ref_selector" => '',
                ];
                if((!empty($field['event']['name']) && !empty($field['event']['api'] && $field['event']['selector'])) || ($field['event']['ref_selector'])){
                    $event_actions=[
                        "name" => $field['event']['name'],
                        "api" => $field['event']['api'],
                        "selector" => trim($field['event']['selector']),
                        "method" => $field['event']['method'] ?? '',
                        "ref_selector" => trim($field['event']['ref_selector']) ?? '',
                    ];
                }

                $crud_details_data=[
                    "id" => $field['id'] ?? null,
                    "sort_id" => $field['sort_id'],
                    "dynamic_crud_settings_id" => null,
                    "label_name" => $field['label_name'],
                    "input_type" => $field['input_type'],
                    "display_type" => $field['display_type'],
                    "validation" => $field['validation'],
                    "filterable" => $field['filterable'] ?? 0,
                    "field_name" => $field['field_name'],
                    "relation_name" => $field['relation_name'],
                    "status" => 1,
                    "session_name_func" => $field['session_name_func'],
                    "event_actions" => json_encode($event_actions),
                    "db_info" => json_encode($db_info),
                ];

                if(!empty($field['options_data']))
                    {
                        $crud_details_data['options']=$field['options_data'];
                        $crud_details_data['options_data_type']=1;
                    }
                else if(!empty($field['options_query']))
                    {
                        $crud_details_data['options']=$field['options_query'];
                        $crud_details_data['options_data_type']=2;
                    }
                else if(!empty($field['options_api']))
                    {
                        $crud_details_data['options']=$field['options_api'];
                        $crud_details_data['options_data_type']=3;
                    }

                array_push($res['db_fields'],$crud_details_data);

                if(empty($field['field_name']))
                    continue;

                $ara=[];
                $ara['name']=$field['field_name'];
                if(!empty($field['data_length']))
                    $ara['length']=$field['data_length'];

                if(!empty($field['default_value']))
                    $ara['options']['default']=$field['default_value'];

                if(!empty($field['nullable']))
                    $ara['options']['nullable']=1;

                if(!empty($field['comments']))
                    $ara['options']['comments']=$field['comments'];
                $index_status=0;
                if(!empty($field['index_db']['index_type']))
                    {
                        if($field['index_db']['index_type'] == 'index' && !empty($field['index_db']['index_name']))
                            $index_status=1;

                        if($field['index_db']['index_type'] == 'unique')
                            $ara['options']['unique']=true;
                        if($field['index_db']['index_type'] == 'primary' || $ara['name'] == 'id')
                            {
                                $ara['options']['primary_key']=true;
                                if($ara['name'] != 'id')
                                    $ara['options']['primary_key_name']=$ara['name'];
                            }
                    }
                //$table->id('user_id')
                $ara['type']=$field['field_type'];
                array_push($res['migr_fields'],$ara);
                if($index_status){
                    $ara=[];
                    $ara['type']='';
                    $ara['name']=$field['field_name'];
                    $ara['options']['index_name']=$field['index_db']['index_name'];
                    array_push($res['migr_fields'],$ara);
                }

            }
            return $res;
        }
    }

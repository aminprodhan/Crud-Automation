<?php
    namespace Aminpciu\CrudAutomation\app\Helper;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudAutoConfig;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Redirect;

    trait CommonTrait{
        public static function getInputTypes(){
            return [
                [
                    'id' => 'text',
                    'name' => 'Text'
                ],
                [
                    'id' => 'number',
                    'name' => 'Number'
                ],
                [
                    'id' => 'auto_code',
                    'name' => 'Auto Code'
                ],
                [
                    'id' => 'password',
                    'name' => 'Password'
                ],
                [
                    'id' => 'textarea',
                    'name' => 'Textarea'
                ],
                [
                    'id' => 'selection',
                    'name' => 'Selection'
                ],
                [
                    'id' => 'checkbox',
                    'name' => 'Checkbox'
                ],
                [
                    'id' => 'radio',
                    'name' => 'Radio'
                ],
                [
                    'id' => 'datetime-local',
                    'name' => 'Date Time'
                ],
                [
                    'id' => 'date',
                    'name' => 'Date'
                ],
                [
                    'id' => 'time',
                    'name' => 'Time'
                ],
                [
                    'id' => 'image_file',
                    'name' => 'Image/File'
                ],
                [
                    'id' => 'session',
                    'name' => 'Session'
                ],
                [
                    'id' => 'hidden',
                    'name' => 'Hidden'
                ],
                [
                    'id' => 'primary_auto_inc',
                    'name' => 'PK-Auto Increment'
                ],
            ];
        }
        public static function getDisplayTypes(){
            return [
                [
                    'id' => 1,
                    'name' => 'Hide'
                ],
                [
                    'id' => 2,
                    'name' => 'Form & Table'
                ],
                [
                    'id' => 3,
                    'name' => 'Only Form'
                ],
                [
                    'id' => 4,
                    'name' => 'Only Table'
                ],
            ];
        }
        public static function getTableColDataTypes(){
            $columns = [
                'id' => 'bigIncrements',
                'big_integer_col' => 'bigInteger',
                'binary_col' => 'binary',
                'boolean_col' => 'boolean',
                'char_col' => 'char:10',
                'date_col' => 'date',
                'date_time_col' => 'dateTime',
                'decimal_col' => 'decimal:8,2',
                'double_col' => 'double:8,2',
                'enum_col' => "enum:['option1', 'option2', 'option3']",
                'float_col' => 'float:8,2',
                'geometry_col' => 'geometry',
                'geometry_collection_col' => 'geometryCollection',
                'increments_col' => 'increments',
                'integer_col' => 'integer',
                'ip_address_col' => 'ipAddress',
                'json_col' => 'json',
                'jsonb_col' => 'jsonb',
                'line_string_col' => 'lineString',
                'long_text_col' => 'longText',
                'mac_address_col' => 'macAddress',
                'medium_increments_col' => 'mediumIncrements',
                'medium_integer_col' => 'mediumInteger',
                'medium_text_col' => 'mediumText',
                'morphs_col' => 'morphs',
                'multi_line_string_col' => 'multiLineString',
                'multi_point_col' => 'multiPoint',
                'multi_polygon_col' => 'multiPolygon',
                'nullable_uuid_morphs_col' => 'nullableUuidMorphs',
                'point_col' => 'point',
                'polygon_col' => 'polygon',
                'remember_token_col' => 'rememberToken',
                'soft_deletes_col' => 'softDeletes',
                'soft_deletes_tz_col' => 'softDeletesTz',
                'string_col' => 'string',
                'text_col' => 'text',
                'time_col' => 'time',
                'time_tz_col' => 'timeTz',
                'timestamp_col' => 'timestamp',
                'timestamp_tz_col' => 'timestampTz',
                'tiny_increments_col' => 'tinyIncrements',
                'tiny_integer_col' => 'tinyInteger',
                'unsigned_big_integer_col' => 'unsignedBigInteger',
                'unsigned_integer_col' => 'unsignedInteger',
                'unsigned_medium_integer_col' => 'unsignedMediumInteger',
                'unsigned_small_integer_col' => 'unsignedSmallInteger',
                'unsigned_tiny_integer_col' => 'unsignedTinyInteger',
            ];
            $types =[
                [
                    'type' => 'integer',
                    'name' => 'Integer',
                    'group_name' => '',
                ],
                [
                    'type' => 'unsignedInteger',
                    'name' => 'UnsignedInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'tinyInteger',
                    'name' => 'TinyInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'increments',
                    'name' => 'Auto Increments',
                    'group_name' => '',
                ],
                [
                    'type' => 'string',
                    'name' => 'String',
                    'group_name' => '',
                ],
                [
                    'type' => 'smallInteger',
                    'name' => 'SmallInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'mediumInteger',
                    'name' => 'MediumInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'bigInteger',
                    'name' => 'BigInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'unsignedBigInteger',
                    'name' => 'UnsignedBigInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'binary',
                    'name' => 'Binary',
                    'group_name' => '',
                ],
                [
                    'type' => 'boolean',
                    'name' => 'Boolean',
                    'group_name' => '',
                ],
                [
                    'type' => 'char',
                    'name' => 'Char',
                    'group_name' => '',
                ],
                [
                    'type' => 'date',
                    'name' => 'Date',
                    'group_name' => '',
                ],
                [
                    'type' => 'dateTime',
                    'name' => 'DateTime',
                    'group_name' => '',
                ],
                [
                    'type' => 'decimal',
                    'name' => 'Decimal',
                    'group_name' => '',
                ],
                [
                    'type' => 'double',
                    'name' => 'Double',
                    'group_name' => '',
                ],
                [
                    'type' => 'float',
                    'name' => 'Float',
                    'group_name' => '',
                ],
                [
                    'type' => 'enum',
                    'name' => 'Enum',
                    'group_name' => '',
                ],
                [
                    'type' => 'geometry',
                    'name' => 'Geometry',
                    'group_name' => '',
                ],
                [
                    'type' => 'geometryCollection',
                    'name' => 'GeometryCollection',
                    'group_name' => '',
                ],
                [
                    'type' => 'ipAddress',
                    'name' => 'IpAddress',
                    'group_name' => '',
                ],
                [
                    'type' => 'json',
                    'name' => 'Json',
                    'group_name' => '',
                ],
                [
                    'type' => 'longText',
                    'name' => 'Text',
                    'group_name' => '',
                ],
                [
                    'type' => 'mediumText',
                    'name' => 'MediumText',
                    'group_name' => '',
                ],
                [
                    'type' => 'morphs',
                    'name' => 'Morphs',
                    'group_name' => '',
                ],
                [
                    'type' => 'time',
                    'name' => 'Time',
                    'group_name' => '',
                ],
                [
                    'type' => 'timestamp',
                    'name' => 'Timestamp',
                    'group_name' => '',
                ],
                [
                    'type' => 'bigInteger',
                    'name' => 'BigInteger',
                    'group_name' => '',
                ],
                [
                    'type' => 'file',
                    'name' => 'Image/File',
                    'group_name' => '',
                ],
            ];
            return $types;
        }
        public static function getDBTables(){

            //$tables = DB::getConnection()->getDoctrineSchemaManager()->listTableNames();
            $tables = Schema::getAllTables();
            $tables_custom=[];
            foreach($tables as $table){
                $table=(array)$table;
                $array=[];
                //dd($table->)
                $array['table'] = str_replace('Tables_in_'.env('DB_DATABASE'), 'table', $table['Tables_in_'.env('DB_DATABASE')]);
                array_push($tables_custom,$array);
            }
            return $tables_custom;
        }
        public static function getDBTableColumns($table_name){
            return Schema::getColumnListing($table_name);
        }
        public static function getModels(){
            $models = array();
            $files = File::allFiles(app_path());

            foreach ($files as $file) {
                $path = $file->getRealPath();
                $file_name = $file->getRelativePathName();

                    if (substr($file_name, -4) == '.php') {
                        $class_name = substr($file_name, 0, -4);
                        $class_name_exp = explode("\\",$class_name);

                        //dd($model_name);
                        $namespace = str_replace('/', '\\', dirname($file_name));
                        $full_class_name = $namespace.'\\'.$class_name;

                        // $models[$class_name] = $path;
                        if ($class_name_exp[0] == 'Models') {
                            $full_class_name = 'App'.'\\'.$class_name;

                            $array=[];
                            $array['model_path'] = str_replace('App\\Models\\', '', $full_class_name);
                            $array['model_path'] = str_replace('\\', '/', $array['model_path']);


                            $array['model_full_path'] = $full_class_name;
                            $array['model_name'] = $class_name_exp[count(($class_name_exp))-1];
                            $full_class_name = resolve($full_class_name);
                            //$tableName = (new App\Models\User())->getTable();
                            $tableName = $full_class_name->getTable();
                            //dd($full_class_name);
                            $array['table_name'] = $tableName;
                            array_push($models,$array);
                        }
                    }
            }
            //dd($models);
            return $models;
        }
        public static function getModelInfoFromTable($table_name){
            $model=collect(CommonTrait::getModels())->where("table_name",$table_name)->first();
            return $model;
        }
        public static function getDBIndexTypes(){
            $ara=[
                [
                    'name' => "Primary",
                    "value" => "primary"
                ],
                [
                    'name' => "Unique",
                    "value" => "unique"
                ],
                [
                    'name' => "Index",
                    "value" => "index"
                ],
            ];
            return $ara;
        }
        public static function getEventActions(){
            return [
                ["name" => 'onchange',"value" => "onchange"],
                //["name" => 'onkeyup',"value" => "onkeyup"],
            ];
        }
        public static function getConfig(){
            $config=DynamicCrudAutoConfig::first();
            if(empty($config->id))
                return false;
            return $config;
        }
    }
?>

<?php
    namespace Aminpciu\CrudAutomation\app\Controllers;
    use Aminpciu\CrudAutomation\app\Controllers\Controller;
    use Aminpciu\CrudAutomation\app\Lib\GenerateMigrationClass;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
    use Illuminate\Http\Request;
    use ReflectionClass;

    class CrudController extends Controller
    {
        public $GenerateMigrationClass='';
        public function __construct(GenerateMigrationClass $GenerateMigrationClass)
        {
            $this->GenerateMigrationClass=$GenerateMigrationClass;
        }
        public function store(Request $request){

            $db_fields =[];
            $fields=$request->fields;
            foreach($fields as $field){
                if(empty($field['field_name']))
                    continue;
                $ara=[];
                $ara['name']=$field['field_name'];
                if(!empty($field['data_length']))
                    $ara['length']=$field['data_length'];

                if(!empty($field['default_value']))
                    $ara['options']['default']=$field['default_value'];

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
                array_push($db_fields,$ara);
                if($index_status){
                    $ara=[];
                    $ara['type']='';
                    $ara['name']=$field['field_name'];
                    $ara['options']['index_name']=$field['index_db']['index_name'];
                    array_push($db_fields,$ara);
                }

            }
            $init_params=[
                'model_name' => "Test/Hello/ProductInfo", //default-> (app/Models)
                'table_name' => 'products',
                'migration_path' => '', //database_path('migrations/your_desire_folder_name')
                'fields' => $db_fields
            ];
            $res=$this->GenerateMigrationClass
                ->init($init_params)
                ->makeMigration()
                ->makeModel()->create();
            dd($res);
        }
        public function index(){
            $tables=CommonTrait::getDBTables();
            $db_index_types=CommonTrait::getDBIndexTypes();
            //dd($tables);
            $input_types=CommonTrait::getInputTypes();
            $display_types=CommonTrait::getDisplayTypes();
            $data_types=CommonTrait::getTableColDataTypes();
            return view('lca-amin-pciu::index',compact('db_index_types','data_types','input_types','display_types','tables'));
        }
        public function getTableColumns(Request $request){

            $columns=CommonTrait::getDBTableColumns($request->table_name);
            $res['cols']=[];
            foreach($columns as $key => $col){
                $new_string = ucwords(str_replace(array('_', '-'), ' ', $col));
                $array=[];
                $array['field_name']=$col;
                $array['label_name']=$new_string;
                array_push($res['cols'],$array);
            }
            $res['info']=CommonTrait::getModelInfoFromTable($request->table_name);
            return response()->json($res);
        }
    }

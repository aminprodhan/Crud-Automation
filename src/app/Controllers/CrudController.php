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
        public function store(Request $request){
            return response()->json($request->all());
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

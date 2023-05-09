<?php
    namespace Aminpciu\CrudAutomation\app\Controllers;
    use Aminpciu\CrudAutomation\app\Controllers\Controller;
    use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
    use Aminpciu\CrudAutomation\app\Repository\CrudConfigRepository;
    use Aminpciu\CrudAutomation\app\Repository\CrudInputRepository;
    use App\Models\Inventory\Setup\Category;
    use Illuminate\Http\Request;
    class CrudSetupController extends Controller
    {
        public $crudConfigRepository=null;
        public $crudInputRepository=null;
        public function __construct(CrudConfigRepository $crudConfigRepository,CrudInputRepository $crudInputRepository)
        {
            $this->crudConfigRepository=$crudConfigRepository;
            $this->crudInputRepository=$crudInputRepository;
        }
        public function store(Request $request){
            //dispatch(new JobAttendance($apiData,$request->ip_address));
            $res=$this->crudInputRepository->store();
            return response()->json($res['message'],$res['status_code']);
        }
        public function index(){

            //$model = new DynamicModel('dynamic_crud_settings');
            $list=DynamicCrudSetting::with("form_details")->get();
            $tables=CommonTrait::getDBTables();
            $db_index_types=CommonTrait::getDBIndexTypes();
            $event_actions=CommonTrait::getEventActions();
            //dd($tables);
            $input_types=CommonTrait::getInputTypes();
            $display_types=CommonTrait::getDisplayTypes();
            $data_types=CommonTrait::getTableColDataTypes();
            return view('lca-amin-pciu::pages.crud-page',compact('event_actions','list','db_index_types','data_types','input_types','display_types','tables'));
        }
        public function getTableColumns(Request $request){

            $columns=CommonTrait::getDBTableColumns($request->table_name);
            $res['cols']=[];
            foreach($columns as $key => $col){
                $new_string = ucwords(str_replace(array('_', '-'), ' ', $col));
                if($col == 'created_at' || $col == 'updated_at' || $col == 'deleted_at')
                    continue;
                $array=[];
                $array['field_name']=$col;
                $array['label_name']=$new_string;
                array_push($res['cols'],$array);
            }
            $res['info']=CommonTrait::getModelInfoFromTable($request->table_name);
            return response()->json($res);
        }
        public function config(Request $request){
            $config=CommonTrait::getConfig();
            if(!empty($config->id))
                return redirect()->route("crud-automation.aminpciu.index");
            return view('lca-amin-pciu::pages.crud-config',compact('config'));
        }
        public function storeConfig(Request $request){
            $this->crudConfigRepository->store();
            return response()->json("Success",200);
        }
        public function truncate(Request $request){
            try {
                $this->crudInputRepository->truncate();
                $res['message']='Success';
                $res['code']=200;
            }
            catch (\Throwable $error) {
                $res['message']=($error->getMessage());
                $res['code']=500;
            }
            return response()->json($res['message'],$res['code']);
        }
        public function migrateFresh(Request $request){
            try {
                $this->crudInputRepository->migrateFresh();
                $res['message']='Success';
                $res['code']=200;
            }
            catch (\Throwable $error) {
                $res['message']=($error->getMessage());
                $res['code']=500;
            }
            return response()->json($res['message'],$res['code']);
        }
    }

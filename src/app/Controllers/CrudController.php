<?php
    namespace Aminpciu\CrudAutomation\app\Controllers;
    use Aminpciu\CrudAutomation\app\Controllers\Controller;
    use Aminpciu\CrudAutomation\app\Lib\GenerateMigrationClass;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
    use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudFormDetail;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
    use Aminpciu\CrudAutomation\app\Models\DynamicModel;
    use Aminpciu\CrudAutomation\app\Repository\CrudRepository;
    use Illuminate\Cache\Repository;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use ReflectionClass;

    class CrudController extends Controller
    {
        private $crudRepository;
        public function __construct(CrudRepository $crudRepository){
            $this->crudRepository=$crudRepository;
        }
        public function index(Request $request){
            $editable=null;
            $info=HelperTrait::getRouteInfo($request);
            $form_info=$info['form_info'];
            $base_route=$info['base_route'];
            $hasRel=HelperTrait::getRelations($form_info->formRelations);
            $model=HelperTrait::getModelInfo($form_info);
            $list=$this->crudRepository
                ->setModel($model)
                ->indexQuery($form_info)
                ->paginate();
            return view('lca-amin-pciu::pages.crud-list',compact('editable','base_route','form_info','list','hasRel'));
        }
        public function store(Request $request){
            $info=HelperTrait::getRouteInfo($request);
            $form_info=$info['form_info'];
            $model=HelperTrait::getModelInfo($form_info);
            $res=$this->crudRepository->setModel($model)->store();
            return response()->json($res['message'],$res['status_code']);
        }
        public function create(Request $request){
            //dd(HelperTrait::generateAutoCode());
            $info=HelperTrait::getRouteInfo($request);
            $form_info=$info['form_info'];
            $routeIndex=$info['base_route'];
            $editable=null;
            return view('lca-amin-pciu::pages.crud-create',compact('editable','routeIndex','form_info'));
        }
        public function findById(Request $request){
            $reqId=$request->id;
            $info=HelperTrait::getRouteInfo($request);
            $form_info=$info['form_info'];
            $routeIndex=$info['base_route'];
            $model=HelperTrait::getModelInfo($form_info);
            $query = $model::query();
            $editable=$query->find($reqId);
            //dd($editable->name);
            //dd($query->find($reqId));
            return view('lca-amin-pciu::pages.crud-create',compact('editable','routeIndex','form_info'));
            //dd($info);
        }
        public function handleFileRemove(Request $request){
            $reqId=$request->id;
            $colname=$request->colName;
            $info=HelperTrait::getRouteInfo($request);
            $form_info=$info['form_info'];
            $routeIndex=$info['base_route'];
            $model=HelperTrait::getModelInfo($form_info);
            $query = $model::query();
            $editable=$query->find($reqId);
            $form_propertise=$form_info->form_details->where("field_name",$request->colName)->first();
            $file_location=$form_propertise->db_info->file_location ?? '';
            $files=(json_decode($editable->$colname));
            $filterFiles = array_filter($files, function ($var) use($request){
                return ($var != $request->fileName);
            });
            $coll=json_encode(collect($filterFiles)->flatten(1));
            $editable->$colname=$coll;
            $editable->save();
            if (File::exists(public_path($file_location.'/'.$request->fileName))) {
                File::delete(public_path($file_location.'/'.$request->fileName));
            }
            return response()->json("Success",200);
        }
        public function delete(Request $request){
            $info=HelperTrait::getRouteInfo($request);
            $form_info=$info['form_info'];
            $model=HelperTrait::getModelInfo($form_info);
            $res=$this->crudRepository
                ->setModel($model)
                ->delete($request->id);
            return response()->json("Success",200);
        }
    }

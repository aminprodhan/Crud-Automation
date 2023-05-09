<?php
    namespace Aminpciu\CrudAutomation\app\Helper;

    namespace Aminpciu\CrudAutomation\app\Helper;
    use Aminpciu\CrudAutomation\app\Lib\GenerateMigrationClass;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
    use App\Models\Inventory\Setup\Category;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Http;

    trait HelperTrait{
        public static function getModelLocation(){
            $folder=new GenerateMigrationClass();
        }
        public static function getFileNameOfMigr($string){
            $inputString = lcfirst($string);
            // Use regular expression to match each first capital word
            // and replace it with an underscore followed by the lowercase version of the word
            $convertedString = preg_replace_callback('/([A-Z][a-z]+)/', function ($matches) {
                return '_' . strtolower($matches[0]);
            }, $inputString);
            return $convertedString;
        }

        public static function getRouteInfo($request,$formId=null){
            $routeName = $request->route()->getName();
            $exp_route=explode(".",$routeName);
            $routeIndex=implode(".",array_slice($exp_route,0,-1));
            //$form_info=DynamicCrudSetting::with("form_details")->where("route_name",$routeIndex)->first();
            $where=["route_name" => $routeIndex];
            if(!empty($formId))
                $where=["id" => $formId];
            $form_info=self::getFormDetails($where);

            return [
                'form_info' => $form_info,
                'base_route' => $routeIndex,
            ];
            //return $form_info;
        }
        public static function getFormDetails($whereArray){
            return DynamicCrudSetting::
                    with("form_details","formRelations")
                    ->where($whereArray)
                    ->first();
        }
        public static function getRelations($list){
            $rel['rel']=[];
            $rel['rel_data']=[];
            foreach($list as $item){
                $r_name=explode(":",$item->relation_name);
                if(empty($r_name[1]))
                    continue;

                array_push($rel['rel'],$r_name[0]);
                //$ara=[];
                $rel['rel_data'][$item->relation_name]['name']=$r_name[0];
                $rel['rel_data'][$item->relation_name]['sym']=$r_name[2] ?? ' ';
                $rel['rel_data'][$item->relation_name]['cols']=explode(",",$r_name[1]);
                //array_push($rel['rel_data'],$ara);
            }
            return $rel;
        }
        public static function getReqInfo($request){
            $headers = $request->headers->all(); // Returns an array of all headers of the client
            $url = $request->url(); // Returns the request URL
            $method = $request->method(); // Returns the HTTP method used in the request (e.g., GET, POST, PUT, DELETE)
            $ip = $request->ip(); // Returns the IP address of the client
            $request_header= [
                "ip" => $ip,
                "headers" => $headers,
                "url" => $url,
                "method" => $method
            ];
            return json_encode($request_header);
        }
        public static function updateValueOfKeys($array_data,$keyValuePairsToUpdate){
            foreach ($array_data as &$row) {
                foreach ($keyValuePairsToUpdate as $key => $value) {
                    if (array_key_exists($key, $row)) {
                        $row[$key] = $value;
                    }
                }
            }
            return $array_data;
        }
        public static function hasRequiredInValidation($validation,$check=["required"]){
            $exp=explode("|",$validation);
            $status=0;
            foreach($exp as $field){
                $exp=explode(':',$field);
                $check_field=$exp[0];
                foreach ($check as $key => $value) {
                    if($value == $check_field)
                        {
                            $status=1;
                            break;
                        }
                }
            }
            return $status;
        }
        public static function getSelectionNameForDyCrud($item,$id){
            $list=self::getSelectionFormData($item);
            $name='';
            foreach($list as $item){
                if($item->id == $id){
                    $name=$item->name;
                    break;
                }
            }
            return $name;
        }
        public static function getSelectionFormData($item){
            $options=[];
            if($item->options_data_type == 1){
                $array = eval("return [$item->options];");
                foreach ($array as $key => $value) {
                    $ara=[];
                    $ara['id'] = $key;
                    $ara['name']=$value;
                    array_push($options,(object)$ara);
                }
            }
            else if($item->options_data_type == 2){ //api

                $results = DB::select($item->options);
                $ara=[];
                $ara['id'] = 0;
                $ara['name']="Select";
                array_unshift($results,(object)$ara);
                return $results;
            }
            else if($item->options_data_type == 3){ // raw query
                $rep=str_replace('()','',$item->options);
                return call_user_func($rep);
                //if (function_exists($functionName))
            }
            return $options;
        }
        public static function customValidate($request,$validate){
            $cumtomValidateMsg=[
                "required" => "field is required.",
            ];
            $validate=$request->validate($validate,$cumtomValidateMsg);
            dd($validate);
        }
        public static function getModelInfo($form_info,$model=null){
            if(empty($form_info->id) && empty($model))
                return null;

            $model='App\\Models\\'.str_replace('/', '\\', $form_info->model_name ?? $model);
            return $model;
        }
        public static function willDisplayFormInput($value,$type=0){
            //type=1:form_&_table,type=2:form,type=3:table,type=0=hide
            $status=false;
            if($value == 2)
                $status=true;
            else if($value == 3 && $type == 2)
                $status=true;
            else if($value == 4 && $type == 3)
                $status=true;
            return $status;

        }
        public static function generateAutoCode($info,$col_name){
            //SELECT max(CAST(substring(code,5,(length(code)-4-6)) as UNSIGNED)) + 1 as max_code FROM `categories` WHERE 1;

            $auto_code_info=$info->form_details->where("field_name",'code')->first();
            $whereCon=$auto_code_info->db_info->auto_code->where_con;
            $prefix=$auto_code_info->db_info->auto_code->prefix;
            $suffix=$auto_code_info->db_info->auto_code->suffix;
            $start_range=(int)$auto_code_info->db_info->auto_code->start_range;
            $len_prefix=strlen($prefix);
            $len_suffix=strlen($suffix);

            $sql='MAX((CAST(substring('.$col_name.','.($len_prefix+1).',(length('.$col_name.')-'.$len_prefix.'-'.($len_suffix).')) as UNSIGNED)) + 1) as max_no';
            //dd($sql);
            $model=HelperTrait::getModelInfo($info);
            $query = $model::
                selectRaw($sql)
                ->where(function($q) use ($prefix,$suffix,$col_name,$whereCon){
                   if(!empty($prefix))
                        $q->where($col_name,'like',$prefix.'%');
                    if(!empty($suffix))
                        $q->where($col_name,'like','%'.$suffix);

                    if(!empty($whereCon)){
                        $array_where = eval("return [$whereCon];");
                        foreach ($array_where as $key => $value) {
                            $exp=explode(":",$value);
                            $sym="=";
                            if(!empty($exp[1]))
                                $sym=$exp[1];
                            $str_len=strlen($exp[0]);
                            $isFunc=str_replace('()','',$exp[0]);
                            if($str_len != strlen($isFunc) && function_exists($isFunc)){
                                $exp[0]=call_user_func($isFunc);
                            }
                            //dd($key);
                            $q->where($key,$sym,$exp[0] ?? $value);
                        }

                    }
                })
                ->first();
             $maxNo=$query->max_no ?? 1;
             //dd($maxNo);
             return $maxNo > $start_range ? (int)$maxNo : (int)$start_range;
            //dd($maxPrice->first());
        }
    }

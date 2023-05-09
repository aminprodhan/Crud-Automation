<?php
    namespace Aminpciu\CrudAutomation\app\Repository;
    use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
    use Aminpciu\CrudAutomation\app\Interfaces\CrudInterface;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
    use Illuminate\Support\Facades\DB;
    class CrudRepository extends BaseRepository implements CrudInterface{
        public function store(){

            $request=request();
            $form_id=$request->form_id;
            $update_id=$request->update_id ?? null;
            //dd($update_id);
            $formInfo=DynamicCrudSetting::with("form_details")->find($form_id);
            //dd($formInfo->form_details);
            $db_fields=[];$validate_field=null;$db_file_info=null;
            foreach($formInfo->form_details as $form){
                $fname=$form->db_info->field_name;
                if(empty($fname) || $fname == 'id')
                    continue;
                else if($form->input_type == 'session' && $form->session_name_func){
                    $isFunc=str_replace('()','',$form->session_name_func);
                    if(function_exists($isFunc)){
                        $session_value=call_user_func($isFunc);
                    }
                    else{
                        $session_value=session($isFunc);
                    }
                    $db_fields[$fname]=$session_value;
                }
                else if($form->input_type == 'datetime-local')
                    $db_fields[$fname]=$request->$fname ? date('Y-m-d H:i:s',strtotime($request->$fname)) : ($form->db_info->default_value ?? null);
                else if($form->input_type == 'date')
                    $db_fields[$fname]=$request->$fname ? date('Y-m-d',strtotime($request->$fname)) : ($form->db_info->default_value ?? null);
                else if($form->input_type == 'auto_code')
                    $db_fields[$fname]=$form->db_info->auto_code->prefix."".$request->$fname."".$form->db_info->auto_code->suffix;
                else if($form->input_type != 'image_file')
                    $db_fields[$fname]=$request->$fname ?? ($form->db_info->default_value ?? null);
                else
                    {
                        //dd($request->$fname);
                        if($request->$fname && count($request->$fname) > 0){
                            $validate_field[$fname]="required|array";
                            $db_file_info[]=["name"=>$fname,"location" => $form->db_info->file_location];
                            $fname.=".*";
                        }
                    }
                if(!empty($form->validation))
                {
                    $hasUnique=HelperTrait::hasRequiredInValidation($form->validation,['unique']);
                    if(!empty($update_id) && $hasUnique)
                        $form->validation.=','.$update_id;

                    $validate_field[$fname]=$form->validation;
                }
            }
            if($validate_field){
                $request->validate($validate_field);
            }
            $isExist=null;
            if(!empty($update_id)){
                $isExist=$this->model->find($update_id)->toArray();
            }
            if($db_file_info){
                foreach($db_file_info as $item){
                    $files=null;
                    if($isExist)
                        $files=json_decode($isExist[$item['name']]);
                    $files_raw = $request->file($item['name']);
                    foreach ($files_raw as $file) {
                        //$filename = $file->getClientOriginalName();
                        $org_name=str_replace(' ','_',$file->getClientOriginalName());
                        $filename = time() . '_' . $org_name;
                        //$extension = $file->getClientOriginalExtension();
                        //$filename = time() . '.' . $extension;
                        $file->move(public_path($item['location'] ?? ''), $filename);
                        $files[]=$filename;
                    }
                    $db_fields[$item['name']]=json_encode($files);
                }
            }
            //dd($db_file_info);
            $res['message']="Success";
            try {
                DB::beginTransaction();
                    $model=$this->model->updateOrCreate(
                        ['id' => $update_id],
                        $db_fields
                    );
                DB::commit();
                $res['status_code']=200;
                $res['message']=$model->id;
            } catch (\Throwable $error) {
                //throw $th;
                DB::rollBack();
                $res['message']=($error->getMessage());
                $res['status_code']=500;
            }
            return $res;
        }
        public function indexQuery($formInfo){
            //dd($$formInfo);
            $requet=request()->all();
            $res['whereFilter']=[];$res['whereLike']=[];
            foreach($formInfo->form_details as $form){
                $fname=$form->db_info->field_name;
                if(empty($requet[$fname]))
                    continue;
                else if($form->input_type == 'session' || $form->input_type == 'selection'){
                  $res['whereFilter'][$fname]=trim($requet[$fname]);
                }
                else
                    $res['whereLike'][$fname]=trim($requet[$fname]);
            }
            $hasRel=HelperTrait::getRelations($formInfo->formRelations);
            if(count($hasRel['rel']) > 0)
                $this->model=$this->model->with($hasRel['rel']);

            $cond=$formInfo->table_cond;
            $this->model->where(function($q) use($cond){
                    if(!empty($cond->where_con)){
                        $array_where = eval("return [$cond->where_con];");
                        //dd($array_where);
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
                            //dd($sym);
                            $q->where($key,$sym,$exp[0] ?? $value);
                        }

                    }
                    if(!empty($cond->where_null)){
                        $exp=explode(",",$cond->where_null);
                        foreach($exp as $col){
                            $q->whereNull($col);
                        }
                    }
                    if(!empty($cond->where_not_null)){
                        $exp=explode(",",$cond->where_not_null);
                        foreach($exp as $col){
                            $q->whereNotNull($col);
                        }
                    }
            });
            if(count($res['whereFilter']) > 0){
                $this->model->where($res['whereFilter']);
            }
            if(count($res['whereLike']) > 0){
                foreach ($res['whereLike'] as $key => $value) {
                    //dd($value);
                    $this->model->where($key,'like','%'.$value.'%');
                }
            }
            if(!empty($cond->where_in)){
                $exp=explode(";",$cond->where_in);
                foreach ($exp as $key => $value) {
                    $exp_value=explode(":",$value);
                    $array = eval("return [$exp_value[1]];");
                    $this->model->whereIn($exp_value[0],$array);
                }
            }
            if(!empty($cond->where_not_in)){
                $exp=explode(";",$cond->where_not_in);
                foreach ($exp as $key => $value) {
                    $exp_value=explode(":",$value);
                    $array = eval("return [$exp_value[1]];");
                    $this->model->whereNotIn($exp_value[0],$array);
                }
            }
            if(!empty($cond->where_has)){
                $exp=explode(",",$cond->where_has);
                foreach ($exp as $key => $value) {
                    $this->model->whereHas($value, function ($q) {
                        //$this->model->where('approved', false);
                    });
                }
            }
            if(!empty($cond->where_doesnt_have)){
                $exp=explode(",",$cond->where_doesnt_have);
                foreach ($exp as $key => $value) {
                    $this->model->whereDoesntHave($value, function ($q) {
                        //$this->model->where('approved', false);
                    });
                }
            }
            if(!empty($cond->order_by)){
                $array = eval("return [$cond->order_by];");
                foreach ($array as $key => $value) {
                    $this->model->orderBy($key,$value);
                }
            }
            if(!empty($cond->group_by)){
                $exp=explode(",",$cond->group_by);
                foreach ($exp as $key => $value) {
                    $this->model->groupBy($value);
                }
            }
            $per_page=100;
            if(!empty($cond->row_per_page))
                $this->rowPerPage=$cond->row_per_page;
            return $this;
        }
    }
?>

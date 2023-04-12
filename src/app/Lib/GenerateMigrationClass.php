<?php
    namespace Aminpciu\CrudAutomation\app\Lib;
    use Illuminate\Support\Facades\File;
    use Aminpciu\CrudAutomation\app\Lib\Migrate;
    class GenerateMigrationClass extends Migrate{

        public function init($params){
            foreach($params as $key => $val){
                if(!empty($val))
                    {
                        if($key == 'model_name')
                            $this->setModelAndNameSpace($val);
                        else
                            $this->$key=$val;
                    }
            }
            return $this;
        }
        public function setModelAndNameSpace($model){
            $exp=explode("/",$model);
            $len=count($exp);
            // if(!empty($exp[$len-1]))
            //     {
                    //$this->model_path.=$model.'.php';
                    if($len > 1){
                        $this->model_name=$exp[$len-1];
                        $this->model_path.='\\'.implode('\\',$exp).'.php';
                        array_pop($exp);
                        $this->model_folder.='\\'.implode('\\',$exp);
                        $this->model_namespace.='\\'.implode('\\',$exp);
                        //$this->model_path.='\\'.implode('\\',$exp);
                    }
                    else
                        $this->model_name=$model;

                    if(!File::isDirectory($this->model_folder)){
                        File::makeDirectory($this->model_folder, 0777, true, true);
                    }
                //}
            //dd($this->model_path);
        }
        public function create(){

            $path=$this->migration_path;
            $content=$this->migration_content;

            $model_path=$this->model_path;
            $model_content=$this->model_content;

            //dd($this->model_content);


            // // Check if the file exists
            // if (!File::exists($path) && $content) {
            //     // Create the file
            //     File::put($path, $content);
            //     return true;
            // }
            // if (!File::exists($model_path) && $model_content) {
            //     File::put($model_path, $model_content);
            //     return true;
            // }
            return $content;
        }

    }

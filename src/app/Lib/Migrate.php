<?php
    namespace Aminpciu\CrudAutomation\app\Lib;
    use Illuminate\Support\Facades\File;
    use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
    class Migrate{
        public $init_params=null;
        public $table_name='';
        public $migration_path='';
        public $migration_folder='';
        public $migration_base_folder='';
        public $migratePath='';
        public $migration_content='';
        public $migration_name='';
        public $model_name='';
        public $model_path='';
        public $model_namespace='namespace App\Models';
        public $model_content='';
        public $model_folder='';
        public $fields=[];
        public function __construct(){
            $migrationPath = database_path('migrations/');
            $this->migration_path=$migrationPath;
            $this->migratePath='database/migrations';
            $this->migration_base_folder=$migrationPath;
            $this->migration_folder=$migrationPath;
            $this->model_path=base_path('app\Models');
            $this->model_folder=base_path('app\Models');
        }
        public function setModelAndNameSpace($model){
            $exp=explode("/",$model);
            $len=count($exp);
            if($len > 1){
                $this->model_name=$exp[$len-1];
                $this->model_path.='\\'.implode('\\',$exp).'.php';
                array_pop($exp);
                $this->model_folder.='\\'.implode('\\',$exp);
                $this->model_namespace.='\\'.implode('\\',$exp);
            }
            else
                {
                    $this->model_name=$model;
                    $this->model_path.='\\'.$model.'.php';
                }

            //dd($this->model_path);
        }
        public function makeModel(){



            $hasSoftDelete=$this->init_params['soft_delete'];
            //$this->model_name=$this->init_params['model_name'];
            $this->table_name=$this->init_params['table_name'];
            if(empty($this->model_name))
                return false;


            $content = '<?php' . PHP_EOL . PHP_EOL;
            $content .= $this->model_namespace.';' . PHP_EOL;
            $content .= 'use Illuminate\Database\Eloquent\Model;' . PHP_EOL;
            $content .= 'use Illuminate\Database\Eloquent\SoftDeletes;' . PHP_EOL;
            $content .= 'class ' . ucwords($this->model_name) . ' extends Model' . PHP_EOL;
            $content .= '{' . PHP_EOL;
            if($hasSoftDelete)
                $content .= '    use SoftDeletes;' . PHP_EOL;
            $content .= '    protected $guarded=[];' . PHP_EOL;
            $content .= '    protected $table=\''.strtolower($this->table_name).'\';' . PHP_EOL. PHP_EOL;
            $content .= '}' . PHP_EOL;
            $this->model_content=$content;
            return $this;
        }
        public function makeMigration(){


            $this->table_name=$this->init_params['table_name'];
            $migrPath=$this->init_params['migration_path'];
            // if(empty($this->table_name))
            //     return false;

            $migrationClassName = 'Create'.ucfirst($this->model_name).'Table';
            $migrationName = 'create_'.HelperTrait::getFileNameOfMigr($this->model_name).'_table';

            $migration_name = date('Y_m_d_His') . '_' . $migrationName . '.php';


            $content = '<?php' . PHP_EOL . PHP_EOL;
            $content .= 'use Illuminate\Support\Facades\Schema;' . PHP_EOL;
            $content .= 'use Illuminate\Database\Schema\Blueprint;' . PHP_EOL;
            $content .= 'use Illuminate\Database\Migrations\Migration;' . PHP_EOL . PHP_EOL;
            $content .= 'class ' . ucfirst($migrationClassName) . ' extends Migration' . PHP_EOL;
            $content .= '{' . PHP_EOL;
            $content .= '    public function up()' . PHP_EOL;
            $content .= '    {' . PHP_EOL;
            $content .= '        Schema::create(\''.strtolower($this->table_name).'\', function (Blueprint $table) {' . PHP_EOL;
            foreach ($this->fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $options = $field['options'] ?? [];


                if (!empty($options['index_name'])){
                    $content .= '            $table->index(\'' . $field['name'] . '\',\'' . $options['index_name'] . '\')';
                }
                else if (!empty($options['primary_key'])){
                    if(!empty($options['primary_key_name']))
                        $content .= '            $table->id(\'' . $options['primary_key_name'] . '\')';
                    else
                        $content .= '            $table->id()';
                }
                else{
                    if (!empty($field['length']))
                        $content .= '            $table->' . $type . '(\'' . $name . '\','.$field['length'].')';
                    else
                        $content .= '            $table->' . $type . '(\'' . $name . '\')';
                }

                if (!empty($options['nullable']) && $options['nullable'] && $name != 'id') {
                    $content .= '->nullable()';
                }

                if (!empty($options['default'])) {
                    if($options['default'] == 'true')
                        $options['default']=true;

                    else if($options['default'] == 'false')
                        $options['default']=false;

                    $default = !is_bool($options['default']) && is_string($options['default']) && !is_numeric($options['default']) ? '\'' . $options['default'] . '\'' : $options['default'];
                    $content .= '->default(' . $default . ')';
                }
                if (!empty($options['comments'])) {
                    $comments = '\'' . $options['comments'] . '\'';
                    $content .= '->comment(' . $comments . ')';
                }
                if (!empty($options['unique'])) {
                    $content .= '->unique()';
                }

                $content .= ';' . PHP_EOL;
            }
            if(!empty($this->init_params['timestamp']))
                $content .= '            $table->timestamps();' . PHP_EOL;
            if(!empty($this->init_params['soft_delete']))
                $content .= '            $table->softDeletes();' . PHP_EOL;
            $content .= '        });' . PHP_EOL;
            $content .= '    }' . PHP_EOL . PHP_EOL;
            $content .= '    public function down()' . PHP_EOL;
            $content .= '    {' . PHP_EOL;
            $content .= '        Schema::dropIfExists(\''.strtolower($this->table_name).'\');' . PHP_EOL;
            $content .= '    }' . PHP_EOL;
            $content .= '}' . PHP_EOL;

            $migration_status=$this->init_params['migration_status'];
            //if(!empty($migration_status)){

                $this->migration_name=$migration_name;
                $exp=explode("/",$migrPath);
                $len=count($exp);
                $migrationPath=$migration_name;
                if($len > 1){
                    $migrationPath='\\'.implode('\\',$exp).'\\'.$migration_name;
                    $this->migration_folder.='\\'.implode('\\',$exp);
                    $this->migratePath.='\\'.implode('\\',$exp);
                }
                $this->migration_path.=$migrationPath;
                $this->migration_content=$content;
            //}

            return $this;

            //return ['content' => $content,'path' => $migrationPath];
        }
    }
?>

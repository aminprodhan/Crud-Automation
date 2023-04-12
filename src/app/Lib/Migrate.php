<?php
    namespace Aminpciu\CrudAutomation\app\Lib;
    use Illuminate\Support\Facades\File;
    class Migrate{
        public $table_name='';
        public $migration_path='';
        public $migration_content='';
        public $model_name='';
        public $model_path='';
        public $model_namespace='namespace App\Models';
        public $model_content='';
        public $model_folder='';
        public $fields=[];
        public function __construct(){
            $migrationPath = database_path('migrations/');
            $this->migration_path=$migrationPath;
            $this->model_path=base_path('app\Models');
            $this->model_folder=base_path('app\Models');
        }
        public function makeModel(){
            if(empty($this->model_name))
                return false;
            $content = '<?php' . PHP_EOL . PHP_EOL;
            $content .= $this->model_namespace.';' . PHP_EOL;
            $content .= 'use Illuminate\Database\Eloquent\Model;' . PHP_EOL;
            $content .= 'class ' . ucwords($this->model_name) . ' extends Model' . PHP_EOL;
            $content .= '{' . PHP_EOL;
            $content .= '    protected $guarded=[];' . PHP_EOL;
            $content .= '    protected $table=\''.strtolower($this->table_name).'\';' . PHP_EOL. PHP_EOL;
            $content .= '}' . PHP_EOL;
            $this->model_content=$content;
            return $this;
        }
        public function makeMigration(){

            if(empty($this->table_name))
                return false;
            $migrationName = 'create_'.$this->table_name.'_table';
            $migrationPath = $this->migration_path.date('Y_m_d_His') . '_' . $migrationName . '.php';

            $content = '<?php' . PHP_EOL . PHP_EOL;
            $content .= 'use Illuminate\Support\Facades\Schema;' . PHP_EOL;
            $content .= 'use Illuminate\Database\Schema\Blueprint;' . PHP_EOL;
            $content .= 'use Illuminate\Database\Migrations\Migration;' . PHP_EOL . PHP_EOL;
            $content .= 'class ' . ucfirst($migrationName) . ' extends Migration' . PHP_EOL;
            $content .= '{' . PHP_EOL;
            $content .= '    public function up()' . PHP_EOL;
            $content .= '    {' . PHP_EOL;
            $content .= '        Schema::create(\''.$this->table_name.'\', function (Blueprint $table) {' . PHP_EOL;
            foreach ($this->fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $options = $field['options'] ?? [];


                if (isset($options['index_name'])){
                    $content .= '            $table->index(\'' . $field['name'] . '\',\'' . $options['index_name'] . '\')';
                }
                else if (isset($options['primary_key'])){
                    if(isset($options['primary_key_name']))
                        $content .= '            $table->id(\'' . $options['primary_key_name'] . '\')';
                    else
                        $content .= '            $table->id()';
                }
                else{
                    if (isset($field['length']))
                        $content .= '            $table->' . $type . '(\'' . $name . '\','.$field['length'].')';
                    else
                        $content .= '            $table->' . $type . '(\'' . $name . '\')';
                }

                if (isset($options['nullable']) && $options['nullable']) {
                    $content .= '->nullable()';
                }

                if (isset($options['default'])) {
                    if($options['default'] == 'true')
                        $options['default']=true;

                    else if($options['default'] == 'false')
                        $options['default']=false;

                    $default = !is_bool($options['default']) && is_string($options['default']) && !is_numeric($options['default']) ? '\'' . $options['default'] . '\'' : $options['default'];
                    $content .= '->default(' . $default . ')';
                }
                if (isset($options['comments'])) {
                    $comments = '\'' . $options['default'] . '\'';
                    $content .= '->comment(' . $comments . ')';
                }
                if (isset($options['unique'])) {
                    $content .= '->unique()';
                }

                $content .= ';' . PHP_EOL;
            }
            $content .= '            $table->timestamps();' . PHP_EOL;
            $content .= '        });' . PHP_EOL;
            $content .= '    }' . PHP_EOL . PHP_EOL;
            $content .= '    public function down()' . PHP_EOL;
            $content .= '    {' . PHP_EOL;
            $content .= '        Schema::dropIfExists(\'products\');' . PHP_EOL;
            $content .= '    }' . PHP_EOL;
            $content .= '}' . PHP_EOL;

            $this->migration_path=$migrationPath;
            $this->migration_content=$content;

            return $this;

            //return ['content' => $content,'path' => $migrationPath];
        }
    }
?>

<?php
    namespace Aminpciu\CrudAutomation\app\Controllers;
    use Aminpciu\CrudAutomation\app\Controllers\Controller;
    use Aminpciu\CrudAutomation\app\Lib\GenerateMigrationClass;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class TestController extends Controller
    {
        public $generateMigrationClass='';
        public function __construct(GenerateMigrationClass $generateMigrationClass)
        {
            $this->generateMigrationClass=$generateMigrationClass;
        }
        public function index(){

            //echo "test";
            //$path = base_path('database/migrations/myfile.php');
            $fields = [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'description',
                    'type' => 'text',
                ],
                [
                    'name' => 'price',
                    'type' => 'float',
                ],
                [
                    'name' => 'quantity',
                    'type' => 'integer',
                ],
                [
                    'name' => 'active',
                    'type' => 'boolean',
                    'options' => [
                        'default' => true,
                    ],
                ],
                [
                    'name' => 'color',
                    'type' => 'string',
                    'options' => [
                        'nullable' => true,
                    ],
                ],
                [
                    'name' => 'size',
                    'type' => 'string',
                    'options' => [
                        'nullable' => false,
                        'default' => 'medium',
                    ],
                ],
                [
                    'name' => 'tags',
                    'type' => 'json',
                    'options' => [
                        'nullable' => true,
                    ],
                ],
            ];
            $init_params=[
                'model_name' => "Test/Hello/ProductInfo", //default-> (app/Models)
                'table_name' => 'products',
                'migration_path' => '', //database_path('migrations/your_desire_folder_name')
                'fields' => $fields
            ];
            dd($init_params);
            exit;
            $res=$this->generateMigrationClass
                ->init($init_params)
                ->makeMigration()
                ->makeModel()
                ->create();

            // Append to the file
            //File::append($path, 'echo "Hello, world!";' . PHP_EOL);
        }
    }

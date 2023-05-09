# Crud-Automation
Laravel crud-automation is a package that can minimize the development time for crud operation

#install
    composer require aminpciu/crudautomation

#run commands to laravel project
    php artisan vendor:publish --tag=public --force
    php artisan vendor:publish --tag=config

#register this provider to laravel project
    go to app.php file under config folder then add this line to provider array

        Aminpciu\CrudAutomation\app\Providers\DynamicCrudProvider::class
        example:
            'providers' => [
                Aminpciu\CrudAutomation\app\Providers\DynamicCrudProvider::class
            ]
#load GUI interpace
    APP URL/crud-auto/index
    example:
        http://localhost:8000/crud-auto/index
    
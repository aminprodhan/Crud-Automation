# Crud-Automation
Laravel crud-automation is a package that can minimize the development time for crud operation

install

    composer require aminpciu/crudautomation

register this provider to laravel project
    go to app.php file under config folder then add this line to provider array

        Aminpciu\CrudAutomation\app\Providers\DynamicCrudProvider::class
        example:
            'providers' => [
                Aminpciu\CrudAutomation\app\Providers\DynamicCrudProvider::class
            ]

run commands to laravel project

    php artisan vendor:publish --tag=public --force
    php artisan vendor:publish --tag=config
    
run two commands

    composer dump-autoload
    php artisan migrate

load GUI interface

    APP URL/crud-auto/index
    example:
        http://localhost:8000/crud-auto/index

for secure routing
    add middleware name to dynamic_crud_auto_configs table        

for custom mastering

    update (master_blade) column value by your master blade name from dynamic_crud_auto_configs table 
    or empty dynamic_crud_auto_configs table then reload and add middleware name and save
    
    example:
        master blade name means like 
            @extends('admin.layout.master')

    add two lines in <head>

        @include('lca-amin-pciu::layouts.header_script')
        @yield('custom_style_amin_pciu')

        example:
            <head>
                ...
                @include('lca-amin-pciu::layouts.header_script')
                @yield('custom_style_amin_pciu')
            </head>

    add these lines
        @include('lca-amin-pciu::layouts.navbar')
        @yield('content_page_amin_pciu')
        @include('lca-amin-pciu::layouts.footer_script')
        @yield('custom_script_amin_pciu_before_amin_pciu')
        @yield('custom_script_amin_pciu')

        example:
            <body>
                ...
                <div class="container">
                    @include('lca-amin-pciu::layouts.navbar')
                    @yield('content_page_amin_pciu')
                </div>
                @include('lca-amin-pciu::layouts.footer_script')
                @yield('custom_script_amin_pciu_before_amin_pciu')
                @yield('custom_script_amin_pciu')
            </body>

  for reset all data
        empty these three table data
        
       dynamic_crud_auto_configs,dynamic_crud_form_details,dynamic_crud_settings
       
    
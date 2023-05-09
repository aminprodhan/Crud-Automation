# Crud-Automation
Laravel crud-automation is a package that can minimize the development time for crud operation

install

    composer require aminpciu/crudautomation

run commands to laravel project

    php artisan vendor:publish --tag=public --force
    php artisan vendor:publish --tag=config

register this provider to laravel project
    go to app.php file under config folder then add this line to provider array

        Aminpciu\CrudAutomation\app\Providers\DynamicCrudProvider::class
        example:
            'providers' => [
                Aminpciu\CrudAutomation\app\Providers\DynamicCrudProvider::class
            ]
load GUI interface

    APP URL/crud-auto/index
    example:
        http://localhost:8000/crud-auto/index

for custom mastering

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
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Crud Automation')</title>
    @include('lca-amin-pciu::layouts.header_script')
    @yield('custom_style_amin_pciu')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
</head>
<body>
    <div class="container">
        @include('lca-amin-pciu::layouts.navbar')
        @yield('content_page_amin_pciu')
    </div>
    @include('lca-amin-pciu::layouts.footer_script')
    @yield('custom_script_amin_pciu_before_amin_pciu')
    @yield('custom_script_amin_pciu')
</body>
</html>

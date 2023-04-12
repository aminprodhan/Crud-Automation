<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Inspire</title>
    @include('lca-amin-pciu::layouts.header_script')
    @yield('custom_style')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
</head>
<body>
    <div class="container">
        @include('lca-amin-pciu::layouts.navbar')
        <div class="mt-2">
            <div class="card">
                <h5 class="card-header">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            List
                        </div>
                        <div class="">
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                                Create
                              </button>

                        </div>
                    </div>
                </h5>
                <div class="card-body">
                    <div>
                        <table class="table table-bordered border-primary">
                            <tr>
                                <td class="table-primary">SL</td>
                                <td class="table-secondary">Name</td>
                                <td class="table-success">...</td>
                                <td class="table-danger">...</td>
                                <td class="table-warning">...</td>
                                <td class="table-info">...</td>
                                <td class="table-light">...</td>
                                <td class="table-dark">...</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @section("drawer_content")
            @include('lca-amin-pciu::components.form_crud')
        @endsection
        @include('lca-amin-pciu::components.drawer')
    </div>
    @include('lca-amin-pciu::layouts.footer_script')
    @yield('custom_script')
</body>
</html>

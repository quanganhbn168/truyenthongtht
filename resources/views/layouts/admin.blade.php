<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', config('app.name'))</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/adminLTE3/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/bootstrap-icons/bootstrap-icons.min.css')}}">

        <link href="{{asset('plugins/summernote/summernote-bs5.min.css')}}" rel="stylesheet">

        @stack('css')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @include('partials.admin.navbar')
            @include('partials.admin.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h2>@yield('content_header')</h2>
                            </div>
                            <div class="col-sm-6">
                                @include('components.breadcrumb')
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                            <!-- Default box -->
                                @section('content')
                            <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>
            <!-- /.content -->
            </div>
            @include('partials.admin.footer')
        </div>

        <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
        <script src="{{asset('vendor/adminLTE3/js/adminlte.min.js')}}"></script>
        <script src="{{asset('/vendor/bootstrap/popper.min.js')}}?{{time()}}"></script>
        <script src="{{asset('/vendor/bootstrap/js/bootstrap.min.js')}}?{{time()}}"></script>
        <script src="{{asset('plugins/summernote/summernote-bs5.min.js')}}"></script>
        @stack('js')
    </body>
</html>

<!DOCTYPE html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <title>Milo | @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets\images\favicon.ico') }}">
        
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets\css\bootstrap.min.css')  }}" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="{{ asset('assets\css\icons.min.css') }}" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="{{ asset('assets\css\app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('css')
        
    </head>
    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('admin.includes.header')
            @include('admin.includes.slide')
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
                @include('admin.includes.footer')
            </div>
        </div>
        <!-- END layout-wrapper -->

       
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets\libs\jquery\jquery.min.js') }}"></script>
        <script src="{{ asset('assets\libs\bootstrap\js\bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets\libs\metismenu\metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets\libs\simplebar\simplebar.min.js') }}"></script>
        <script src="{{ asset('assets\libs\node-waves\waves.min.js') }}"></script>
        @stack('script')
        <script src="{{ asset('assets\js\app.js') }}"></script>
        @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

        
    </body>

</html>
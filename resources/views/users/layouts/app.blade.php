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
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
        @stack('css')
        
    </head>
    <body class="">
        <div class="wraper">
            @yield('content')
        </div>
        <script src="{{ asset('assets\libs\jquery\jquery.min.js') }}"></script>
        <script src="{{ asset('assets\libs\bootstrap\js\bootstrap.bundle.min.js') }}"></script>
        @stack('js')
    </body>
    
</html>
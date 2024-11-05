<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/css/multi-dropdown.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @flasher_render 
    <style>
        .div_deg{
       
        display:flex;
        justify-content:center;
        align-items: center;
        margin-top: 60px; 
    }
    label{
        display: inline-block;
        width: 200px;
        font-size: 15px;

    }
    input[type='text']{
        width: 200px;
        height: 50px
    }
    
   
    </style>
</head>
<body class="sb-nav-fixed">
    @include('layouts.partials.navbar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('layouts.partials.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')  
            </main>
            @include('layouts.partials.footer')
        </div>
    </div>

    @yield('scripts')
    
    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


    
    <script>
        @flasher_render
    </script>
    
    <script src="{{ asset('assets/auth/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/auth/js/datatables-simple-demo.js') }}"></script>
    <script src="{{ asset('assets/auth/js/multi-dropdown.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>Love'M .... Badge'M.</title>
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')}}" />                
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/main-navigation.css') }}" />     
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />     
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
        
        <script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/03eca4d1ce.js"></script>
        <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/canvas.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>

        @yield('custom-css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
	    <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/favicon.png">
    </head>
    <body>
        @yield('content')

        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>

</html>
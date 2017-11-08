<!DOCTYPE html>
<html>
    <head>
        <title>Badgem Members Home</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

        <script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
        <script src="https://use.fontawesome.com/03eca4d1ce.js"></script>
        <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/canvas.js') }}" type="text/javascript"></script>
        <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        @yield('content')
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>

</html>
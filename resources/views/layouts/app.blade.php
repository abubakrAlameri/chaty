<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon"> --}}
    <link href="{{mix('css/app.css') }}" rel="stylesheet">
    <link href="{{mix('css/custom.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
    @auth
        <script>
             window.auth_id = "{{auth()->user()->id}}";
             window.auth_name = "{{auth()->user()->name}}";
        </script>   
    @endauth
</head>
<body>
    @yield('content')

        <script src="{{ mix('js/app.js')}}"></script>
        <script src="{{ asset('js/view.js')}}"></script>

</body>
</html>
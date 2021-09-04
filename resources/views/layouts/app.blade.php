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
</head>
<body>
    @yield('content')

        <script src="{{ mix('js/app.js')}}"></script>
        <script src="{{ mix('js/view.js')}}"></script>

</body>
</html>
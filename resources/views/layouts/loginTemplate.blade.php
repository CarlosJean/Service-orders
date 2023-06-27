<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        DRL Manufacturing | @yield('title','Acceso')
    </title>


    @vite(['resources/css/azia.min.css','resources/js/app.js','resources/css/login.css'])

</head>

<body class="vh-100">
    @yield('content')
</body>

</html>
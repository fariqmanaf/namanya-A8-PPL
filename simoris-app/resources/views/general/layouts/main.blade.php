<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simoris</title>
    <link rel="icon" href="{{ asset('assets/logo-simoris.png') }}">
    @vite('resources/css/app.css')
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};</style>
</head>
<body class="flex flex-col justify-center items-center h-[100dvh]">
    @include('general.partials.navbar')
    @yield('content')
</body>
</html>
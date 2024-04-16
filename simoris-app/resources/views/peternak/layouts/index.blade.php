<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/logo-simoris.png') }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home</title>
  @vite('resources/css/app.css')
  <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};</style>
</head>
<body class="flex flex-row h-screen bg-[#DDF2FD]">
  @include('peternak.partials.sidebar', ['title' => $title])
  @yield('content')
  {{-- <a href="/mantri/profile"><button>Lihat Profil</button></a>
  <a href="/mantri/profile/edit"><button>Edit Profil</button></a>
  <a href="/mantri/distribusi"><button>Distribusi Stok</button></a> --}}
  {{-- <form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
  </form> --}}
</body>
</html>
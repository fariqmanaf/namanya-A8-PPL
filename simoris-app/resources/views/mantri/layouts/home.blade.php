<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <p>TES WOKAOWKAO</p>
  <p>Ini Halaman Mantri</p>
  <form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
  </form>
  <a href="/mantri/profile"><button>Lihat Profil</button></a>
  <a href="/mantri/profile/edit"><button>Edit Profil</button></a>
  <a href="/mantri/distribusi"><button>Distribusi Stok</button></a>
</body>
</html>
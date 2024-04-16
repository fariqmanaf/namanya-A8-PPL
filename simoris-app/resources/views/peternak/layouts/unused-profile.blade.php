<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lihat Profil</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="w-screen h-screen flex justify-center">
  <div class="form-container flex flex-col gap-5 mb-5 w-56 justify-center">
      <input type="text" name="email" value="{{ $akun->email }}" readonly>
      <input type="text" name="nik" id="" value="{{ $profil->nik }}" readonly>
      <input type="text" name="name" value="{{ $profil->name }}" readonly>
      <input type="text" name="tgl_lahir" value="{{ $profil->tgl_lahir }}" readonly>
      <input type="text" name="no_telp" value="{{ $profil->no_telp }}" readonly>
      <input type="text" name="kabupaten" id="" value="{{ $kabupaten->kabupaten }}" readonly>
      <input type="text" name="kecamatan" id="" value="{{ $kecamatan->kecamatan }}" readonly>
      <input type="text" name="kelurahan" id="" value="{{ $kelurahan->kelurahan }}" readonly>
      <input type="text" name="detail" id="" value="{{ $alamat->detail }}" readonly>
  </div>
</body>
</html>
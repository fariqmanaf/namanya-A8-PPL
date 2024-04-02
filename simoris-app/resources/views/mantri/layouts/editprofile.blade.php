<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Profil</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="w-screen h-screen flex justify-center">
  <div class="form-container flex flex-col gap-5 mb-5 w-52 justify-center">
    @if($errors->any())
      <div class="alert">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(session()->has('success'))
      <div class="bg-slate-400">
        {{ session('success') }}
      </div>
    @endif
    <form action="" method="post" class="justify-center flex flex-col items-center">
      @method('PUT')
      @csrf
      <input class="w-72" type="text" name="email" value="{{ $akun->email }}">
      <input class="w-72" type="text" name="nik" id="" value="{{ $profil->nik }}">
      <input class="w-72" type="text" name="name" value="{{ $profil->name }}">
      <input class="w-72" type="date" name="tgl_lahir" value="{{ $profil->tgl_lahir }}">
      <input class="w-72" type="text" name="no_telp" value="{{ $profil->no_telp }}">
      <select class="w-72" name="kabupaten_id" id="kabupaten">
        @foreach ($kabupaten as $item)
          <option value="{{ $item->id }}">{{ $item->kabupaten }}</option>
        @endforeach
      </select>
      <select class="w-72" name="kecamatan_id" id="kecamatan">
        @foreach ($kecamatan as $item)
          <option value="{{ $item->id }}">{{ $item->kecamatan }}</option>
        @endforeach
      </select>
      <select class="w-72" name="kelurahan_id" id="kelurahan">
        @foreach ($kelurahan as $item)
          <option value="{{ $item->id }}">{{ $item->kelurahan }}</option>
        @endforeach
      </select>
      <input class="w-72" type="text" name="detail" id="" value="{{ $alamat->detail }}">
      <input name="password" class="w-72" type="password" placeholder="Inser New Password Here">
      <button type="submit" class="p-2 mt-8 bg-black text-white">Submit</button>
    </form>
  </div>
</body>
</html>
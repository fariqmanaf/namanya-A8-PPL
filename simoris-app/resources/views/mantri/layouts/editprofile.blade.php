<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Profil</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="flex flex-col h-screen bg-[#DDF2FD] items-center justify-center">

  {{-- error handling --}}
  @if($errors->any())
    <div class="alert absolute top-10 left-10 w-60 text-sm bg-red-500 text-white rounded-xl">
      <ul>
        @foreach($errors->all() as $error)
        <li class="mb-2 ml-2">{{ "- ".$error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if(session()->has('success'))
    <div class="p-1 alert absolute top-10 left-10 w-60 text-sm bg-green-500 text-white rounded-xl">
      {{ session('success') }}
    </div>
  @endif
  {{--  --}}
  
  <a href="/home" class="-ml-[450px] mb-3 font-semibold text-slate-600 2xl:-ml-[600px] 2xl:text-xl">< Kembali</a>
  <div class="flex flex-col bg-white h-[600px] w-[550px] justify-start items-center rounded-2xl shadow-xl 2xl:h-[700px] 2xl:w-[700px]">
    <p class="text-center font-bold text-xl my-3">PROFIL</p>
    <img src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="Logo Dinas" class="h-24 w-24 rounded-full mb-5 border border-black">
    <form action="" method="post" class="justify-center flex flex-col items-center text-xs gap-3 w-10/12 2xl:gap-5">
      <input type="text" name="name" class="font-semibold mb-2 text-sm text-center border-transparent -mt-5 2xl:text-lg" value="{{ $profil->name }}">
      @method('PUT')
      @csrf
      <div class="input1 flex gap-2">
        <div class="tanggal-lahir flex flex-col">
          <label for="">Tanggal Lahir</label>
          <input class="w-[150px] 2xl:w-[215px] text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm" type="date" name="tgl_lahir" value="{{ $profil->tgl_lahir }}">
        </div>
        <div class="nik flex flex-col">
          <label for="">Nomor Induk Kependudukan</label>
          <input class="text-gray-500 w-[315px] 2xl:w-[350px] bg-[#F1F1F1] border-transparent rounded-xl text-sm" type="text" name="nik" id="" value="{{ $profil->nik }}" readonly>
        </div>
      </div>
      <div class="input2 flex gap-2">
        <div class="notelp flex flex-col">
          <label for="">Nomor Telepon</label>
          <input class="w-[180px] 2xl:w-[240px] text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm" type="text" name="no_telp" value="{{ $profil->no_telp }}">
        </div>
        <div class="email flex flex-col">
          <label for="">Email</label>
          <input class="w-[270px] 2xl:w-[330px] text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm" type="text" name="email" value="{{ $akun->email }}">
        </div>
      </div>
      <div class="input3 flex gap-2">
        <div class="kab flex flex-col">
          <label for="">Kabupaten</label>
          <select class="w-[150px] 2xl:w-[186px] text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm" name="kabupaten_id" id="kabupaten">
            @foreach ($kabupaten as $item)
              @dd($alamat->kabupaten['id'])
              <option value="{{ $item->id }}" {{ $profil->alamat->kabupaten['id'] == $item->id ? 'selected' : '' }}>{{ $item->kabupaten }}</option>
            @endforeach
          </select>
        </div>
        <div class="kec flex flex-col">
          <label for="">Kecamatan</label>
          <select class="w-[150px] 2xl:w-[186px] text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm" name="kecamatan_id" id="kecamatan">
            @foreach ($kecamatan as $item)
              <option value="{{ $item->id }}" {{ $kecamatanuser->id == $item->id ? 'selected' : '' }}>{{ $item->kecamatan }}</option>
            @endforeach
          </select>
        </div>
        <div class="kel flex flex-col">
          <label for="">Kelurahan</label>
          <select class="w-[150px] 2xl:w-[186px] text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm" name="kelurahan_id" id="kelurahan">
            @foreach ($kelurahan as $item)
              <option value="{{ $item->id }}" {{ $kelurahanuser->id == $item->id ? 'selected' : '' }}>{{ $item->kelurahan }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="input4 w-full">
        <label for="" class="text-xs">Alamat Lengkap</label>
        <input class="text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm w-full" type="text" name="detail" id="" value="{{ $alamat->detail }}">
      </div>
      <div class="input5 w-full">
        <label for="" class="text-xs">Password</label>
        <a href="/home/profile/changepass" class="w-full"><p id="button" class="text-xs button-pw w-full shadow-[2px_2px_2px_2px_rgba(0,0,0,0.2)] p-2 rounded-xl flex justify-between cursor-pointer 2xl:w-full">Ubah Password <span>></span></p></a>
      </div>
      <button type="submit" class="h-7 w-5/12 mt-3 text-sm bg-[#427D9D] text-white rounded-xl 2xl:h-10 2xl:w-6/12">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
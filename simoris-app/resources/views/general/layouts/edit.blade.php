<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Pengajuan</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="w-screen h-screen flex justify-center flex-row gap-10">
  @if(session()->has('success'))
    <div class="p-1 bg-slate-400">
      {{ session('success') }}
    </div>
  @endif
  <div class="form-container flex flex-col gap-5 mb-5 justify-center ml-8">
      @if($errors->any())
        <div class="text-center">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form action="" method="post" enctype="multipart/form-data" class="w-full justify-center flex flex-col gap-5">
        @method('PUT')
        @csrf
        <input name="no_sertifikasi" type="text" placeholder="No Sertifikasi" value="{{ $sertifikasi->nomor_sertifikasi }}">
        <input name="bukti_sertifikasi" type="file">
        <input type="hidden" name="is_accepted_sertifikasi" value="random">
        <input name="no_suratizin" type="text" placeholder="No Surat Izin" value="{{ $suratizin->nomor_surat }}">
        <input name="bukti_suratizin" type="file">
        <input type="hidden" name="is_accepted_suratizin" value="random">
        <button type="submit" class="p-2 mt-4 bg-black text-white">Submit</button>
      </form>
      <form action="/back" method="POST" class="flex justify-center">
        @csrf
        <button class="p-2 bg-black text-white" type="submit">Batal & Kembali</button>
      </form>
  </div>
  <div class="bukti-container flex flex-col justify-center">
    <img class="h-20 w-20" src="{{ asset('storage/' . $sertifikasi->bukti) }}" alt="Bukti Sertifikasi">
    <img class="h-20 w-20" src="{{ asset('storage/' . $suratizin->bukti) }}" alt="Bukti Surat Izin">
  </div>
</body>
</html>
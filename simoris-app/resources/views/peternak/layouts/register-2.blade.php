@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[90vh] w-screen flex flex-col justify-center items-center">
    @if($errors->any())
      <div class="alert">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="" method="POST" class="flex flex-col gap- justify-center items-center">
      @csrf
      <div class="form-container flex flex-col gap-3 mb-5">
          <input type="text" name="nama" placeholder="Nama Lengkap">
          <input type="text" name="nik" placeholder="NIK : 12361273">
          <input name="tanggal-lahir" type="date">
          <input type="text" name="notelp" placeholder="Nomor Telepon">
          <select name="kabupaten" id="kabupaten">
            @foreach ($kabupaten as $item)
              <option value="{{ $item->id }}">{{ $item->kabupaten }}</option>
            @endforeach
          </select>
          <select name="kecamatan" id="kecamatan">
            @foreach ($kecamatan as $item)
              <option value="{{ $item->id }}">{{ $item->kecamatan }}</option>
            @endforeach
          </select>
          <select name="kelurahan" id="kelurahan">
            @foreach ($kelurahan as $item)
              <option value="{{ $item->id }}">{{ $item->kelurahan }}</option>
            @endforeach
          </select>
          <input type="text" name="detail" placeholder="Jalan, No Rumah, Dll">
          <button type="submit" class="p-2 bg-black text-white">Register</button>
      </div>
    </form>
    <a href="/" class="mt-4 text-center">Kembali</a>
  </div>
@endsection
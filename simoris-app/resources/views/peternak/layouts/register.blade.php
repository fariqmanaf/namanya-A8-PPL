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
    <form action="" method="POST" class="flex flex-col gap-2 justify-center items-center">
      @csrf
      <div class="form-container flex flex-row gap-5 mb-5">
        <div class="container flex flex-col gap-3">
          <input type="text" name="nik" placeholder="NIK : 12361273">
          <input type="email" name="email" class="@error('email') is-invalid @enderror" placeholder="example@mail.com" value="{{ old('email') }}" required>
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <input type="text" name="nama" placeholder="Nama Lengkap" required>
          <input id="tanggal-lahir" type="date">
          <input type="text" name="notelp" placeholder="Nomor Telepon" required>
        </div>
        <div class="container2 flex flex-col gap-3">
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
          <input name="detail" type="text" placeholder="Jalan, No Rumah, Dll">
          <input type="password" class="" name="password" placeholder="*********" required>
          <input type="hidden" value="3" name="roles_id">
          <input type="hidden" value="enable" name="status">
        </div>
      </div>
      <button type="submit" class="p-2 bg-black text-white">Register</button>
    </form>
    <a href="/" class="mt-4">LOGIN</a>
  </div>
@endsection
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
    <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2 justify-center items-center">
      @csrf
      <div class="form-container flex flex-col gap-5 mb-5">
          <label for="wilayah_kerja">Wilayah Kerja</label>
          <select name="wilayah_kerja" id="wilayah_kerja">
            @foreach ($kecamatan as $item)
              <option value="{{ $item->kecamatan }}">{{ $item->kecamatan }}</option>
            @endforeach
          </select>
          <input name="no_sertifikasi" type="text" placeholder="No Sertifikasi">
          <input name="bukti_sertifikasi" type="file">
          <input type="hidden" name="is_accepted_sertifikasi" value="random">
          <input name="no_suratizin" type="text" placeholder="No Surat Izin">
          <input name="bukti_suratizin" type="file">
          <input type="hidden" name="is_accepted_suratizin" value="random">
      </div>
      <button type="submit" class="p-2 bg-black text-white">Register</button>
    </form>
    <a href="/" class="mt-4">Kembali</a>
  </div>
@endsection
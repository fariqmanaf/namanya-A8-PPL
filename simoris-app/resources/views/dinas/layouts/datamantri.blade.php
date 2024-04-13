@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[15vw]">
    <div class="c w-8/12">
      @foreach($dataMantri as $dataMantri)
        <br>
        {{ $dataMantri->name }}
        <br>
        {{ $dataMantri->no_telp }}
        <br>
        {{ $dataMantri->wilayah_kerja }}
        <br>
      @endforeach
      <br>
      @foreach($alamatMantri as $alamatMantri)
        {{ $alamatMantri->detail }}
        <br>
      @endforeach
      <br>
      @foreach($kabupaten as $kabupaten)
        {{ $kabupaten->kabupaten }}
        <br>
      @endforeach
      <br>
      @foreach($kecamatan as $kecamatan)
        {{ $kecamatan->kecamatan }}
        <br>
      @endforeach
      <br>
      @foreach($kelurahan as $kelurahan)
        {{ $kelurahan->kelurahan }}
        <br>
      @endforeach
      <br>
      @foreach($sertifikasi as $sertifikasi)
        {{ $sertifikasi->nomor_sertifikasi }}
        <br>
      @endforeach
      <br>
      @foreach($suratizin as $suratizin)
        {{ $suratizin->nomor_surat }}
        <br>
      @endforeach
    </div>
  </div>
@endsection
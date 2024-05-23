@extends('mantri.layouts.index')

@section('content')
  <div class="container w-[85vw] bg-[#DDF2FD] flex flex-col h-full ml-[20vw]">
    <div class="menu-pintasan ml-12 mt-12">
      <p class="font-bold text-xl mb-3">Menu Pintasan</p>
      <div class="box flex gap-6">
        <a href="/home/laporanIB" class="box-pintasan1 h-44 w-44 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center gap-2 cursor-pointer">
          <img src="{{ asset('/assets/bold/add-ib.svg') }}" alt="">
          <p class="text-center w-11/12 text-[#427D9D] font-semibold">Buat Laporan Inseminasi</p>
        </a>
        <div class="box-pintasan2 h-44 w-44 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center cursor-pointer">
          <img src="{{ asset('/assets/bold/stock-request.svg') }}" alt="" class="my-2">
          <p class="text-center w-11/12 text-[#427D9D] font-semibold">Buat Pengajuan Stok</p>
        </div>
      </div>
    </div>
    <div class="menu-pintasan ml-12 mt-12">
      <p class="font-bold text-xl mb-3">Menu Lainnya</p>
      <div class="box flex gap-6">
        <div class="box-pintasan1 h-44 w-44 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center gap-2 cursor-pointer">
          <img src="{{ asset('/assets/bold/monitor-b.svg') }}" alt="">
          <p class="text-center w-11/12 text-[#427D9D] font-semibold">Lihat Monitoring Distribusi</p>
        </div>
        <div class="box-pintasan2 h-44 w-44 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center cursor-pointer">
          <img src="{{ asset('/assets/bold/document-b.svg') }}" alt="" class="my-2">
          <p class="text-center w-11/12 text-[#427D9D] font-semibold">Riwayat Inseminasi</p>
        </div>
        <div class="box-pintasan2 h-44 w-44 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center cursor-pointer">
          <img src="{{ asset('/assets/bold/document-b.svg') }}" alt="" class="my-2">
          <p class="text-center w-11/12 text-[#427D9D] font-semibold">Riwayat Pengajuan Stok</p>
        </div>
      </div>
    </div>
  </div>
@endsection
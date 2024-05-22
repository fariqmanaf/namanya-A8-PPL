@extends('dinas.layouts.dashboard')

@section('content')
<div class="content-container w-[70vw] bg-[#DDF2FD] flex flex-col h-full ml-[22vw] mt-10">
  <div class="buttonSwap ml-6 font-semibold mb-6">
    <a href="/dashboard/pengajuan-stok"><button id="button1" class="p-1 py-2 w-40 hover:bg-gray-200 bg-white shadow-md rounded-2xl">Pending</button></a>
    <a href="/dashboard/pengajuan-stok/pengambilan"><button id="button2" class="p-1 -ml-5 py-2 hover:bg-gray-200 w-40 bg-white shadow-md rounded-2xl">Pengambilan</button></a>
    <a href=""><button id="button3" class="p-1 -ml-6 py-2  text-white w-40 bg-[#427D9D] shadow-md rounded-2xl">Disetujui</button></a>
    <a href="/dashboard/pengajuan-stok/rejected"><button id="button4" class="p-1 -ml-6 py-2 hover:bg-gray-200 w-40 bg-white shadow-md rounded-2xl">Ditolak</button></a>
  </div>
  <div class="pengambilanContent">
    @foreach($confirmed as $p)
        <div class="flex flex-row justify-between items-center bg-white px-4 py-2 mb-4 ml-6 rounded-2xl" data-id="{{ $p->id }}">
          <div class="content flex flex-row items-center gap-4">
            <div class="pp">
              <img src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="Logo Dinas" class="h-10 w-10 rounded-full border border-gray-400">
            </div>
            <div class="flex flex-col">
              <div class="text text-md p-1 flex-row flex gap-5">
                <div class="nama">
                  <p class="font-semibold">{{ $p->individuals['name'] }}</p>
                  <p class="font-medium text-sm text-gray-500">{{ $p->individuals->wilayah_kerja[0]->kecamatan['kecamatan'] }}</p>
                </div>
                <p class="text-sm">Tanggal <span class="font-semibold">{{ $p->tanggal }}</span></p>
                <p class="px-1 w-40 h-6 text-sm rounded-full text-white font-semibold bg-green-600 text-center">Confirmed</p>
              </div>
              <div class="jenis text-md p-1 flex-row flex gap-3">
                <p class="mr-2">Total 
                  <span class="font-semibold mr-3">
                    {{ $p->total }}
                  </span>|
                </p>
                @foreach($p->detailPengajuan as $detail)
                  <p class="mr-2">{{ $detail->jenisSemen['jenis_semen'] }} 
                    <span class="font-semibold mr-3">
                      {{ $detail->jumlah }}
                    </span>|
                  </p>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endforeach
  </div>

@endsection
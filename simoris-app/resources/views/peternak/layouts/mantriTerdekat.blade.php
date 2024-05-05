@extends('peternak.layouts.index')

@section('content')

  <div class="container w-[85vw] bg-[#DDF2FD] flex flex-col h-full ml-[20vw] mt-[8vh]">
    <div class="content-container flex flex-col ml-28 w-[80%] h-auto">
      <div class="header flex flex-row justify-between">
        <p class="font-bold text-xl text-[#164863] mb-8">Daftar Mantri Terdekat</p>
        <a href="/main/data-mantri"><p class="relative right-[10%] text-md font-semibold 2xl:text-xl 2xl:right-[600px]"><  Kembali</p></a>
      </div>
      @foreach($mantriTerdekat as $mantri)
        <div class="card flex flex-row justify-between items-center p-2 mb-4 rounded-2xl">
          <div class="text text-md p-1">
            <p class="font-semibold">Nama: <span class="font-normal">{{ $mantri->name }}</span></p>
            <p class="font-semibold">Alamat: 
              <span class="font-normal">
                {{ $mantri->alamat['detail'] }},
                {{ $mantri->alamat->kelurahan['kelurahan'] }},
                {{ $mantri->alamat->kecamatan['kecamatan'] }},
                {{ $mantri->alamat->kabupaten['kabupaten'] }}
              </span>
            </p>
          </div>
          <a 
            id="phone-number" 
            href="https://api.whatsapp.com/send?phone={{ $mantri->no_telp }}" 
            target="_blank" 
            class="w-60 text-center flex items-center justify-center h-8 bg-blue-600 hover:bg-blue-800 text-white font-semibold rounded-full text-sm">
            Hubungi via WhatsApp
          </a>
        </div>
      @endforeach
    </div>
  </div>
  <script>
    var phoneNumberElements = document.querySelectorAll("#phone-number");
    phoneNumberElements.forEach(function(element) {
        var phoneNumber = element.getAttribute("href");
        phoneNumber = phoneNumber.replace("0", '62');
        element.setAttribute("href", phoneNumber);
    });
  </script>
@endsection
@extends('peternak.layouts.index')

@section('content')

  <div class="container w-[85vw] bg-[#DDF2FD] flex flex-col h-full ml-[20vw] mt-[8vh]">
    <div class="content-container flex flex-col items-center">
      <p class="font-bold">Daftar Mantri Terdekat:</p>
      @foreach($mantriTerdekat as $mantriTerdekat)
  
        <p>Nama: {{ $mantriTerdekat->name }}</p>
        <p>Alamat: 
          {{ $mantriTerdekat->alamat['detail'] }},
          {{ $mantriTerdekat->alamat->kelurahan['kelurahan'] }},
          {{ $mantriTerdekat->alamat->kecamatan['kecamatan'] }},
          {{ $mantriTerdekat->alamat->kabupaten['kabupaten'] }}
        </p>
        <a id="phone-number" href="https://api.whatsapp.com/send?phone=62{{ $mantriTerdekat->no_telp }}" target="_blank" class="p-2 bg-blue-600 text-white font-semibold rounded-2xl">Hubungi via WhatsApp</a>
  
      @endforeach
      <p class="font-bold">Daftar Mantri Lengkap:</p>
      @foreach($mantri as $mantriLengkap)
  
        <p>Nama: {{ $mantriLengkap->name }}</p>
        <p>Alamat: 
          {{ $mantriLengkap->alamat['detail'] }},
          {{ $mantriLengkap->alamat->kelurahan['kelurahan'] }},
          {{ $mantriLengkap->alamat->kecamatan['kecamatan'] }},
          {{ $mantriLengkap->alamat->kabupaten['kabupaten'] }}
        </p>
        <a id="phone-number" href="https://api.whatsapp.com/send?phone=62{{ $mantriLengkap->no_telp }}" target="_blank" class="p-2 bg-blue-600 text-white font-semibold rounded-2xl">Hubungi via WhatsApp</a>
      
      @endforeach
    </div>
  </div>
  <script>
    var phoneNumberElements = document.querySelectorAll("#phone-number");
    phoneNumberElements.forEach(function(element) {
        var phoneNumber = element.getAttribute("href");
        phoneNumber = phoneNumber.replace("0", '');
        element.setAttribute("href", phoneNumber);
    });
  </script>
@endsection
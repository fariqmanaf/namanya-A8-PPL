@extends('peternak.layouts.index')

@section('content')

  <div class="container w-[85vw] bg-[#DDF2FD] flex flex-col h-full ml-[20vw] mt-[8vh]">
    <div class="content-container flex flex-col ml-28 w-[80%] h-auto">
      <p class="font-bold text-xl text-[#164863] mb-8">Daftar Mantri Terdekat</p>

      @foreach($mantriTerdekat as $mantrinear)
        <div class="flex flex-row justify-between items-center  bg-white px-4 py-2 mb-4 rounded-2xl">
          <div class="flex flex-row items-center gap-5">
            <img class="dinas h-12 w-12 rounded-full ml-3 bg-gray-300 p-2" src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="profile">
            <div class="text text-md p-1">
              <p class="font-semibold">{{ $mantrinear->name }}</p>
              <p class="font-semibold text-sm">{{ $mantrinear->alamat->kecamatan['kecamatan'] }}</p>
              <p class="text-sm">
                  {{ $mantrinear->alamat['detail'] }},
                  {{ $mantrinear->alamat->kelurahan['kelurahan'] }},
                  {{ $mantrinear->alamat->kecamatan['kecamatan'] }},
                  {{ $mantrinear->alamat->kabupaten['kabupaten'] }}
              </p>
            </div>
          </div>
          <a 
            id="phone-number" 
            href="https://api.whatsapp.com/send?phone={{ $mantrinear->no_telp }}" 
            target="_blank" 
            class="w-10 text-center flex items-center justify-center h-10 bg-[#427D9D] hover:bg-blue-800 text-white font-semibold rounded-xl text-sm">
            <img src="{{asset('/assets/outline/call-o.svg')}}" alt="" height="20" width="20">
          </a>
        </div>
      @endforeach
      
      <p class="font-bold text-xl text-[#164863] mb-8 mt-4">Daftar Mantri Jember</p>
      @foreach($mantri as $mantriLengkap)
        <div class="flex flex-row justify-between items-center bg-white px-4 py-2 mb-4 rounded-2xl">
          <div class="flex flex-row items-center gap-5">
            <img class="h-12 w-12 rounded-full ml-3 bg-gray-300 p-2" src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="profile">
            <div class="text text-md p-1">
              <p class="font-semibold">{{ $mantriLengkap->name }}</p>
              <p class="font-semibold text-sm">{{ $mantriLengkap->alamat->kecamatan['kecamatan'] }}</p>
              <p class="text-sm">
                {{ $mantriLengkap->alamat['detail'] }},
                {{ $mantriLengkap->alamat->kelurahan['kelurahan'] }},
                {{ $mantriLengkap->alamat->kecamatan['kecamatan'] }},
                {{ $mantriLengkap->alamat->kabupaten['kabupaten'] }}
              </p>
            </div>
          </div>
          <a 
            id="phone-number" 
            href="https://api.whatsapp.com/send?phone={{ $mantriLengkap->no_telp }}" 
            target="_blank" 
            class="w-10 text-center flex items-center justify-center h-10 bg-[#427D9D] hover:bg-blue-800 text-white font-semibold rounded-xl text-sm">
            <img src="{{asset('/assets/outline/call-o.svg')}}" alt="" height="20" width="20">
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
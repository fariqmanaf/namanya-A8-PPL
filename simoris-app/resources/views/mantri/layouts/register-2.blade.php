@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[100dvh] w-screen flex flex-col justify-center items-center bg-[#DDF2FD]">
    @if($errors->any())
      <div class="alert absolute z-20 top-24 left-10">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    
    <img src="{{asset("assets/bg.png")}}" class="z-0 absolute top-0 mt-7 w-full" alt="">
    <a href="/register/mantri/step-1" class="mb-2 z-10 mr-80 2xl:mr-[470px] 2xl:text-xl">< Kembali</a>
    <div class="form-regist2 z-10 w-[434px] h-[520px] bg-[#FFFF] rounded-2xl shadow-xl">
      <p class="text-center py-6 text-2xl font-bold text-[#427D9D] 2xl:py-8">Yuk Lengkapi Datamu!</p>
      <form action="" method="POST" class="flex flex-col justify-center items-center">
        @csrf
        <div class="form-container flex flex-col gap-3 mb-5 items-center 2xl:gap-6">
            <input class="input-regist2 w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-sm" type="text" name="nama" placeholder="Nama Lengkap" value="{{ session('registration.nama') }}">
            <input class="input-regist2 w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-sm" type="text" name="nik" placeholder="NIK" value="{{ session('registration.nik') }}">
            <input
              class="input-regist2 w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-sm" 
              name="tanggal-lahir" 
              type="text"
              placeholder="Tanggal Lahir"
              onfocus="(this.type='date')"
              onblur="(this.type='text')" 
              value="{{ session('registration.tanggal-lahir') }}">
            <input class="input-regist2 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl" type="text" name="notelp" placeholder="Nomor Telepon" value="{{ session('registration.notelp') }}">
            <select selected="Kabupaten" name="kabupaten" id="kabupaten" class="input-regist2 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
              <option value="" disabled selected>Kabupaten</option>
              @foreach ($kabupaten as $item)
                <option value="{{ $item->id }}" value="{{ $item->id }}" {{ session('registration.kabupaten') == $item->id ? 'selected' : '' }}>{{ $item->kabupaten }}</option>
              @endforeach
            </select>
            <div class="keckel flex gap-5">
              <select class="cut-regist2 text-sm w-[157px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]" name="kecamatan" id="kecamatan">
                <option value="" disabled selected>Kecamatan</option>
                @foreach ($kecamatan as $item)
                  <option data-kecamatan="{{ $item->id }}" value="{{ $item->id }}" value="{{ $item->id }}" {{ session('registration.kecamatan') == $item->id ? 'selected' : '' }}>{{ $item->kecamatan }}</option>
                @endforeach
              </select>
              <select class="cut-regist2 text-sm w-[157px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]" name="kelurahan" id="kelurahan">
                <option value="" disabled selected>Kelurahan</option>
                @foreach ($kelurahan as $item)
                  <option data-kelurahan="{{ $item->kecamatan_id }}" value="{{ $item->id }}" value="{{ $item->id }}" {{ session('registration.kelurahan') == $item->id ? 'selected' : '' }}>{{ $item->kelurahan }}</option>
                @endforeach
              </select>
            </div>
            <input class="input-regist2 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl" type="text" name="detail" placeholder="Detail Alamat" value="{{ session('registration.detail') }}">
            <button type="submit" class="input-regist2 p-2 w-[334px] bg-[#427D9D] text-white border-transparent rounded-xl mt-2">Lanjut</button>
        </div>
      </form>
    </div>
  </div>
  <script>
        const kecamatan = document.getElementById('kecamatan');
    const kelurahan = document.getElementById('kelurahan');
    kecamatan.addEventListener('change', function() {
      const kecamatan_id = this.options[this.selectedIndex].getAttribute('data-kecamatan');
      const kelurahan_options = kelurahan.querySelectorAll('option');
      kelurahan_options.forEach(option => {
        if(option.getAttribute('data-kelurahan') == kecamatan_id) {
          option.style.display = 'block';
        } else {
          option.style.display = 'none';
        }
      });
    });
  </script>
@endsection
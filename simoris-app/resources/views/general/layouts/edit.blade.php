@extends('general.layouts.main')

@section('content')
<div class="formcontainer h-[100dvh] w-screen flex flex-col justify-center items-center bg-[#DDF2FD]">

  @if(session()->has('success'))
    <div class="p-1 bg-slate-400">
      {{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div class="text-center">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
      
  <img src="{{asset("assets/bg.png")}}" class="z-0 absolute top-0 mt-7 w-full" alt="">
  <div class="form-regist1 z-10 w-[434px] h-[434px] bg-[#FFFF] rounded-2xl shadow-xl">
  <form action="" method="post" enctype="multipart/form-data" class="w-full justify-center flex flex-col gap-5">
    @method('PUT')
    @csrf
    <input name="no_sertifikasi" type="text" placeholder="No Sertifikasi" value="{{ $sertifikasi->nomor_sertifikasi }}">
    <input name="bukti_sertifikasi" type="file">
    <input type="hidden" name="is_accepted_sertifikasi" value="random">
    <input name="no_suratizin" type="text" placeholder="No Surat Izin" value="{{ $suratizin->nomor_surat }}">
    <input name="bukti_suratizin" type="file">
    <input type="hidden" name="is_accepted_suratizin" value="random">
    <button type="submit" class="p-2 mt-4 bg-black text-white">Submit</button>
  </form>
  <form action="/back" method="POST" class="flex justify-center">
    @csrf
    <button class="p-2 bg-black text-white" type="submit">Batal & Kembali</button>
  </form>
  </div>
</div>
  {{-- <div class="bukti-container flex flex-col justify-center">
    <img class="h-20 w-20" src="{{ asset('storage/' . $sertifikasi->bukti) }}" alt="Bukti Sertifikasi">
    <img class="h-20 w-20" src="{{ asset('storage/' . $suratizin->bukti) }}" alt="Bukti Surat Izin">
  </div> --}}
</div>
@endsection
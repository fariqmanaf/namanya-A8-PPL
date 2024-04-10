@extends('general.layouts.main')

@section('content')
  <div class="register formcontainer h-[100dvh] w-screen flex flex-col gap-10 justify-center items-center bg-[#DDF2FD]">
    <img src="{{asset("assets/bg.png")}}" class="z-0 absolute top-0 mt-7 w-full" alt="">
    <div class="z-10 flex flex-col justify-center items-center size-[27rem] 2xl:size-[38rem] bg-white shadow-lg rounded-2xl 2xl:rounded-3xl">
      <div class="mt-16 2xl:mt-24">
        <p class="text-[#427D9D] text-2xl 2xl:text-3xl font-semibold text-center">Ingin Daftar Sebagai Apa?</p>
        <div class="flex gap-11 mt-5 2xl:mt-7">
          <a href="/register/peternak/step-1" class="btn-choose-role">
            <img class="h-14 2xl:h-20" src="{{asset("assets/icon/farmer-icon.svg") }}" alt="">
            Peternak
          </a>
          <a href="/register/mantri/step-1" class="btn-choose-role">
          <img class="h-14 2xl:h-20" src="{{asset("assets/icon/mantri-icon.svg") }}" alt="">
            Mantri
          </a>
        </div>
        <p class="flex flex-col text-sm 2xl:text-lg font-medium text-black/45 text-center mt-16 2xl:mt-24">
          Sudah punya akun? 
          <a href="/" class="underline text-[#164863] hover:text-[#5c7281] font-semibold">Masuk</a>
        </p>
      </div>
    </div>
  </div>
@endsection
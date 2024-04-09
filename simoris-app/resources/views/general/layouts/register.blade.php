@extends('general.layouts.main')

@section('content')
  <div class="register formcontainer h-[100dvh] w-screen flex flex-col gap-10 justify-center items-center bg-slate-400">
    <div class="flex flex-col justify-center items-center size-[27rem] 2xl:size-[38rem] bg-white shadow-lg rounded-2xl 2xl:rounded-3xl">
      <!-- <p>Ingin Daftar Sebagai Apa?</p> -->
      <div class="btn-choose-role">
        <a href="/register/mantri/step-1" class="p-2 bg-black text-white">Daftar Sebagai Mantri</a>
        <a href="/register/peternak/step-1" class="p-2 bg-black text-white">Daftar Sebagai Peternak</a>
      </div>
    </div>
  </div>
@endsection
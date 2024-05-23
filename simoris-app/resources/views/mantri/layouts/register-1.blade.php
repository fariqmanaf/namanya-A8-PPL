@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[100dvh] w-screen flex flex-col justify-center items-center bg-[#DDF2FD]">
    <img src="{{asset("assets/bg.png")}}" class="z-0 absolute top-0 mt-7 w-full" alt="">
    
    <a href="/" class="mb-2 z-10 mr-80 2xl:mr-[470px] 2xl:text-xl">< Kembali</a>
    <div class="form-regist1 z-10 w-[434px] h-[434px] bg-[#FFFF] rounded-2xl shadow-xl">
      <p class="text-center py-10 text-2xl font-bold text-[#427D9D] 2xl:text-2xl 2xl:py-12">Registrasi Akun</p>
      <form action="" method="POST" class="flex flex-col gap-2 justify-center items-center">
        @csrf
        <div class="flex flex-col gap-5 mb-8">
          <div class="container flex flex-col gap-6 2xl:gap-10">
            <input type="email" class="input-regist1 w-[334px] bg-[#F1F1F1] border-transparent rounded-xl" name="email" placeholder="Email" value="{{ session('registration.email') }}" autofocus required>
            <input type="password" class="input-regist1 w-[334px] bg-[#F1F1F1] border-transparent rounded-xl" name="password" placeholder="Password" value="{{ session('registration.password') }}" required>
            <input type="password" class="input-regist1 w-[334px] bg-[#F1F1F1] border-transparent rounded-xl" name="verifiedpw" placeholder="Verify Password" required>
          </div>
          <input type="hidden" value="random" name="roles_id">
          <input type="hidden" value="random" name="status">
        </div>
        <button type="submit" class="input-regist1 p-2 w-[334px] bg-[#427D9D] text-white border-transparent rounded-xl 2xl:mt-2">Lanjut</button>
      </form>
    </div>
  </div>
@endsection
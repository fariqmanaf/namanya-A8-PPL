@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[100dvh] w-screen flex flex-row justify-center items-center bg-[#DDF2FD] gap-x-24 2xl:gap-x-48 inset-x-0 px-10">

    <img src="{{asset("assets/bg-hero.png")}}" class="absolute z-0 w-full top-0" alt="bg-hero">

    <div class="z-10 flex flex-col w-[40rem] 2xl:w-[864px] inset-x-7">
      <h1 class="text-6xl 2xl:text-7xl font-bold tracking-widest text-[#164863] -mb-2">SIMORIS</h1>
      <h2 class="text-2xl 2xl:text-4xl font-medium tracking-tighter text-[#164863]">Sistem Monitoring Distribusi Inseminasi Buatan</h2>
      <p class="text-base 2xl:text-2xl font-light mt-2 2xl:mt-4 text-[#427D9D] text-justify">
        SIMORIS adalah sistem informasi berbasis website yang dirancang khusus untuk mempermudah pemantauan stok semen beku yang akan didistribusikan kepada mantri. Dengan SIMORIS, membantu proses bisnis pada sektor peternakan sapi menjadi lebih mudah dan efisien.
      </p>
      <span class="text-base 2xl:text-2xl font-medium mt-2 2xl:mt-4 text-[#427D9D]">#SIMORIS-Pantau Stok, Tingkatkan Produktivitas!</span>
    </div>

    <div class="z-10 flex flex-col justify-center items-center size-[27rem] 2xl:size-[38rem] bg-white rounded-2xl 2xl:rounded-3xl shadow-lg">
      <h1 class="text-2xl 2xl:text-4xl font-semibold text-[#427D9D] mb-11">Selamat Datang<span class="text-[#164863]">.</span></h1>
      <form action="" method="POST" class="flex flex-col gap-y-9">
        @csrf
        <input type="email" class="@error('email') is-invalid @enderror w-80 h-11 rounded-lg 2xl:w-96 2xl:h-14 2xl:rounded-xl" name="email" placeholder="example@mail.com" value="{{ old('email') }}" autofocus required>
        <input type="password" class="w-80 h-11 rounded-lg 2xl:w-96 2xl:h-14 2xl:rounded-xl" name="password" placeholder="*********" required>
        <a href="" class="text-xs 2xl:text-base font-medium text-black/50 hover:text-black/65 right-0 text-right -mt-7">Lupa Password?</a>
        <button type="submit" class="btn-login">Login</button>
      </form>
      <div class="flex flex-col justify-center items-center mt-8">
        <p class="text-black/60 text-xs 2xl:text-lg font-medium">Belum punya akun?</p>
        <a href="/register" class="underline text-xs 2xl:text-lg font-semibold text-[#164863] hover:text-[#5c7281] ease-in-out duration-100">Registrasi</a>
      </div>
      
    </div>

  </div>
@endsection
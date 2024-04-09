@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[100dvh] w-screen flex flex-row justify-center items-center bg-[#DDF2FD] gap-x-24 2xl:gap-x-48 inset-x-0 px-10">
    @if($errors->any())
      <div class="alert">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(session()->has('success'))
      <div class="p-1 bg-slate-400">
        {{ session('success') }}
      </div>
    @endif
    @if(session()->has('update'))
      <div class="p-1 bg-slate-400">
        {{ session('update') }}
      </div>
    @endif

    <div class="flex flex-col w-[40rem] 2xl:w-[864px] inset-x-7">
      <h1 class="text-6xl 2xl:text-7xl font-bold tracking-widest text-[#164863] -mb-2">SIMORIS</h1>
      <h2 class="text-2xl 2xl:text-4xl font-medium tracking-tighter text-[#164863]">Sistem Monitoring Distribusi Inseminasi Buatan</h2>
      <p class="text-base 2xl:text-2xl font-light mt-2 2xl:mt-4 text-[#427D9D]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer elementum purus quis ultricies luctus. Quisque a risus urna. Cras eget ullamcorper massa, a laoreet enim.</p>
    </div>

    <div class="flex flex-col justify-center items-center size-[27rem] 2xl:size-[38rem] bg-white rounded-3xl shadow-lg">
      <h1 class="text-2xl 2xl:text-4xl font-semibold text-[#427D9D] mb-11">Selamat Datang<span class="text-[#164863]">.</span></h1>
      <form action="" method="POST" class="flex flex-col gap-y-9">
        @csrf
        <input type="email" class="@error('email') is-invalid @enderror w-80 h-11 rounded-lg 2xl:w-96 2xl:h-14 2xl:rounded-xl" name="email" placeholder="example@mail.com" value="{{ old('email') }}" autofocus required>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <input type="password" class="w-80 h-11 rounded-lg 2xl:w-96 2xl:h-14 2xl:rounded-xl" name="password" placeholder="*********" required>
        <a href="" class="text-xs 2xl:text-base font-medium text-black/50 hover:text-black/65 right-0 text-right -mt-7">Lupa Password?</a>
        <button type="submit" class="p-2 bg-[#427D9D] hover:bg-[#33617a] ease-in-out duration-100 text-white text-lg 2xl:text-2xl font-semibold w-80 h-11 rounded-lg 2xl:w-96 2xl:h-14 2xl:rounded-xl">Masuk</button>
      </form>
      <div class="flex flex-col justify-center items-center mt-8">
        <p class="text-black/60 text-xs 2xl:text-lg font-medium">Belum punya akun?</p>
        <a href="/register" class="underline text-xs 2xl:text-lg font-semibold text-[#164863] hover:text-[#5c7281] ease-in-out duration-100">Daftar Sekarang</a>
      </div>
      
    </div>

  </div>
@endsection
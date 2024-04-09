@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[100dvh] w-full flex flex-row justify-center items-center bg-[#DDF2FD] gap-48">
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

    <div class="flex flex-col w-[864px] inset-x-7">
      <h1 class="text-7xl font-bold tracking-widest text-[#164863] -mb-2">SIMORIS</h1>
      <h2 class="text-4xl font-medium text-[#164863]">Sistem Monitoring Distribusi Inseminasi Buatan</h2>
      <p class="text-2xl font-light mt-4 text-[#427D9D]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer elementum purus quis ultricies luctus. Quisque a risus urna. Cras eget ullamcorper massa, a laoreet enim.</p>
    </div>

    <div class="flex flex-col justify-center items-center size-[63dvh] bg-white rounded-3xl shadow-lg">
      <h1 class="text-4xl font-semibold text-[#427D9D] mb-16">Selamat Datang<span class="text-[#164863]">.</span></h1>
      <form action="" method="POST" class="flex flex-col gap-y-9">
        @csrf
        <input type="email" class="@error('email') is-invalid @enderror w-96 h-14 rounded-xl" name="email" placeholder="example@mail.com" value="{{ old('email') }}" autofocus required>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <input type="password" class="w-96 h-14 rounded-xl" name="password" placeholder="*********" required>
        <a class="text-base font-medium text-black/50 hover:text-black/65 right-0 text-right -mt-7">Lupa Password?</a>
        <button type="submit" class="p-2 bg-[#427D9D] hover:bg-[#33617a] ease-in-out duration-100 text-white text-2xl font-semibold w-96 h-14 rounded-xl">Masuk</button>
      </form>
      <div class="flex flex-col justify-center items-center mt-8">
        <p class="text-black/60 text-lg font-medium">Belum punya akun?</p>
        <a href="/register" class="underline text-lg font-semibold text-[#164863] hover:text-[#5c7281] ease-in-out duration-100">Daftar Sekarang</a>
      </div>
      
    </div>

  </div>
@endsection
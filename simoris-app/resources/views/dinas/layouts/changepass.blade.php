@extends('dinas.layouts.dashboard')

@section('content')
  <div class="form-container flex flex-col gap-5 mb-5 w-52 justify-center ml-[45vw]">
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
      <div class="bg-slate-400">
        {{ session('success') }}
      </div>
    @endif
    <form action="" method="post" class="justify-center flex flex-col items-center">
      @method('PUT')
      @csrf
      <input name="password" class="w-72" type="password" placeholder="Inser New Password Here">
      <input type="password" class="w-72" name="validation-password" placeholder="Confirmation Your Password">
      <button type="submit" class="p-2 mt-8 bg-black text-white">Submit</button>
    </form>
  </div>
@endsection
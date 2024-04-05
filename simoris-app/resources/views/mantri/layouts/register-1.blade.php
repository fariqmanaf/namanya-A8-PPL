@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[90vh] w-screen flex flex-col justify-center items-center">
    @if($errors->any())
      <div class="alert">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="" method="POST" class="flex flex-col gap-2 justify-center items-center">
      @csrf
      <div class="form-container flex flex-row gap-5 mb-5">
        <div class="container flex flex-col gap-3">
          <input type="email" class="@error('email') is-invalid @enderror" name="email" placeholder="example@mail.com" value="{{ old('email') }}" autofocus required>
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <input type="password" class="" name="password" placeholder="*********" required>
        </div>
        <input type="hidden" value="random" name="roles_id">
        <input type="hidden" value="random" name="status">
      </div>
      <button type="submit" class="p-2 bg-black text-white">Lanjut</button>
    </form>
    <a href="/" class="mt-4">Kembali</a>
  </div>
@endsection
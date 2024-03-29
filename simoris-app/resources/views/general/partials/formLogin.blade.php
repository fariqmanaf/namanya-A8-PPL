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
    <form action="" method="POST" class="flex flex-col gap-5">
      @csrf
      <input type="email" class="@error('email') is-invalid @enderror" name="email" placeholder="example@mail.com" value="{{ old('email') }}" autofocus required>
      @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      <input type="password" class="" name="password" placeholder="*********" required>
      <button type="submit" class="p-2 bg-black text-white">Login</button>
    </form>
  </div>
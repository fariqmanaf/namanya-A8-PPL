<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Profil</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="w-screen h-screen flex justify-center">
  <div class="form-container flex flex-col gap-5 mb-5 w-52 justify-center">
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
</body>
</html>